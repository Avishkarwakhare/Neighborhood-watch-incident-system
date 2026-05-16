<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locality;
use App\Models\Society;

class SocietySeeder extends Seeder {
    public function run(): void {
        $societies = [
            'Model Town' => [
                ['name' => 'Green Model Town - A Block', 'type' => 'block', 'landmark' => 'Near Nikku Park', 'pincode' => '144001'],
                ['name' => 'Green Model Town - B Block', 'type' => 'block', 'landmark' => 'Near Model Town Market', 'pincode' => '144001'],
                ['name' => 'Green Model Town - C Block', 'type' => 'block', 'landmark' => 'Near Apeejay School', 'pincode' => '144001'],
                ['name' => 'Link Colony', 'type' => 'colony', 'landmark' => 'Near Link Road', 'pincode' => '144001'],
                ['name' => 'New Model Town', 'type' => 'colony', 'landmark' => 'Near Model Town Chowk', 'pincode' => '144001'],
            ],
            'Civil Lines' => [
                ['name' => 'Civil Lines Main', 'type' => 'road', 'landmark' => 'Near DC Office', 'pincode' => '144001'],
                ['name' => 'New Jawahar Nagar', 'type' => 'nagar', 'landmark' => 'Near MBD Neopolis', 'pincode' => '144001'],
                ['name' => 'Shastri Nagar', 'type' => 'nagar', 'landmark' => 'Near Guru Nanak Chowk', 'pincode' => '144001'],
                ['name' => 'Basant Vihar', 'type' => 'colony', 'landmark' => 'Near Civil Hospital', 'pincode' => '144001'],
            ],
            'Guru Nanak Pura' => [
                ['name' => 'Guru Nanak Pura Phase 1', 'type' => 'phase', 'landmark' => 'Near GN Mission Chowk', 'pincode' => '144001'],
                ['name' => 'Sarabha Nagar', 'type' => 'nagar', 'landmark' => 'Near Sarabha Nagar Market', 'pincode' => '144001'],
                ['name' => 'BDA Enclave', 'type' => 'enclave', 'landmark' => 'Near Sodal Road', 'pincode' => '144001'],
            ],
            'Lajpat Nagar' => [
                ['name' => 'Lajpat Nagar Main', 'type' => 'nagar', 'landmark' => 'Near Nakodar Chowk', 'pincode' => '144003'],
                ['name' => 'Avtar Nagar', 'type' => 'nagar', 'landmark' => 'Near Lajpat Nagar Market', 'pincode' => '144003'],
            ],
            'Jawahar Nagar' => [
                ['name' => 'Jawahar Nagar Sector A', 'type' => 'sector', 'landmark' => 'Near Main Market', 'pincode' => '144001'],
                ['name' => 'Choti Baradari Part 1', 'type' => 'colony', 'landmark' => 'Near Main Gate', 'pincode' => '144001'],
            ],
            'Urban Estate Ph1' => [
                ['name' => 'Urban Estate Phase 1', 'type' => 'phase', 'landmark' => 'Near Phase 1 Market', 'pincode' => '144022'],
                ['name' => 'Surya Enclave', 'type' => 'enclave', 'landmark' => 'Near Urban Estate', 'pincode' => '144022'],
            ],
            'Cantt Area' => [
                ['name' => 'Cantonment Main Area', 'type' => 'colony', 'landmark' => 'Near Army Gate', 'pincode' => '144005'],
                ['name' => 'Rama Mandi Colony', 'type' => 'colony', 'landmark' => 'Near Rama Mandi Chowk', 'pincode' => '144005'],
            ]
        ];

        foreach ($societies as $locName => $socs) {
            $loc = Locality::where('name', $locName)->first();
            if ($loc) {
                foreach ($socs as $soc) {
                    $soc['locality_id'] = $loc->id;
                    Society::create($soc);
                }
            }
        }
    }
}
