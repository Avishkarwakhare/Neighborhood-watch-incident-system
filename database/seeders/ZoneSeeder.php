<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            'Model Town', 'Civil Lines', 'Guru Nanak Pura', 'Lajpat Nagar',
            'Jawahar Nagar', 'Arya Nagar', 'Cantt Area', 'Urban Estate Ph1',
            'Basti Sheikh', 'Maqsudan', 'Partap Nagar', 'New Jawahar Nagar'
        ];

        foreach ($zones as $zone) {
            Zone::updateOrCreate(['name' => $zone], ['city' => 'Jalandhar', 'state' => 'Punjab']);
        }
    }
}
