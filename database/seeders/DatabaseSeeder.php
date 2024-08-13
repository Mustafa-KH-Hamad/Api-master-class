<?php

namespace Database\Seeders;

use App\Models\V1\ticket;
use App\Models\User;
use Database\Factories\TicketFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user  = User::factory(10)->create();
        ticket::factory(100)->recycle($user)->create();
        User::create([
            'name' => 'Manager',
            'email' => 'manager@manager.com',
            'password' => Hash::make('password'),
            'is_manager' => true, // Assuming you have a column to indicate the role
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
