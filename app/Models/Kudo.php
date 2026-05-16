<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kudo extends Model
{
    protected $fillable = ['giver_id', 'receiver_id', 'incident_id', 'message'];

    public function giver() { return $this->belongsTo(User::class, 'giver_id'); }
    public function receiver() { return $this->belongsTo(User::class, 'receiver_id'); }
    public function incident() { return $this->belongsTo(Incident::class); }
}