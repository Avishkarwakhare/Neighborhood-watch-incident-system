<?php

namespace App\Http\Controllers;

use App\Models\Locality;
use Illuminate\Http\Request;

class LocalityController extends Controller
{
    public function index()
    {
        return response()->json(Locality::all());
    }

    public function societies(Locality $locality)
    {
        return response()->json($locality->societies);
    }
}
