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
            'locality_id' => ['required', 'exists:localities,id'],
            'society_id' => ['required', 'exists:societies,id'],
            'house_no' => ['nullable', 'string', 'max:100'],
        ], [
            'state_id.required' => 'Please select your state.',
            'city_id.required' => 'Please select your city.',
            'locality_id.required' => 'Please select your area.',
            'society_id.required' => 'Please select your society or colony.',
        ]);

        $locality = \App\Models\Locality::find($request->locality_id);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'locality_id' => $request->locality_id,
            'society_id' => $request->society_id,
            'house_no' => $request->house_no,
            'zone_id' => $locality->zone_id ?? null, // keep zone_id for legacy fallback
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
