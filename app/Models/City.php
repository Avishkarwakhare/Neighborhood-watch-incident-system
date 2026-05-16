<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class City extends Model {
    protected $fillable = ['state_id', 'name', 'pincode_prefix'];
    public function state() { return $this->belongsTo(State::class); }
    public function localities() { return $this->hasMany(Locality::class); }
    public function users() { return $this->hasMany(User::class); }
}