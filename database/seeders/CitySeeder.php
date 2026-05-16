<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;

class CitySeeder extends Seeder {
    public function run(): void {
        $pb = State::where('code', 'PB')->first();
        if ($pb) {
            $pbCities = ['Jalandhar', 'Ludhiana', 'Amritsar', 'Patiala', 'Bathinda', 'Mohali', 'Phagwara', 'Hoshiarpur', 'Pathankot', 'Gurdaspur'];
            foreach ($pbCities as $c) { City::create(['state_id' => $pb->id, 'name' => $c, 'pincode_prefix' => '144']); }
        }

        $hr = State::where('code', 'HR')->first();
        if ($hr) {
            $hrCities = ['Chandigarh', 'Gurugram', 'Faridabad', 'Ambala', 'Karnal', 'Panipat', 'Rohtak'];
            foreach ($hrCities as $c) { City::create(['state_id' => $hr->id, 'name' => $c]); }
        }

        $dl = State::where('code', 'DL')->first();
        if ($dl) {
            $dlCities = ['New Delhi', 'Dwarka', 'Rohini', 'Laxmi Nagar', 'Janakpuri'];
            foreach ($dlCities as $c) { City::create(['state_id' => $dl->id, 'name' => $c]); }
        }

        $hp = State::where('code', 'HP')->first();
        if ($hp) {
            $hpCities = ['Shimla', 'Dharamshala', 'Manali', 'Solan'];
            foreach ($hpCities as $c) { City::create(['state_id' => $hp->id, 'name' => $c]); }
        }
    }
}
