<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@eventflow.id'],
            ['name' => 'Super Administrator', 'password' => 'admin123', 'role' => 'superadmin'],
        );

        User::firstOrCreate(
            ['email' => 'fajri@eventflow.id'],
            ['name' => 'Fajri', 'password' => 'admin123', 'role' => 'admin'],
        );

        User::firstOrCreate(
            ['email' => 'rizky@eventflow.id'],
            ['name' => 'Rizky', 'password' => 'admin123', 'role' => 'admin'],
        );

        User::firstOrCreate(
            ['email' => 'sari@eventflow.id'],
            ['name' => 'Sari', 'password' => 'admin123', 'role' => 'admin'],
        );

        $this->call([
            EventSeeder::class,
            ParticipantSeeder::class,
        ]);
    }
}
