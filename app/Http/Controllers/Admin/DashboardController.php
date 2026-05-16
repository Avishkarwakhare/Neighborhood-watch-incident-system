<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->startOfMonth();

        $totalIncidentsThisMonth = Incident::where('created_at', '>=', $currentMonth)->count();
        $totalIncidentsLastMonth = Incident::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();
        
        $incidentsByCategory = Incident::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        $incidentsBySeverity = Incident::where('created_at', '>=', $currentMonth)
            ->selectRaw('severity, count(*) as count')
            ->groupBy('severity')
            ->pluck('count', 'severity');

        $totalResolved = Incident::where('status', 'resolved')->count();
        $totalIncidents = Incident::count();
        $resolutionRate = $totalIncidents > 0 ? round(($totalResolved / $totalIncidents) * 100) : 0;

        $recentIncidents = Incident::with(['zone', 'user'])->latest()->take(10)->get();

        $pendingApprovalsCount = User::where('is_approved', false)->count();

        return view('admin.dashboard', compact(
            'totalIncidentsThisMonth',
            'totalIncidentsLastMonth',
            'incidentsByCategory',
            'incidentsBySeverity',
            'resolutionRate',
            'recentIncidents',
            'pendingApprovalsCount'
        ));
    }
}
