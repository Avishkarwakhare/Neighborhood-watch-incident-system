<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::with('warden')->withCount('incidents')->latest()->paginate(10);
        return view('admin.zones.index', compact('zones'));
    }

    public function create()
    {
        return view('admin.zones.create'); // Optional if modal is used
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
        ]);

        Zone::create($data);

        return back()->with('success', 'Zone created successfully.');
    }

    public function show(Zone $zone)
    {
        return view('admin.zones.show', compact('zone'));
    }

    public function edit(Zone $zone)
    {
        return view('admin.zones.edit', compact('zone')); // Optional
    }

    public function update(Request $request, Zone $zone)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'warden_id' => 'nullable|exists:users,id',
        ]);

        $zone->update($data);

        return back()->with('success', 'Zone updated successfully.');
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();
        return back()->with('success', 'Zone deleted.');
    }
}
