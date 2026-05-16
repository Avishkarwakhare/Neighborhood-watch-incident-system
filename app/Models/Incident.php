<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
    const STATUSES = [
        'pending'    => 'Pending',
        'processing' => 'Processing',
        'verified'   => 'Verified',
        'resolved'   => 'Resolved',
        'rejected'   => 'Rejected',
        'closed'     => 'Closed',
    ];

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'zone_id',
        'state_id',
        'city_id',
        'locality_id',
        'society_id',
        'title',
        'description',
        'category',
        'severity',
        'status',
        'location_address',
        'latitude',
        'longitude',
        'is_anonymous',
        'resolved_at',
        'official_note'
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'resolved_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class);
    }

    public function incidentMedia(): HasMany
    {
        return $this->hasMany(IncidentMedia::class, 'incident_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeByZone($query, $zoneId)
    {
        return $query->where('zone_id', $zoneId);
    }

    public function scopeBySeverity($query, $severity)
    {
        return $query->where('severity', $severity);
    }

    public function getSeverityColorAttribute()
    {
        return match($this->severity) {
            'low' => 'text-olive',
            'medium' => 'text-amber',
            'high' => 'text-terracotta',
            'critical' => 'text-rose',
            default => 'text-charcoal',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending'    => 'amber',
            'processing' => 'blue',
            'verified'   => 'teal',
            'resolved'   => 'green',
            'rejected'   => 'red',
            'closed'     => 'gray',
            default      => 'gray',
        };
    }
}
