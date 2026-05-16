<?php
namespace App\Http\Controllers;
use App\Models\State;
use App\Models\City;
use App\Models\Locality;

class LocationController extends Controller {
    public function states() {
        return response()->json(State::select('id', 'name', 'code')->get());
    }
    public function cities(State $state) {
        return response()->json($state->cities()->select('id', 'name')->get());
    }
    public function localities(City $city) {
        return response()->json($city->localities()->select('id', 'name')->get());
    }
    public function societies(Locality $locality) {
        return response()->json($locality->societies()->select('id', 'name', 'type', 'landmark', 'pincode')->get());
    }
}