<?php

namespace Database\Seeders;

use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        Participant::create([
            'trx_id' => 'TRX-8841',
            'name' => 'Andi Pratama',
            'email' => 'andi.pratama@mail.com',
            'phone' => '081234560001',
            'instansi' => 'PT Tech Solutions',
            'event_id' => 1,
            'status' => 'lunas',
            'checked_in' => true,
            'checkin_time' => Carbon::parse('2026-05-20 09:15:00'),
        ]);

        Participant::create([
            'trx_id' => 'TRX-8842',
            'name' => 'Siti Aisyah',
            'email' => 'siti.aisyah@mail.com',
            'phone' => '081234560002',
            'instansi' => 'UI/UX Design Studio',
            'event_id' => 2,
            'status' => 'lunas',
            'checked_in' => false,
        ]);

        Participant::create([
            'trx_id' => 'TRX-8843',
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@mail.com',
            'phone' => '081234560003',
            'instansi' => 'Universitas Indonesia',
            'event_id' => 1,
            'status' => 'pending',
            'checked_in' => false,
        ]);

        Participant::create([
            'trx_id' => 'TRX-8844',
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@mail.com',
            'phone' => '081234560004',
            'instansi' => 'Creative Agency',
            'event_id' => 2,
            'status' => 'lunas',
            'checked_in' => false,
        ]);
    }
}
