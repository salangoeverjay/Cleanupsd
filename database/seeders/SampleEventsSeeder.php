<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SampleEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample organizer user
        $userId = DB::table('user')->insertGetId([
            'usr_name' => 'sample_organizer',
            'password' => Hash::make('password123'),
            'registered_as' => 'Organizer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create organizer user details
        DB::table('user_details')->insert([
            'usr_id' => $userId,
            'email_add' => 'organizer@example.com',
            'contact_num' => '09123456789',
            'address' => 'Manila, Philippines',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create organizer profile
        $orgId = DB::table('organizer')->insertGetId([
            'org_id' => $userId,
            'org_name' => 'Sample Organization',
            'totl_evts_orgzd' => 3,
            'totl_trsh_collected_kg' => 0,
            'totl_partpts_overall' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sample events
        $events = [
            [
                'evt_name' => 'Manila Bay Cleanup Drive',
                'evt_details' => 'Join us in cleaning up Manila Bay! Bring your enthusiasm and help make our bay beautiful again.',
                'evt_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'org_id' => $orgId,
                'lat' => 14.5764,
                'lng' => 120.9822,
                'location_name' => 'Manila Bay, Manila'
            ],
            [
                'evt_name' => 'Rizal Park Green Initiative',
                'evt_details' => 'Help keep our national park clean! Volunteers needed for a morning cleanup activity.',
                'evt_date' => Carbon::now()->addDays(14)->format('Y-m-d'),
                'org_id' => $orgId,
                'lat' => 14.5832,
                'lng' => 120.9794,
                'location_name' => 'Rizal Park, Manila'
            ],
            [
                'evt_name' => 'Intramuros Heritage Cleanup',
                'evt_details' => 'Preserve the beauty of our heritage site. Join the cleanup drive and learn about history!',
                'evt_date' => Carbon::now()->addDays(21)->format('Y-m-d'),
                'org_id' => $orgId,
                'lat' => 14.5895,
                'lng' => 120.9751,
                'location_name' => 'Intramuros, Manila'
            ],
        ];

        foreach ($events as $eventData) {
            $eventId = DB::table('event')->insertGetId([
                'evt_name' => $eventData['evt_name'],
                'evt_details' => $eventData['evt_details'],
                'evt_date' => $eventData['evt_date'],
                'org_id' => $eventData['org_id'],
                'trsh_collected_kg' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create event location
            DB::table('event_location')->insert([
                'evt_id' => $eventId,
                'evt_lat' => $eventData['lat'],
                'evt_lng' => $eventData['lng'],
                'evt_location_name' => $eventData['location_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Sample organizer and 3 events created successfully!');
        $this->command->info('Login credentials: sample_organizer / password123');
    }
}
