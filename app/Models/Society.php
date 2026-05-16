<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Society extends Model {
    protected $fillable = ['locality_id', 'name', 'type', 'landmark', 'pincode', 'lat', 'lng'];
    public function locality() { return $this->belongsTo(Locality::class); }
    public function users() { return $this->hasMany(User::class); }
    public function incidents() { return $this->hasMany(Incident::class); }
    public function getFullNameAttribute() {
        return $this->name . ', ' . $this->locality->name . ', ' . $this->locality->city->name;
    }
}