<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'slug' => 'cinta-itu-bernama-taat',
            'title' => 'CINTA ITU Bernama Ta\'at',
            'speaker' => 'Ustadz Dr. Khalid Basalamah',
            'time_slot' => '10.00 - 11.30 WIB',
            'date' => '2026-06-20',
            'location' => 'Jakarta International Convention Center (JICC), Senayan',
            'price' => 0,
            'quota' => 500,
            'desc' => 'Sesi kajian utama bersama Ustadz Dr. Khalid Basalamah yang mengupas tuntas hakikat cinta, ketaatan, dan ketauhidan.',
        ]);

        Event::create([
            'slug' => 'ketika-hati-memilih',
            'title' => 'KETIKA Hati Memilih',
            'speaker' => 'Ustadz Dr. Syafiq Riza Basalamah',
            'time_slot' => '15.55 - 17.50 WIB',
            'date' => '2026-06-20',
            'location' => 'Jakarta International Convention Center (JICC), Senayan',
            'price' => 0,
            'quota' => 500,
            'desc' => 'Saat logika dan perasaan bertemu dalam sebuah keputusan. Sesi inspiratif bersama Ustadz Dr. Syafiq Riza Basalamah.',
        ]);

        Event::create([
            'slug' => 'setiap-kita-ada-mahakarya',
            'title' => 'SETIAP KITA, ADA MAHAKARYA Kebesaran-Nya',
            'speaker' => 'dr. Bobby Arfhan Anwar Sp.JP(K)',
            'time_slot' => '08.30 - 09.30 WIB',
            'date' => '2026-06-20',
            'location' => 'Jakarta International Convention Center (JICC), Senayan',
            'price' => 0,
            'quota' => 500,
            'desc' => 'Mengenal keajaiban dan kebesaran Allah melalui keajaiban organ tubuh & kesehatan jantung bersama dokter spesialis.',
        ]);
    }
}
