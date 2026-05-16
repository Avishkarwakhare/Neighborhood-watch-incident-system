<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Zone;
use App\Models\Locality;
use App\Models\Society;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        $clLocality = Locality::where('name', 'Civil Lines')->first();
        $clSociety = Society::where('name', 'Civil Lines Main')->first();
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@safeneighbor.com',
            'password' => $password,
            'role' => 'admin',
            'is_approved' => true,
            'zone_id' => $clLocality->zone_id ?? 1,
            'state_id' => $clLocality->city->state_id ?? null,
            'city_id' => $clLocality->city_id ?? null,
            'locality_id' => $clLocality->id ?? null,
            'society_id' => $clSociety->id ?? null,
        ]);

        $wardens = [
            ['email' => 'warden.modeltown@safeneighbor.com', 'loc' => 'Model Town'],
            ['email' => 'warden.civillines@safeneighbor.com', 'loc' => 'Civil Lines'],
            ['email' => 'warden.gnpura@safeneighbor.com', 'loc' => 'Guru Nanak Pura'],
        ];

        foreach ($wardens as $w) {
            $loc = Locality::where('name', $w['loc'])->first();
            if ($loc) {
                User::create([
                    'name' => $w['loc'] . ' Warden',
                    'email' => $w['email'],
                    'password' => $password,
                    'role' => 'warden',
                    'is_approved' => true,
                    'zone_id' => $loc->zone_id,
                    'state_id' => $loc->city->state_id ?? null,
                    'city_id' => $loc->city_id ?? null,
                    'locality_id' => $loc->id,
                ]);
            }
        }

        $residents = [
            ['email' => 'resident1@test.com', 'loc' => 'Model Town', 'soc' => 'Green Model Town - C Block', 'h' => 'H.No. 45, Street 3'],
            ['email' => 'resident2@test.com', 'loc' => 'Model Town', 'soc' => 'Link Colony', 'h' => 'H.No. 12, Link Road'],
            ['email' => 'resident3@test.com', 'loc' => 'Civil Lines', 'soc' => 'Shastri Nagar', 'h' => 'Flat 201, Shastri Apartments'],
            ['email' => 'resident4@test.com', 'loc' => 'Jawahar Nagar', 'soc' => 'Jawahar Nagar Sector A', 'h' => 'H.No. 78-B'],
            ['email' => 'resident5@test.com', 'loc' => 'Urban Estate', 'soc' => 'Urban Estate Phase 1', 'h' => 'H.No. 156, Phase 1'],
        ];

        foreach ($residents as $i => $r) {
            $loc = Locality::where('name', $r['loc'])->first();
            $soc = Society::where('name', $r['soc'])->first();
            if ($loc && $soc) {
                User::create([
                    'name' => 'Resident ' . ($i + 1),
                    'email' => $r['email'],
                    'password' => $password,
                    'role' => 'resident',
                    'is_approved' => true,
                    'zone_id' => $loc->zone_id,
                    'state_id' => $loc->city->state_id ?? null,
                    'city_id' => $loc->city_id ?? null,
                    'locality_id' => $loc->id,
                    'society_id' => $soc->id,
                    'house_no' => $r['h'],
                ]);
            }
        }
    }
}