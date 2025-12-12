<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test organizer user
        $organizer = User::factory()->organizer()->create([
            'usr_name' => 'Test Organizer',
        ]);

        // Create user details for organizer
        \App\Models\UserDetail::create([
            'usr_id' => $organizer->usr_id,
            'email_add' => 'organizer@example.com',
            'contact_num' => '1234567890',
        ]);

        // Create organizer record
        $organizerRecord = \App\Models\Organizer::create([
            'org_id' => $organizer->usr_id,
            'org_name' => 'Test Organization',
        ]);

        // Create a test volunteer user
        $volunteer = User::factory()->volunteer()->create([
            'usr_name' => 'Test Volunteer',
        ]);

        // Create user details for volunteer
        \App\Models\UserDetail::create([
            'usr_id' => $volunteer->usr_id,
            'email_add' => 'volunteer@example.com',
            'contact_num' => '0987654321',
        ]);

        // Create volunteer record
        \App\Models\Volunteer::create([
            'vol_id' => $volunteer->usr_id,
        ]);
    }
}
