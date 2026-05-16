<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Locality extends Model {
    protected $fillable = ['city_id', 'name'];
    public function city() { return $this->belongsTo(City::class); }
    public function societies() { return $this->hasMany(Society::class); }
    public function users() { return $this->hasMany(User::class); }
    public function zone() { return $this->belongsTo(Zone::class); }
}