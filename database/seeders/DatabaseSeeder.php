<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ZoneSeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            LocalitySeeder::class,
            SocietySeeder::class,
            UserSeeder::class,
            IncidentSeeder::class,
            PollSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
