<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentMapController extends Controller
{
    public function index()
    {
        return view('map.index');
    }

    public function mapData(Request $request)
    {
        $query = Incident::whereNotNull('lat')->whereNotNull('lng');
        
        if ($request->filled('categories')) {
            $query->whereIn('category', $request->categories);
        }
        if ($request->filled('severities')) {
            $query->whereIn('severity', $request->severities);
        }
        if ($request->filled('status') && $request->status !== 'All') {
            if ($request->status === 'Open') {
                $query->whereIn('status', ['pending', 'under_review']);
            } elseif ($request->status === 'Resolved') {
                $query->where('status', 'resolved');
            }
        }

        return response()->json($query->get());
    }
}
