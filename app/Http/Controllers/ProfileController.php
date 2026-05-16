<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update location information.
     */
    public function updateLocation(Request $request): RedirectResponse
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'locality_id' => 'required|exists:localities,id',
            'society_id' => 'required|exists:societies,id',
            'house_no' => 'nullable|string|max:100',
        ]);
        
        $locality = \App\Models\Locality::find($request->locality_id);

        $user = auth()->user();
        $user->update([
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'locality_id' => $request->locality_id,
            'society_id' => $request->society_id,
            'house_no' => $request->house_no,
            'zone_id' => $locality->zone_id ?? $user->zone_id,
        ]);

        return redirect()->back()->with('success', 'Location updated successfully.');
    }
}