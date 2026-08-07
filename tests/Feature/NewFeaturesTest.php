<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendTicketEmail;
use App\Mail\TicketConfirmationMail;
use Tests\TestCase;

class NewFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_has_status_and_scope_in_peserta(): void
    {
        $draftEvent = Event::create([
            'slug' => 'draft-event',
            'title' => 'Draft Event',
            'date' => '2026-08-10',
            'location' => 'Jakarta',
            'desc' => 'Test description',
            'price' => 100000,
            'quota' => 50,
            'status' => Event::STATUS_DRAFT,
        ]);

        $publishedEvent = Event::create([
            'slug' => 'published-event',
            'title' => 'Published Event',
            'date' => '2026-08-10',
            'location' => 'Jakarta',
            'desc' => 'Test description',
            'price' => 100000,
            'quota' => 50,
            'status' => Event::STATUS_PUBLISHED,
        ]);

        $response = $this->get('/peserta');
        $response->assertStatus(200);
        $response->assertSee('Published Event');
        $response->assertDontSee('Draft Event');

        $this->get('/peserta/' . $publishedEvent->slug)->assertStatus(200);
        $this->get('/peserta/' . $draftEvent->slug)->assertStatus(404);
    }

    public function test_ticket_email_is_dispatched_and_sent(): void
    {
        Mail::fake();
        Queue::fake();

        $event = Event::create([
            'slug' => 'published-event',
            'title' => 'Published Event',
            'date' => '2026-08-10',
            'location' => 'Jakarta',
            'desc' => 'Test description',
            'price' => 100000,
            'quota' => 50,
            'status' => Event::STATUS_PUBLISHED,
        ]);

        User::create([
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'password' => bcrypt('password'),
            'role' => 'client',
        ]);

        $this->post('/client/login', [
            'email' => 'client@example.com',
            'password' => 'password',
        ]);

        $this->withSession([
            'peserta_form' => [
                'name' => 'Fathir',
                'email' => 'fathir@example.com',
                'phone' => '0812345678',
                'instansi' => 'Tech Corp',
            ],
            'peserta_event_id' => $event->id,
        ]);

        $response = $this->post("/peserta/{$event->slug}/confirm");
        $response->assertRedirect();

        Queue::assertPushed(SendTicketEmail::class);
    }

    public function test_admin_actions_are_audit_logged(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@eventflow.id',
            'password' => bcrypt('admin123'),
            'role' => 'superadmin',
        ]);

        $this->actingAs($admin);
        $this->withSession(['admin_logged_in' => true]);

        $this->post('/admin/events', [
            'title' => 'Audit Event',
            'speaker' => 'Speaker Audit',
            'time_slot' => '10.00 WIB',
            'date' => '2026-10-10',
            'location' => 'Jakarta',
            'desc' => 'Description test',
            'price' => 50000,
            'quota' => 100,
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $admin->id,
            'action' => 'create_event',
        ]);

        $event = Event::where('title', 'Audit Event')->first();
        $this->assertNotNull($event);

        $this->put("/admin/events/{$event->id}", [
            'title' => 'Audit Event Updated',
            'date' => '2026-10-10',
            'location' => 'Jakarta',
            'price' => 60000,
            'quota' => 120,
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $admin->id,
            'action' => 'update_event',
        ]);
    }

    public function test_published_events_are_cached_and_invalidated_on_crud(): void
    {
        Event::create([
            'slug' => 'cache-event',
            'title' => 'Cache Event',
            'date' => '2026-08-10',
            'location' => 'Surakarta',
            'desc' => 'Cache test',
            'price' => 50000,
            'quota' => 50,
            'status' => Event::STATUS_PUBLISHED,
        ]);

        $this->get('/peserta')->assertSee('Cache Event');
        $this->assertTrue(\Illuminate\Support\Facades\Cache::has('events.published'));

        $admin = User::create([
            'name' => 'Admin Cache',
            'email' => 'admincache@eventflow.id',
            'password' => bcrypt('admin123'),
            'role' => 'superadmin',
        ]);
        $this->actingAs($admin);
        $this->withSession(['admin_logged_in' => true]);

        $this->post('/admin/events', [
            'title' => 'New Cache Event',
            'speaker' => 'Speaker Cache',
            'time_slot' => '10.00 WIB',
            'date' => '2026-10-10',
            'location' => 'Solo',
            'desc' => 'Description test',
            'price' => 50000,
            'quota' => 100,
            'status' => 'published',
        ]);

        $this->assertFalse(\Illuminate\Support\Facades\Cache::has('events.published'));
    }
}
