<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductionFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_peserta_can_download_pdf_ticket(): void
    {
        $event = Event::create([
            'slug' => 'pdf-event',
            'title' => 'PDF Event Title',
            'speaker' => 'Dr. PDF',
            'time_slot' => '10.00 WIB',
            'date' => '2026-08-10',
            'location' => 'Jakarta',
            'desc' => 'PDF Description',
            'price' => 100000,
            'quota' => 50,
            'status' => Event::STATUS_PUBLISHED,
        ]);

        $participant = Participant::create([
            'trx_id' => 'TRX-PDF123',
            'name' => 'Budi PDF',
            'email' => 'budipdf@test.com',
            'phone' => '08123456789',
            'event_id' => $event->id,
            'status' => 'lunas',
            'checked_in' => false,
        ]);

        $this->withSession([
            'ticket_trx_id' => 'TRX-PDF123',
            'ticket_event_id' => $event->id,
        ]);

        $response = $this->get(route('peserta.ticket.download', $event->slug));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_admin_can_login_via_api_and_scan_qr(): void
    {
        $admin = User::create([
            'name' => 'API Admin',
            'email' => 'apiadmin@eventflow.id',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        $event = Event::create([
            'slug' => 'api-event',
            'title' => 'API Event Title',
            'speaker' => 'Dr. API',
            'time_slot' => '11.00 WIB',
            'date' => '2026-08-12',
            'location' => 'Bandung',
            'desc' => 'API Description',
            'price' => 50000,
            'quota' => 100,
            'status' => Event::STATUS_PUBLISHED,
        ]);

        $participant = Participant::create([
            'trx_id' => 'TRX-API999',
            'name' => 'Agus API',
            'email' => 'agusapi@test.com',
            'phone' => '08129999',
            'event_id' => $event->id,
            'status' => 'lunas',
            'checked_in' => false,
        ]);

        // Login API
        $response = $this->postJson('/api/login', [
            'email' => 'apiadmin@eventflow.id',
            'password' => 'admin123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'token',
            'user' => ['id', 'name', 'email', 'role']
        ]);

        $token = $response->json('token');

        // Authenticate with Sanctum token for scan check-in
        $scanResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/scan', [
            'code' => 'TRX-API999',
        ]);

        $scanResponse->assertStatus(200);
        $scanResponse->assertJsonPath('success', true);
        $scanResponse->assertJsonPath('participant.checked_in_at', now()->format('Y-m-d H:i:s'));

        $this->assertTrue($participant->fresh()->checked_in);

        // Try checking in again -> should fail with already checked in
        $scanAgainResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/scan', [
            'code' => 'TRX-API999',
        ]);

        $scanAgainResponse->assertStatus(400);
        $scanAgainResponse->assertJsonPath('success', false);
        $scanAgainResponse->assertJsonPath('error', 'already_checked_in');
    }
}
