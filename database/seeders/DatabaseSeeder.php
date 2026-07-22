<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'ivan@superadmin.com'],
            ['name' => 'Ivan Superadmin', 'password' => 'admin123', 'role' => 'superadmin'],
        );

        User::firstOrCreate(
            ['email' => 'angga@superadmin.com'],
            ['name' => 'Angga Superadmin', 'password' => 'admin123', 'role' => 'superadmin'],
        );

        User::firstOrCreate(
            ['email' => 'meyze@superadmin.com'],
            ['name' => 'Meyze Superadmin', 'password' => 'admin123', 'role' => 'superadmin'],
        );

        User::firstOrCreate(
            ['email' => 'sari@eventflow.id'],
            ['name' => 'Sari', 'password' => 'admin123', 'role' => 'admin'],
        );

        User::firstOrCreate(
            ['email' => 'jaja@eventflow.id'],
            ['name' => 'Jaja', 'password' => 'admin123', 'role' => 'admin'],
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
            ['email' => 'client@eventflow.id'],
            ['name' => 'Ahmad Client', 'password' => 'client123', 'role' => 'client'],
        );

        $this->call([
            EventSeeder::class,
            ParticipantSeeder::class,
        ]);
    }
}
