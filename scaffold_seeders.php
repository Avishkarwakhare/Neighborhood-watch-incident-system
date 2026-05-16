<?php

$dir = __DIR__ . '/database/seeders/';

// StateSeeder
file_put_contents($dir . 'StateSeeder.php', "<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder {
    public function run(): void {
        \$states = [
            ['name' => 'Punjab', 'code' => 'PB'],
            ['name' => 'Haryana', 'code' => 'HR'],
            ['name' => 'Himachal Pradesh', 'code' => 'HP'],
            ['name' => 'Delhi', 'code' => 'DL'],
            ['name' => 'Uttar Pradesh', 'code' => 'UP'],
            ['name' => 'Rajasthan', 'code' => 'RJ'],
            ['name' => 'Maharashtra', 'code' => 'MH'],
            ['name' => 'Karnataka', 'code' => 'KA'],
            ['name' => 'Tamil Nadu', 'code' => 'TN'],
            ['name' => 'Gujarat', 'code' => 'GJ'],
        ];
        foreach (\$states as \$state) { State::create(\$state); }
    }
}");

// CitySeeder
file_put_contents($dir . 'CitySeeder.php', "<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;

class CitySeeder extends Seeder {
    public function run(): void {
        \$pb = State::where('code', 'PB')->first();
        \$pbCities = ['Jalandhar', 'Ludhiana', 'Amritsar', 'Patiala', 'Bathinda', 'Mohali', 'Phagwara', 'Hoshiarpur', 'Pathankot', 'Gurdaspur'];
        foreach (\$pbCities as \$c) { City::create(['state_id' => \$pb->id, 'name' => \$c, 'pincode_prefix' => '144']); }

        \$hr = State::where('code', 'HR')->first();
        \$hrCities = ['Chandigarh', 'Gurugram', 'Faridabad', 'Ambala', 'Karnal', 'Panipat', 'Rohtak'];
        foreach (\$hrCities as \$c) { City::create(['state_id' => \$hr->id, 'name' => \$c]); }

        \$dl = State::where('code', 'DL')->first();
        \$dlCities = ['New Delhi', 'Dwarka', 'Rohini', 'Laxmi Nagar', 'Janakpuri'];
        foreach (\$dlCities as \$c) { City::create(['state_id' => \$dl->id, 'name' => \$c]); }

        \$hp = State::where('code', 'HP')->first();
        \$hpCities = ['Shimla', 'Dharamshala', 'Manali', 'Solan'];
        foreach (\$hpCities as \$c) { City::create(['state_id' => \$hp->id, 'name' => \$c]); }
    }
}");

// LocalitySeeder
file_put_contents($dir . 'LocalitySeeder.php', "<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Locality;
use App\Models\Zone;

class LocalitySeeder extends Seeder {
    public function run(): void {
        \$jal = City::where('name', 'Jalandhar')->first();
        \$localities = [
            'Model Town', 'Civil Lines', 'Guru Nanak Pura', 'Lajpat Nagar', 'Jawahar Nagar', 
            'Arya Nagar', 'Urban Estate Ph1', 'Cantt Area', 'Maqsudan', 'Basti Sheikh', 
            'Partap Nagar', 'Green Model Town', 'GTB Nagar', 'Bombay Nagar', 'Adarsh Nagar', 
            'Sarabha Nagar', 'Rishi Nagar', 'Rama Mandi', 'Sodal Road', 'Nawanshahr Road Area'
        ];
        foreach (\$localities as \$loc) { 
            \$zone = Zone::where('name', \$loc)->first();
            Locality::create(['city_id' => \$jal->id, 'name' => \$loc, 'zone_id' => \$zone?->id]); 
        }
    }
}");

// SocietySeeder
file_put_contents($dir . 'SocietySeeder.php', "<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Locality;
use App\Models\Society;

class SocietySeeder extends Seeder {
    public function run(): void {
        \$societies = [
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

        foreach (\$societies as \$locName => \$socs) {
            \$loc = Locality::where('name', \$locName)->first();
            if (\$loc) {
                foreach (\$socs as \$soc) {
                    \$soc['locality_id'] = \$loc->id;
                    Society::create(\$soc);
                }
            }
        }
    }
}");

// Update DatabaseSeeder
\$dbSeeder = file_get_contents($dir . 'DatabaseSeeder.php');
\$dbSeeder = str_replace(
    'ZoneSeeder::class,',
    "ZoneSeeder::class,\n            StateSeeder::class,\n            CitySeeder::class,",
    \$dbSeeder
);
// Also need to add SocietySeeder::class since it wasn't there before
if (strpos(\$dbSeeder, 'SocietySeeder::class') === false) {
    \$dbSeeder = str_replace(
        'LocalitySeeder::class,',
        "LocalitySeeder::class,\n            SocietySeeder::class,",
        \$dbSeeder
    );
}
file_put_contents($dir . 'DatabaseSeeder.php', \$dbSeeder);

echo "Seeders written.\n";
