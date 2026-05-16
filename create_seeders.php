<?php

$dir = __DIR__ . '/database/seeders/';

// UserSeeder
file_put_contents($dir . 'UserSeeder.php', "<?php

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
        \$password = Hash::make('password');

        \$clLocality = Locality::where('name', 'Civil Lines')->first();
        \$clSociety = Society::where('name', 'Civil Lines Main')->first();
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@safeneighbor.com',
            'password' => \$password,
            'role' => 'admin',
            'is_approved' => true,
            'zone_id' => \$clLocality->zone_id ?? 1,
            'locality_id' => \$clLocality->id ?? null,
            'society_id' => \$clSociety->id ?? null,
        ]);

        \$wardens = [
            ['email' => 'warden.modeltown@safeneighbor.com', 'loc' => 'Model Town'],
            ['email' => 'warden.civillines@safeneighbor.com', 'loc' => 'Civil Lines'],
            ['email' => 'warden.gnpura@safeneighbor.com', 'loc' => 'Guru Nanak Pura'],
        ];

        foreach (\$wardens as \$w) {
            \$loc = Locality::where('name', \$w['loc'])->first();
            if (\$loc) {
                User::create([
                    'name' => \$w['loc'] . ' Warden',
                    'email' => \$w['email'],
                    'password' => \$password,
                    'role' => 'warden',
                    'is_approved' => true,
                    'zone_id' => \$loc->zone_id,
                    'locality_id' => \$loc->id,
                ]);
            }
        }

        \$residents = [
            ['email' => 'resident1@test.com', 'loc' => 'Model Town', 'soc' => 'Green Model Town - C Block', 'h' => 'H.No. 45, Street 3'],
            ['email' => 'resident2@test.com', 'loc' => 'Model Town', 'soc' => 'Link Colony', 'h' => 'H.No. 12, Link Road'],
            ['email' => 'resident3@test.com', 'loc' => 'Civil Lines', 'soc' => 'Shastri Nagar', 'h' => 'Flat 201, Shastri Apartments'],
            ['email' => 'resident4@test.com', 'loc' => 'Jawahar Nagar', 'soc' => 'Jawahar Nagar Sector A', 'h' => 'H.No. 78-B'],
            ['email' => 'resident5@test.com', 'loc' => 'Urban Estate', 'soc' => 'Urban Estate Phase 1', 'h' => 'H.No. 156, Phase 1'],
        ];

        foreach (\$residents as \$i => \$r) {
            \$loc = Locality::where('name', \$r['loc'])->first();
            \$soc = Society::where('name', \$r['soc'])->first();
            if (\$loc && \$soc) {
                User::create([
                    'name' => 'Resident ' . (\$i + 1),
                    'email' => \$r['email'],
                    'password' => \$password,
                    'role' => 'resident',
                    'is_approved' => true,
                    'zone_id' => \$loc->zone_id,
                    'locality_id' => \$loc->id,
                    'society_id' => \$soc->id,
                    'house_no' => \$r['h'],
                ]);
            }
        }
    }
}");

