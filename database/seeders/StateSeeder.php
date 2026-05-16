<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder {
    public function run(): void {
        $states = [
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
        foreach ($states as $state) { State::create($state); }
    }
}
