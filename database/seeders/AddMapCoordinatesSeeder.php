<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\EventLocation;

class AddMapCoordinatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder adds sample coordinates to existing events that don't have map_details
     */
    public function run(): void
    {
        // Get all event locations without map_details
        $locations = EventLocation::whereNull('map_details')
            ->orWhere('map_details', '')
            ->get();

        if ($locations->isEmpty()) {
            $this->command->info('All events already have map coordinates!');
            return;
        }

        // Sample coordinates for different Philippines locations
        $sampleCoordinates = [
            'Manila' => '14.599512, 120.984222',
            'Quezon City' => '14.676208, 121.043861',
            'Panabo' => '7.321389, 125.683889',
            'Davao' => '7.190708, 125.455341',
            'Cebu' => '10.315699, 123.885437',
        ];

        foreach ($locations as $location) {
            // Try to match location name to our samples
            $coords = null;
            foreach ($sampleCoordinates as $place => $coordinates) {
                if (stripos($location->evt_loctn_name, $place) !== false) {
                    $coords = $coordinates;
                    break;
                }
            }

            // If no match, use default Manila coordinates
            if (!$coords) {
                $coords = '14.599512, 120.984222';
            }

            // Update the location
            $location->map_details = $coords;
            $location->save();

            $this->command->info("Updated event location '{$location->evt_loctn_name}' with coordinates: {$coords}");
        }

        $this->command->info('Successfully added map coordinates to ' . $locations->count() . ' events!');
    }
}
