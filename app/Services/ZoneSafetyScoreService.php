<?php

namespace App\Services;

use App\Models\Zone;
use App\Models\Incident;
use Carbon\Carbon;

class ZoneSafetyScoreService
{
    public static function calculateScore(Zone $zone)
    {
        $score = 100;
        
        $activeIncidents = Incident::where('zone_id', $zone->id)
            ->whereIn('status', ['pending', 'under_review'])
            ->get();
            
        foreach ($activeIncidents as $incident) {
            switch ($incident->severity) {
                case 'critical': $score -= 15; break;
                case 'high': $score -= 8; break;
                case 'medium': $score -= 4; break;
                case 'low': $score -= 2; break;
            }
        }
        
        $resolvedThisWeek = Incident::where('zone_id', $zone->id)
            ->where('status', 'resolved')
            ->where('resolved_at', '>=', Carbon::now()->subWeek())
            ->count();
            
        $score += ($resolvedThisWeek * 3);
        
        return max(10, min(100, $score));
    }
}
