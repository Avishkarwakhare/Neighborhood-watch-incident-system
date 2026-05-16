<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Incident;
use App\Models\Announcement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user()->load([
          'zone','locality','society','state','city'
        ]);

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Stats row
        $openIncidents = Incident::where('zone_id',
          $user->zone_id)
          ->whereIn('status',['pending','processing', 'verified'])
          ->count();

        $resolvedThisWeek = Incident::where('zone_id',
          $user->zone_id)
          ->where('status','resolved')
          ->where('resolved_at','>=',
            Carbon::now()->startOfWeek())
          ->count();

        $zoneMembers = User::where('zone_id',
          $user->zone_id)
          ->where('is_approved', true)
          ->count();

        $criticalCount = Incident::where('zone_id',
          $user->zone_id)
          ->where('severity','critical')
          ->whereIn('status',['pending','processing', 'verified'])
          ->count();

        // Incident feed (society-first filter)
        $incidents = Incident::with(['user','society',
          'locality','zone','comments'])
          ->where(function($q) use ($user) {
            $q->where('society_id', $user->society_id)
              ->orWhere('locality_id', $user->locality_id);
          })
          ->latest()
          ->paginate(8);

        // Activity timeline (merge incidents+announcements)
        $recentActivity = Incident::where('zone_id',
          $user->zone_id)
          ->latest()->take(5)->get()
          ->map(fn($i) => [
            'type'  => 'incident',
            'id'    => $i->id,
            'title' => $i->title,
            'status'=> $i->status,
            'status_color' => $i->status_color,
            'time'  => $i->created_at,
            'url'   => route('incidents.show',$i),
          ])
          ->merge(
            Announcement::where('zone_id',$user->zone_id)
            ->latest()->take(3)->get()
            ->map(fn($a) => [
              'type'     => 'announcement',
              'title'    => $a->title,
              'priority' => $a->priority,
              'time'     => $a->created_at,
              'url'      => route('announcements.show',$a),
            ])
          )
          ->sortByDesc('time')
          ->take(6)
          ->values();

        // Safety score
        $zoneIncidents = Incident::where('zone_id',
          $user->zone_id)
          ->whereIn('status',['pending','processing', 'verified'])
          ->get();
        $score = 100;
        foreach($zoneIncidents as $inc){
          $score -= match($inc->severity){
            'critical' => 15,
            'high'     => 8,
            'medium'   => 4,
            'low'      => 2,
            default    => 0,
          };
        }
        $resolvedBonus = Incident::where('zone_id',
          $user->zone_id)
          ->where('status','resolved')
          ->where('resolved_at','>=',
            Carbon::now()->startOfWeek())
          ->count() * 3;
        $safetyScore = max(10, min(100,
          $score + $resolvedBonus));
        $scoreLabel = match(true){
          $safetyScore >= 80 => 'Safe',
          $safetyScore >= 60 => 'Moderate',
          $safetyScore >= 40 => 'Concerning',
          default            => 'High Alert',
        };
        $scoreColor = match(true){
          $safetyScore >= 80 => '#639922',
          $safetyScore >= 60 => '#EF9F27',
          $safetyScore >= 40 => '#D85A30',
          default            => '#E24B4A',
        };

        // Safety tip of the day
        $tips = [
          'Lock your vehicle even for 2 minutes. Most thefts in Jalandhar happen near markets.',
          'Keep emergency numbers saved. Police control: 0181-2222220, Ambulance: 108.',
          'Report street light issues to MC helpline. Dark streets attract crime.',
          'Do not share your home address publicly on social media when traveling.',
          'Check on elderly neighbors during summer. Heat stroke is a serious risk.',
          'Keep important documents in a fireproof place at home.',
          'Suspicious vehicle? Note the number plate and report immediately.',
          'Walk in well-lit areas after dark. Use buddy system in unfamiliar areas.',
          'Install a door viewer (peephole) if you do not have one already.',
          'Know your block warden personally. Their contact is on your profile page.',
        ];
        $todayTip = $tips[
          Carbon::now()->dayOfYear % count($tips)
        ];

        // Active poll for user zone
        $activePoll = \App\Models\Poll::where('zone_id',
          $user->zone_id)
          ->where('is_active', true)
          ->where(function($q){
            $q->whereNull('expires_at')
              ->orWhere('expires_at','>', now());
          })
          ->with('options.votes')
          ->latest()
          ->first();
        $userVoted = $activePoll
          ? $activePoll->votes()
            ->where('user_id',$user->id)->exists()
          : false;

        // Top contributors (kudos leaderboard)
        $topContributors = User::where('zone_id',
          $user->zone_id)
          ->withCount('kudosReceived')
          ->orderByDesc('kudos_received_count')
          ->take(3)
          ->get();

        // Announcements for sidebar
        $announcements = Announcement::where('zone_id',
          $user->zone_id)
          ->active()
          ->latest()
          ->take(4)
          ->get();

        // Emergency announcements
        $emergencyAnnouncement = Announcement::where(
          'zone_id', $user->zone_id)
          ->where('priority','emergency')
          ->active()
          ->latest()
          ->first();

        // Incidents for mini map
        $mapIncidents = Incident::where('zone_id',
          $user->zone_id)
          ->whereNotNull('lat')
          ->whereNotNull('lng')
          ->whereIn('status',['pending','processing', 'verified'])
          ->latest()
          ->take(20)
          ->get(['id','title','severity',
                 'status','lat','lng']);

        return view('dashboard', compact(
          'user','openIncidents','resolvedThisWeek',
          'zoneMembers','criticalCount','incidents',
          'recentActivity','safetyScore','scoreLabel',
          'scoreColor','todayTip','activePoll',
          'userVoted','topContributors','announcements',
          'emergencyAnnouncement','mapIncidents'
        ));
    }
}
