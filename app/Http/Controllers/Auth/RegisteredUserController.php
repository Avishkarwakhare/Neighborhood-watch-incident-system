<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $states = \App\Models\State::orderBy('name')->get();
        return view('auth.register', compact('states'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'locality_id' => ['required', 'string'],
            'custom_locality' => ['required_if:locality_id,other', 'nullable', 'string', 'max:255'],
            'society_id' => ['required', 'string'],
            'custom_society' => ['required_if:society_id,other', 'nullable', 'string', 'max:255'],
            'house_no' => ['nullable', 'string', 'max:100'],
        ], [
            'state_id.required' => 'Please select your state.',
            'city_id.required' => 'Please select your city.',
            'locality_id.required' => 'Please select your area.',
            'custom_locality.required_if' => 'Please enter your custom locality/area name.',
            'society_id.required' => 'Please select your society or colony.',
            'custom_society.required_if' => 'Please enter your custom society/colony name.',
        ]);

        $localityId = $request->locality_id;
        if ($localityId === 'other') {
            $locality = \App\Models\Locality::firstOrCreate([
                'city_id' => $request->city_id,
                'name' => $request->custom_locality,
            ]);
            $localityId = $locality->id;
        } else {
            $locality = \App\Models\Locality::find($localityId);
        }

        $societyId = $request->society_id;
        if ($societyId === 'other') {
            $society = \App\Models\Society::firstOrCreate([
                'locality_id' => $localityId,
                'name' => $request->custom_society,
            ], [
                'type' => 'colony',
            ]);
            $societyId = $society->id;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'locality_id' => $localityId,
            'society_id' => $societyId,
            'house_no' => $request->house_no,
            'zone_id' => $locality->zone_id ?? null, // keep zone_id for legacy fallback
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
