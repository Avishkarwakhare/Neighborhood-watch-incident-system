<?php

$baseDir = __DIR__;

// Models
file_put_contents($baseDir . '/app/Models/State.php', "<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class State extends Model {
    protected \$fillable = ['name', 'code'];
    public function cities() { return \$this->hasMany(City::class); }
    public function users() { return \$this->hasMany(User::class); }
}");

file_put_contents($baseDir . '/app/Models/City.php', "<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class City extends Model {
    protected \$fillable = ['state_id', 'name', 'pincode_prefix'];
    public function state() { return \$this->belongsTo(State::class); }
    public function localities() { return \$this->hasMany(Locality::class); }
    public function users() { return \$this->hasMany(User::class); }
}");

file_put_contents($baseDir . '/app/Models/Locality.php', "<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Locality extends Model {
    protected \$fillable = ['city_id', 'name'];
    public function city() { return \$this->belongsTo(City::class); }
    public function societies() { return \$this->hasMany(Society::class); }
    public function users() { return \$this->hasMany(User::class); }
    public function zone() { return \$this->belongsTo(Zone::class); }
}");

file_put_contents($baseDir . '/app/Models/Society.php', "<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Society extends Model {
    protected \$fillable = ['locality_id', 'name', 'type', 'landmark', 'pincode', 'lat', 'lng'];
    public function locality() { return \$this->belongsTo(Locality::class); }
    public function users() { return \$this->hasMany(User::class); }
    public function incidents() { return \$this->hasMany(Incident::class); }
    public function getFullNameAttribute() {
        return \$this->name . ', ' . \$this->locality->name . ', ' . \$this->locality->city->name;
    }
}");

// Update User model methods
$userPath = $baseDir . '/app/Models/User.php';
$userCode = file_get_contents($userPath);

if (strpos($userCode, 'state_id') === false) {
    // Add fillables
    $userCode = str_replace(
        "'role',",
        "'role',\n        'state_id',\n        'city_id',",
        $userCode
    );
    // Add relationships
    $userCode = str_replace(
        "public function zone(): BelongsTo",
        "public function state(): BelongsTo\n    {\n        return \$this->belongsTo(State::class);\n    }\n\n    public function city(): BelongsTo\n    {\n        return \$this->belongsTo(City::class);\n    }\n\n    public function zone(): BelongsTo",
        $userCode
    );
    // Update getFullAddressAttribute
    $newAddressLogic = "
    public function getFullAddressAttribute(): ?string
    {
        if (\$this->attributes['full_address'] ?? null) {
            return \$this->attributes['full_address'];
        }
        \$parts = [];
        if (\$this->house_no) \$parts[] = \$this->house_no;
        if (\$this->society) \$parts[] = \$this->society->name;
        if (\$this->locality) \$parts[] = \$this->locality->name;
        if (\$this->city) \$parts[] = \$this->city->name;
        if (\$this->state) {
            \$stateStr = \$this->state->name;
            if (\$this->society && \$this->society->pincode) {
                \$stateStr .= ' - ' . \$this->society->pincode;
            }
            \$parts[] = \$stateStr;
        }
        return count(\$parts) > 0 ? implode(', ', \$parts) : null;
    }";
    // Replacing the old function entirely
    $userCode = preg_replace('/public function getFullAddressAttribute\(\).*?^    \}/ms', ltrim($newAddressLogic), $userCode);
    
    file_put_contents($userPath, $userCode);
}


// Controllers
file_put_contents($baseDir . '/app/Http/Controllers/LocationController.php', "<?php
namespace App\Http\Controllers;
use App\Models\State;
use App\Models\City;
use App\Models\Locality;

class LocationController extends Controller {
    public function states() {
        return response()->json(State::select('id', 'name', 'code')->get());
    }
    public function cities(State \$state) {
        return response()->json(\$state->cities()->select('id', 'name')->get());
    }
    public function localities(City \$city) {
        return response()->json(\$city->localities()->select('id', 'name')->get());
    }
    public function societies(Locality \$locality) {
        return response()->json(\$locality->societies()->select('id', 'name', 'type', 'landmark', 'pincode')->get());
    }
}");

file_put_contents($baseDir . '/app/Http/Controllers/ProfileController.php', "<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ProfileController extends Controller {
    public function updateLocation(Request \$request) {
        \$request->validate([
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'locality_id' => 'required|exists:localities,id',
            'society_id' => 'required|exists:societies,id',
            'house_no' => 'nullable|string|max:100',
        ]);
        \$user = auth()->user();
        \$user->update(\$request->only(['state_id', 'city_id', 'locality_id', 'society_id', 'house_no']));
        return redirect()->back()->with('success', 'Location updated successfully.');
    }
}");

// Update routes
$apiRoutesPath = $baseDir . '/routes/api.php';
$apiRoutesCode = file_exists($apiRoutesPath) ? file_get_contents($apiRoutesPath) : "<?php\nuse Illuminate\Support\Facades\Route;\n";
if (strpos($apiRoutesCode, 'LocationController') === false) {
    $apiRoutesCode .= "\nuse App\Http\Controllers\LocationController;
Route::get('/states', [LocationController::class, 'states']);
Route::get('/states/{state}/cities', [LocationController::class, 'cities']);
Route::get('/cities/{city}/localities', [LocationController::class, 'localities']);
Route::get('/localities/{locality}/societies', [LocationController::class, 'societies']);
";
    file_put_contents($apiRoutesPath, $apiRoutesCode);
}

$webRoutesPath = $baseDir . '/routes/web.php';
$webRoutesCode = file_get_contents($webRoutesPath);
if (strpos($webRoutesCode, 'ProfileController@updateLocation') === false) {
    // Add the route somewhere inside middleware('auth')
    $webRoutesCode = str_replace(
        "Route::middleware('auth')->group(function () {",
        "use App\Http\Controllers\ProfileController;\nRoute::middleware('auth')->group(function () {\n    Route::patch('/profile/location', [ProfileController::class, 'updateLocation'])->name('profile.location.update');",
        $webRoutesCode
    );
    file_put_contents($webRoutesPath, $webRoutesCode);
}

echo "Controllers, Models and Routes setup done.\n";
