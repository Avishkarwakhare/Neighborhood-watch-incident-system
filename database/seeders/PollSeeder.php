<?php

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
        $polls = [
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

        foreach ($polls as $p) {
            $zone = Zone::where('name', $p['zone'])->first();
            if ($zone) {
                $poll = Poll::create([
                    'zone_id' => $zone->id,
                    'user_id' => 1,
                    'question' => $p['question'],
                    'expires_at' => Carbon::now()->addDays($p['expires_days']),
                    'is_active' => true
                ]);

                foreach ($p['options'] as $optText) {
                    PollOption::create([
                        'poll_id' => $poll->id,
                        'option_text' => $optText
                    ]);
                }
            }
        }
    }
}