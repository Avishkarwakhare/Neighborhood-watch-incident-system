<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Locality;
use App\Models\Zone;

class LocalitySeeder extends Seeder {
    public function run(): void {
        $jal = City::where('name', 'Jalandhar')->first();
        if (!$jal) return;
        
        $localities = [
            'Model Town', 'Civil Lines', 'Guru Nanak Pura', 'Lajpat Nagar', 'Jawahar Nagar', 
            'Arya Nagar', 'Urban Estate Ph1', 'Cantt Area', 'Maqsudan', 'Basti Sheikh', 
            'Partap Nagar', 'Green Model Town', 'GTB Nagar', 'Bombay Nagar', 'Adarsh Nagar', 
            'Sarabha Nagar', 'Rishi Nagar', 'Rama Mandi', 'Sodal Road', 'Nawanshahr Road Area'
        ];
        foreach ($localities as $loc) { 
            $zone = Zone::where('name', $loc)->first();
            Locality::create(['city_id' => $jal->id, 'name' => $loc, 'zone_id' => $zone?->id]); 
        }
    }
}
