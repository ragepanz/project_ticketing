<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        // Initial Cities Data
        $cities = [
            ['name' => 'BATAM', 'slug' => 'batam', 'location_name' => 'Planet Holiday Hotel & Residence', 'image_url' => '/images/gallery1.png'],
            ['name' => 'PALEMBANG', 'slug' => 'palembang', 'location_name' => 'Aston Palembang Hotel', 'image_url' => '/images/gallery1.png'],
            ['name' => 'MEDAN', 'slug' => 'medan', 'location_name' => 'JW Marriott Hotel Medan', 'image_url' => '/images/gallery1.png'],
            ['name' => 'JAKARTA', 'slug' => 'jakarta', 'location_name' => 'Gedung Serbaguna Senayan', 'image_url' => '/images/gallery1.png'],
            ['name' => 'YOGYAKARTA', 'slug' => 'yogyakarta', 'location_name' => 'Sahid Raya Hotel Yogyakarta', 'image_url' => '/images/gallery1.png'],
            ['name' => 'GARUT', 'slug' => 'garut', 'location_name' => 'Santika Hotel Garut', 'image_url' => '/images/gallery1.png'],
            ['name' => 'BOGOR', 'slug' => 'bogor', 'location_name' => 'Puri Begawan Bogor', 'image_url' => '/images/gallery1.png'],
            ['name' => 'LOMBOK', 'slug' => 'lombok', 'location_name' => 'Lombok Raya Hotel', 'image_url' => '/images/gallery1.png'],
            ['name' => 'PALU', 'slug' => 'palu', 'location_name' => 'Mercure Hotel Palu', 'image_url' => '/images/gallery1.png'],
            ['name' => 'ACEH', 'slug' => 'aceh', 'location_name' => 'Ayani Hotel Banda Aceh', 'image_url' => '/images/gallery1.png'],
        ];

        foreach ($cities as $c) {
            City::updateOrCreate(['slug' => $c['slug']], $c);
        }

        // Initial Testimonials Data
        $testimonials = [
            [
                'name' => 'Anisa Rahmawati',
                'city_or_event' => 'Peserta Mental Talk Jakarta',
                'rating' => 5,
                'comment' => 'Bersyukur sekali jadi salah satu bagian dari Titik Temu. Sebelum ikut acaranya memang bener-bener capek sama kehidupan, sering sedih-sedih sendiri, tapi setelah selesai acara ada perasaan lega dan banyak air mata yang keluar. Semoga tahun depan dipertemukan lagi ya kak ❤️',
                'is_featured' => true,
            ],
            [
                'name' => 'Dwi Prasetyo',
                'city_or_event' => 'Peserta Mental Talk Lombok',
                'rating' => 5,
                'comment' => 'Jujur aku awalnya ragu karena belum pernah ikut sesi hipnoterapi. Tapi pas masuk ruangan suasananya adem banget, nggak menghakimi sama sekali. Berasa didengerin dan dirangkul tanpa harus banyak kata.',
                'is_featured' => true,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'city_or_event' => 'Peserta Mental Talk Batam',
                'rating' => 5,
                'comment' => 'Ternyata pulih itu nggak harus pura-pura kuat di depan orang. Di Titik Temu aku bisa nangis sepuasnya tanpa rasa malu. Pulang ke rumah hati terasa jauhhh lebih ringan.',
                'is_featured' => true,
            ],
            [
                'name' => 'Rian Hidayat',
                'city_or_event' => 'Peserta Mental Talk Palembang',
                'rating' => 5,
                'comment' => 'Sesi hypnotherapy-nya luar biasa banget. Pikiran jadi jauh lebih jernih dan tenang. Terima kasih tim Titik Temu Official!',
                'is_featured' => false,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['name' => $t['name'], 'city_or_event' => $t['city_or_event']], $t);
        }
    }
}
