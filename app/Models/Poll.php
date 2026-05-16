<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['zone_id', 'user_id', 'question', 'expires_at', 'is_active'];
    protected $casts = ['expires_at' => 'datetime', 'is_active' => 'boolean'];

    public function zone() { return $this->belongsTo(Zone::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function options() { return $this->hasMany(PollOption::class); }
    public function votes() { return $this->hasMany(PollVote::class); }

    public function getResults()
    {
        $totalVotes = $this->votes()->count();
        if ($totalVotes === 0) return [];
        
        return $this->options->map(function ($option) use ($totalVotes) {
            $votes = $option->votes()->count();
            return [
                'id' => $option->id,
                'text' => $option->option_text,
                'votes' => $votes,
                'percentage' => round(($votes / $totalVotes) * 100)
            ];
        });
    }
}