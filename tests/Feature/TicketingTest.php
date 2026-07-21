<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketingTest extends TestCase
{
    use RefreshDatabase;

    public function test_peserta_can_view_index_page(): void
    {
        $response = $this->get('/peserta');
        $response->assertStatus(200);
    }

    public function test_peserta_can_view_search_order_page(): void
    {
        $response = $this->get('/peserta/cek-pesanan');
        $response->assertStatus(200);
    }

    public function test_peserta_can_view_event_detail_and_register(): void
    {
        $event = Event::create([
            'slug' => 'test-event',
            'title' => 'Test Event 2026',
            'speaker' => 'Ustadz Test',
            'time_slot' => '10.00 WIB',
            'date' => '2026-08-01',
            'location' => 'Jakarta',
            'desc' => 'Test description',
            'price' => 100000,
            'quota' => 50,
        ]);

        $this->get('/peserta/' . $event->id)->assertStatus(200);
        $this->get('/peserta/' . $event->id . '/daftar')->assertStatus(200);

        $postData = [
            'name' => 'Ahmad Fathir',
            'email' => 'ahmad@example.com',
            'phone' => '08123456789',
            'instansi' => 'Komunitas Tech',
        ];

        $response = $this->post('/peserta/' . $event->id . '/daftar', $postData);
        $response->assertRedirect(route('peserta.review', $event));

        $this->get('/peserta/' . $event->id . '/review')->assertStatus(200);
        $this->get('/peserta/' . $event->id . '/bayar')->assertStatus(200);

        $this->post('/peserta/' . $event->id . '/confirm')->assertRedirect(route('peserta.ticket', $event));

        $participant = Participant::where('email', 'ahmad@example.com')->first();
        $this->assertNotNull($participant);
        $this->assertEquals('lunas', $participant->status);

        $this->get('/peserta/' . $event->id . '/tiket')->assertStatus(200);
    }

    public function test_admin_authentication_and_dashboard(): void
    {
        $loginResponse = $this->post('/admin/login', [
            'email' => 'admin@eventflow.id',
            'password' => 'admin123',
        ]);

        $loginResponse->assertRedirect(route('admin.dashboard'));

        $this->get('/admin/dashboard')->assertStatus(200);
        $this->get('/admin/events')->assertStatus(200);
        $this->get('/admin/participants')->assertStatus(200);
        $this->get('/admin/scan')->assertStatus(200);
        $this->get('/admin/reports')->assertStatus(200);
    }

    public function test_admin_can_create_update_and_delete_event(): void
    {
        $this->withSession(['admin_logged_in' => true]);

        $storeResponse = $this->post('/admin/events', [
            'title' => 'Konferensi AI 2026',
            'speaker' => 'Dr. Tech',
            'time_slot' => '13.00 WIB',
            'date' => '2026-09-15',
            'location' => 'Bandung',
            'desc' => 'Deskripsi event baru',
            'price' => 200000,
            'quota' => 100,
        ]);

        $storeResponse->assertRedirect(route('admin.events'));
        $event = Event::where('title', 'Konferensi AI 2026')->first();
        $this->assertNotNull($event);

        $updateResponse = $this->put('/admin/events/' . $event->id, [
            'title' => 'Konferensi AI & Cloud 2026',
            'date' => '2026-09-15',
            'location' => 'Bandung Digital Hall',
            'desc' => 'Deskripsi diperbarui',
            'price' => 250000,
            'quota' => 150,
        ]);

        $updateResponse->assertRedirect(route('admin.events'));
        $this->assertEquals('Konferensi AI & Cloud 2026', $event->fresh()->title);

        $deleteResponse = $this->delete('/admin/events/' . $event->id);
        $deleteResponse->assertRedirect(route('admin.events'));
        $this->assertNull(Event::find($event->id));
    }

    public function test_admin_can_process_qr_scan(): void
    {
        $this->withSession(['admin_logged_in' => true]);

        $event = Event::create([
            'slug' => 'event-scan',
            'title' => 'Scan Event',
            'date' => '2026-08-10',
            'location' => 'Medan',
            'desc' => 'Scan test',
            'price' => 50000,
            'quota' => 20,
        ]);

        $participant = Participant::create([
            'trx_id' => 'TRX-TEST999',
            'name' => 'Budi',
            'email' => 'budi@test.com',
            'phone' => '08999999',
            'event_id' => $event->id,
            'status' => 'lunas',
            'checked_in' => false,
        ]);

        $response = $this->postJson('/admin/scan/process', ['code' => 'TRX-TEST999']);
        $response->assertStatus(200);
        $response->assertJsonPath('error', false);
        $response->assertJsonPath('already_checked', false);

        $this->assertTrue($participant->fresh()->checked_in);
    }
}
