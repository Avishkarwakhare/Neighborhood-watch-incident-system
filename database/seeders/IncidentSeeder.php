<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incident;
use App\Models\Zone;
use App\Models\Locality;

class IncidentSeeder extends Seeder
{
    public function run(): void
    {
        $localities = Locality::whereNotNull('zone_id')->get();
        if ($localities->isEmpty()) return;

        $categories = ['theft', 'fire', 'accident', 'suspicious_activity', 'vandalism', 'medical', 'natural_disaster', 'other'];
        $severities = ['low', 'medium', 'high', 'critical'];
        $faker = \Faker\Factory::create();

        $distribution = [
            'pending'    => 4,
            'processing' => 4,
            'verified'   => 4,
            'resolved'   => 4,
            'rejected'   => 2,
            'closed'     => 2,
        ];

        $realIncidents = [
            ['title' => 'Fire in Block C garbage dump', 'desc' => 'A small fire broke out near the Block C garbage collection area. Fire department has been notified.', 'cat' => 'fire', 'sev' => 'high'],
            ['title' => 'Suspicious individuals near back gate', 'desc' => 'Two unidentified individuals have been loitering near the society back gate for the last hour.', 'cat' => 'suspicious_activity', 'sev' => 'medium'],
            ['title' => 'Waterlogging on Main Avenue', 'desc' => 'Heavy rains have caused severe waterlogging on Main Avenue, making it difficult for vehicles to pass.', 'cat' => 'natural_disaster', 'sev' => 'medium'],
            ['title' => 'Minor accident near the park', 'desc' => 'A scooter skidded near the community park. The rider has minor scrapes. No ambulance needed.', 'cat' => 'accident', 'sev' => 'low'],
            ['title' => 'Theft of bicycle from parking', 'desc' => 'A red geared bicycle was stolen from the basement parking level 1 last night.', 'cat' => 'theft', 'sev' => 'high'],
            ['title' => 'Medical emergency in flat 402', 'desc' => 'Elderly resident in flat 402 had a fall and requires immediate medical assistance. Ambulance called.', 'cat' => 'medical', 'sev' => 'critical'],
            ['title' => 'Vandalism of park benches', 'desc' => 'Several park benches were found broken and defaced with spray paint this morning.', 'cat' => 'vandalism', 'sev' => 'low'],
            ['title' => 'Stray dog bite incident', 'desc' => 'A delivery person was bitten by a stray dog near Block A. Requesting animal control intervention.', 'cat' => 'medical', 'sev' => 'high'],
        ];

        foreach ($distribution as $status => $count) {
            for ($i = 0; $i < $count; $i++) {
                $loc = $localities->random();
                $incidentData = $faker->randomElement($realIncidents);

                $resolvedAt = null;
                if ($status === 'resolved') {
                    $resolvedAt = now()->subDays(rand(1, 7));
                } elseif ($status === 'closed') {
                    $resolvedAt = now()->subDays(rand(8, 30));
                }

                $officialNote = null;
                if ($status === 'rejected') {
                    $officialNote = "Incident could not be verified with available evidence.";
                }

                Incident::create([
                    'user_id' => 1,
                    'zone_id' => $loc->zone_id,
                    'state_id' => $loc->city->state_id ?? null,
                    'city_id' => $loc->city_id ?? null,
                    'locality_id' => $loc->id,
                    'title' => $incidentData['title'],
                    'description' => $incidentData['desc'],
                    'category' => $incidentData['cat'],
                    'severity' => $incidentData['sev'],
                    'status' => $status,
                    'location_address' => $faker->address,
                    'latitude' => $loc->lat + ($faker->randomFloat(4, -0.01, 0.01)),
                    'longitude' => $loc->lng + ($faker->randomFloat(4, -0.01, 0.01)),
                    'is_anonymous' => $faker->boolean(20),
                    'resolved_at' => $resolvedAt,
                    'official_note' => $officialNote,
                ]);
            }
        }
    }
}