// IncidentSeeder
file_put_contents($dir . 'IncidentSeeder.php', "<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incident;
use App\Models\Zone;
use App\Models\Locality;

class IncidentSeeder extends Seeder
{
    public function run(): void
    {
        \$incidents = [
            [
                'loc' => 'Model Town', 'category' => 'theft', 'title' => 'Chain snatching near BMC Chowk',
                'desc' => 'Two men on black motorcycle snatched gold chain from a woman outside the main market. Heading towards GT Road direction.',
                'severity' => 'critical', 'status' => 'under_review', 'address' => 'BMC Chowk, Model Town, Jalandhar',
                'lat' => 31.3195, 'lng' => 75.5750, 'anon' => false
            ],
            [
                'loc' => 'Guru Nanak Pura', 'category' => 'suspicious_activity', 'title' => 'Unidentified vehicle parked outside school',
                'desc' => 'White Maruti van without number plate parked outside Guru Nanak Public School since yesterday night. Nobody has claimed it.',
                'severity' => 'high', 'status' => 'pending', 'address' => 'Near Guru Nanak Public School, GNP, Jalandhar',
                'lat' => 31.3280, 'lng' => 75.5820, 'anon' => false
            ],
            [
                'loc' => 'Lajpat Nagar', 'category' => 'fire', 'title' => 'Gas leak smell near colony park',
                'desc' => 'Strong gas smell detected near the residential area behind Lajpat Nagar park. May be from underground supply pipeline.',
                'severity' => 'critical', 'status' => 'resolved', 'address' => 'Lajpat Nagar Park area, Jalandhar',
                'lat' => 31.3150, 'lng' => 75.5700, 'anon' => false
            ],
            [
                'loc' => 'Jawahar Nagar', 'category' => 'other', 'title' => 'Street lights not working for 3 nights',
                'desc' => 'Entire stretch of main road in Jawahar Nagar has been dark. Women and elderly feel unsafe after 8 PM. Reported to MC helpline but no response.',
                'severity' => 'medium', 'status' => 'pending', 'address' => 'Main Road, Jawahar Nagar, Jalandhar',
                'lat' => 31.3310, 'lng' => 75.5680, 'anon' => false
            ],
            [
                'loc' => 'Civil Lines', 'category' => 'accident', 'title' => 'Open manhole causing danger near school gate',
                'desc' => 'Open manhole right outside Delhi Public School gate. Children nearly fell in during morning rush. MC has been notified twice with no action.',
                'severity' => 'high', 'status' => 'resolved', 'address' => 'Outside DPS, Civil Lines, Jalandhar',
                'lat' => 31.3350, 'lng' => 75.5790, 'anon' => false
            ],
            [
                'loc' => 'Arya Nagar', 'category' => 'medical', 'title' => 'Stray dog pack attacking pedestrians',
                'desc' => 'Pack of 6-7 stray dogs aggressively chasing pedestrians and cyclists near Arya Nagar park. A child was bitten last evening.',
                'severity' => 'high', 'status' => 'under_review', 'address' => 'Arya Nagar Park, Jalandhar',
                'lat' => 31.3240, 'lng' => 75.5760, 'anon' => false
            ],
            [
                'loc' => 'Cantt Area', 'category' => 'vandalism', 'title' => 'Boundary wall broken — unauthorized entry',
                'desc' => 'The boundary wall of the residential society near Cantonment has been broken at two points. Unknown persons entering the colony at night.',
                'severity' => 'high', 'status' => 'pending', 'address' => 'Near Cantt Chowk, Jalandhar',
                'lat' => 31.3420, 'lng' => 75.5650, 'anon' => false
            ],
            [
                'loc' => 'Urban Estate', 'category' => 'theft', 'title' => 'Bike stolen from outside Vishal Mega Mart',
                'desc' => 'Honda Activa (white, PB-08-XXXX) stolen from the parking lot of Vishal Mega Mart, Urban Estate. CCTV footage may be available.',
                'severity' => 'medium', 'status' => 'pending', 'address' => 'Vishal Mega Mart, Urban Estate Ph1, Jalandhar',
                'lat' => 31.3100, 'lng' => 75.5840, 'anon' => false
            ],
            [
                'loc' => 'Model Town', 'category' => 'suspicious_activity', 'title' => 'Unknown men taking photos of houses at night',
                'desc' => 'Two unknown men observed photographing houses in C-block Model Town between 10-11 PM for two consecutive nights. Very suspicious behavior.',
                'severity' => 'high', 'status' => 'under_review', 'address' => 'C-Block, Model Town, Jalandhar',
                'lat' => 31.3200, 'lng' => 75.5755, 'anon' => true
            ],
            [
                'loc' => 'Basti Sheikh', 'category' => 'natural_disaster', 'title' => 'Heavy waterlogging blocking main road',
                'desc' => 'After last night\'s rain, the main road in Basti Sheikh is waterlogged 2 feet deep. Vehicles stranded. MC drainage completely failed.',
                'severity' => 'medium', 'status' => 'resolved', 'address' => 'Main Road, Basti Sheikh, Jalandhar',
                'lat' => 31.3380, 'lng' => 75.5720, 'anon' => false
            ],
        ];

        \$faker = \Faker\Factory::create();
        
        foreach (\$incidents as \$inc) {
            \$loc = Locality::where('name', \$inc['loc'])->first();
            if (\$loc) {
                Incident::create([
                    'user_id' => 1, // Admin user
                    'zone_id' => \$loc->zone_id,
                    'locality_id' => \$loc->id,
                    'title' => \$inc['title'],
                    'description' => \$inc['desc'],
                    'category' => \$inc['category'],
                    'severity' => \$inc['severity'],
                    'status' => \$inc['status'],
                    'location_address' => \$inc['address'],
                    'latitude' => \$inc['lat'],
                    'longitude' => \$inc['lng'],
                    'is_anonymous' => \$inc['anon'],
                    'resolved_at' => \$inc['status'] === 'resolved' ? now() : null,
                ]);
            }
        }
        
        // Generate 10 more fake ones
        \$localities = Locality::all();
        \$categories = ['theft', 'fire', 'accident', 'suspicious_activity', 'vandalism', 'medical', 'natural_disaster', 'other'];
        \$severities = ['low', 'medium', 'high', 'critical'];
        \$statuses = ['pending', 'under_review', 'resolved'];
        
        for (\$i = 0; \$i < 10; \$i++) {
            \$loc = \$localities->random();
            \$status = \$faker->randomElement(\$statuses);
            
            Incident::create([
                'user_id' => 1,
                'zone_id' => \$loc->zone_id,
                'locality_id' => \$loc->id,
                'title' => \$faker->realText(50),
                'description' => \$faker->realText(200),
                'category' => \$faker->randomElement(\$categories),
                'severity' => \$faker->randomElement(\$severities),
                'status' => \$status,
                'location_address' => \$faker->address,
                'latitude' => \$loc->lat + (\$faker->randomFloat(4, -0.01, 0.01)),
                'longitude' => \$loc->lng + (\$faker->randomFloat(4, -0.01, 0.01)),
                'is_anonymous' => \$faker->boolean(20),
                'resolved_at' => \$status === 'resolved' ? \$faker->dateTimeBetween('-1 month', 'now') : null,
            ]);
        }
    }
}");

// PollSeeder
file_put_contents($dir . 'PollSeeder.php', "<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\Zone;
use Carbon\Carbon;

class PollSeeder extends Seeder
{
    public function run(): void
    {
        \$polls = [
            [
                'zone' => 'Model Town',
                'question' => 'What is the biggest safety issue in our zone right now?',
                'options' => ['Street lighting', 'Theft & chain snatching', 'Stray animals', 'Suspicious activity'],
                'expires_days' => 7
            ],
            [
                'zone' => 'Civil Lines',
                'question' => 'Should we request increased night patrolling from Jalandhar Police?',
                'options' => ['Yes, strongly needed', 'Yes, sometimes', 'Current patrolling is fine'],
                'expires_days' => 5
            ],
            [
                'zone' => 'Guru Nanak Pura',
                'question' => 'Rate your current feeling of safety in our colony',
                'options' => ['Very safe', 'Somewhat safe', 'Concerned', 'Feel unsafe'],
                'expires_days' => 10
            ]
        ];

        foreach (\$polls as \$p) {
            \$zone = Zone::where('name', \$p['zone'])->first();
            if (\$zone) {
                \$poll = Poll::create([
                    'zone_id' => \$zone->id,
                    'user_id' => 1,
                    'question' => \$p['question'],
                    'expires_at' => Carbon::now()->addDays(\$p['expires_days']),
                    'is_active' => true
                ]);

                foreach (\$p['options'] as \$optText) {
                    PollOption::create([
                        'poll_id' => \$poll->id,
                        'option_text' => \$optText
                    ]);
                }
            }
        }
    }
}");

echo "Seeders updated!\n";
