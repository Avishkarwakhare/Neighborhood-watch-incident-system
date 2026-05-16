<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\User;
use App\Models\Zone;
use Faker\Factory as Faker;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $wardens = User::where('role', 'warden')->get();
        
        $announcementsData = [
            [
                'title' => 'Road Construction Work',
                'body' => 'Please be advised that road construction is ongoing near the main entrance. Please drive slowly and watch out for workers and heavy equipment.',
                'priority' => 'urgent'
            ],
            [
                'title' => 'Sewer Cleaning Scheduled',
                'body' => 'Sewer cleaning will take place today from 1:00 PM to 3:00 PM. You may experience minor disruptions and foul odors during this time.',
                'priority' => 'normal'
            ],
            [
                'title' => 'Water Supply Interruption',
                'body' => 'Due to pipeline maintenance, water supply will be interrupted tomorrow between 10 AM and 2 PM. Please store sufficient water.',
                'priority' => 'normal'
            ],
            [
                'title' => 'Monthly Society Meeting',
                'body' => 'The monthly society meeting is scheduled for this Sunday at 10 AM in the community hall. All residents are requested to attend.',
                'priority' => 'normal'
            ],
            [
                'title' => 'Security Alert: Suspicious Person',
                'body' => 'A suspicious person was reported near Block B yesterday evening. Security has been increased, but please remain vigilant and report any concerns.',
                'priority' => 'emergency'
            ]
        ];

        foreach ($announcementsData as $data) {
            $warden = $wardens->random();
            Announcement::create([
                'zone_id' => $warden->zone_id,
                'user_id' => $warden->id,
                'title' => $data['title'],
                'body' => $data['body'],
                'priority' => $data['priority'],
                'expires_at' => $faker->boolean(70) ? $faker->dateTimeBetween('now', '+1 month') : null,
            ]);
        }
    }
}
