<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $manager = User::updateOrCreate(
            ['email' => 'role@manajer.com'],
            [
                'name' => 'Role Manager',
                'password' => Hash::make('password'),
                'role' => 'rolemanager'
            ]
        );

        $programmer1 = User::updateOrCreate(
            ['email' => 'el@programmer.com'],
            [
                'name' => 'El Programmer',
                'password' => Hash::make('password'),
                'role' => 'programmer'
            ]
        );

        $programmer2 = User::updateOrCreate(
            ['email' => 'welyo@programmer.com'],
            [
                'name' => 'Welyo Developer',
                'password' => Hash::make('password'),
                'role' => 'programmer'
            ]
        );

        // Sample tasks for initial demonstration
        Task::updateOrCreate(
            ['title' => 'Perbaiki Sistem Register & Validasi Role'],
            [
                'user_id' => $manager->id,
                'assigned_to' => $programmer1->id,
                'description' => 'Memastikan setiap pengguna baru memilih role Programmer atau Role Manager dengan validasi ketat.',
                'status' => 'done',
                'priority' => 'high',
                'due_date' => now()->addDays(2),
            ]
        );

        Task::updateOrCreate(
            ['title' => 'Integrasi Dashboard Role Manager & Programmer'],
            [
                'user_id' => $manager->id,
                'assigned_to' => $programmer1->id,
                'description' => 'Membuat antarmuka to-do kanban terpisah yang interaktif untuk publish, managed, dan done.',
                'status' => 'managed',
                'priority' => 'high',
                'due_date' => now()->addDays(4),
            ]
        );

        Task::updateOrCreate(
            ['title' => 'Slicing & Desain UI Komponen Responsif'],
            [
                'user_id' => $manager->id,
                'assigned_to' => null,
                'description' => 'Mengoptimalkan tata letak mobile friendly untuk halaman login, register, dan tabel tugas.',
                'status' => 'publish',
                'priority' => 'medium',
                'due_date' => now()->addDays(7),
            ]
        );

        Task::updateOrCreate(
            ['title' => 'Testing Keamanan Route Middleware'],
            [
                'user_id' => $manager->id,
                'assigned_to' => $programmer2->id,
                'description' => 'Uji otorisasi role programmer dan role manager agar tidak bisa saling akses route terlarang.',
                'status' => 'publish',
                'priority' => 'low',
                'due_date' => now()->addDays(5),
            ]
        );
    }
}
