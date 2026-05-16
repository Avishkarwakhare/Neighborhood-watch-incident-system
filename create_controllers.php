<?php

$files = [
    // Poll Controller
    'app/Http/Controllers/PollController.php' => "<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        \$user = auth()->user();
        \$polls = Poll::with('options')
            ->where('zone_id', \$user->zone_id)
            ->where('is_active', true)
            ->latest()
            ->get();
            
        return view('polls.index', compact('polls'));
    }

    public function vote(Request \$request, Poll \$poll)
    {
        \$request->validate([
            'poll_option_id' => 'required|exists:poll_options,id'
        ]);

        \$user = auth()->user();

        if (PollVote::where('poll_id', \$poll->id)->where('user_id', \$user->id)->exists()) {
            return response()->json(['error' => 'Already voted'], 403);
        }

        PollVote::create([
            'poll_id' => \$poll->id,
            'poll_option_id' => \$request->poll_option_id,
            'user_id' => \$user->id
        ]);

        return response()->json(['success' => true, 'results' => \$poll->getResults()]);
    }
}
",
    // Locality Controller
    'app/Http/Controllers/LocalityController.php' => "<?php

namespace App\Http\Controllers;

use App\Models\Locality;
use Illuminate\Http\Request;

class LocalityController extends Controller
{
    public function index()
    {
        return response()->json(Locality::all());
    }

    public function societies(Locality \$locality)
    {
        return response()->json(\$locality->societies);
    }
}
",
    // Map Controller
    'app/Http/Controllers/IncidentMapController.php' => "<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentMapController extends Controller
{
    public function index()
    {
        return view('map.index');
    }

    public function mapData(Request \$request)
    {
        \$query = Incident::whereNotNull('lat')->whereNotNull('lng');
        
        if (\$request->filled('categories')) {
            \$query->whereIn('category', \$request->categories);
        }
        if (\$request->filled('severities')) {
            \$query->whereIn('severity', \$request->severities);
        }
        if (\$request->filled('status') && \$request->status !== 'All') {
            if (\$request->status === 'Open') {
                \$query->whereIn('status', ['pending', 'under_review']);
            } elseif (\$request->status === 'Resolved') {
                \$query->where('status', 'resolved');
            }
        }

        return response()->json(\$query->get());
    }
}
",
    // ZoneSafetyScoreService
    'app/Services/ZoneSafetyScoreService.php' => "<?php

namespace App\Services;

use App\Models\Zone;
use App\Models\Incident;
use Carbon\Carbon;

class ZoneSafetyScoreService
{
    public static function calculateScore(Zone \$zone)
    {
        \$score = 100;
        
        \$activeIncidents = Incident::where('zone_id', \$zone->id)
            ->whereIn('status', ['pending', 'under_review'])
            ->get();
            
        foreach (\$activeIncidents as \$incident) {
            switch (\$incident->severity) {
                case 'critical': \$score -= 15; break;
                case 'high': \$score -= 8; break;
                case 'medium': \$score -= 4; break;
                case 'low': \$score -= 2; break;
            }
        }
        
        \$resolvedThisWeek = Incident::where('zone_id', \$zone->id)
            ->where('status', 'resolved')
            ->where('resolved_at', '>=', Carbon::now()->subWeek())
            ->count();
            
        \$score += (\$resolvedThisWeek * 3);
        
        return max(10, min(100, \$score));
    }
}
",
];

foreach ($files as $path => $content) {
    $dir = dirname(__DIR__ . '/' . $path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents(__DIR__ . '/' . $path, $content);
}

echo "Files created successfully!\n";
