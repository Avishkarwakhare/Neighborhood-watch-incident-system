<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'state_id',
        'city_id',
        'phone',
        'zone_id',
        'locality_id',
        'society_id',
        'avatar',
        'is_approved',
        'address',
        'house_no',
        'full_address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class);
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function hasRole(string|array $role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    public function isApproved(): bool
    {
        return $this->is_approved;
    }

    public function getFullAddressAttribute(): ?string
    {
        if ($this->attributes['full_address'] ?? null) {
            return $this->attributes['full_address'];
        }
        $parts = [];
        if ($this->house_no) $parts[] = $this->house_no;
        if ($this->society) $parts[] = $this->society->name;
        if ($this->locality) $parts[] = $this->locality->name;
        if ($this->city) $parts[] = $this->city->name;
        if ($this->state) {
            $stateStr = $this->state->name;
            if ($this->society && $this->society->pincode) {
                $stateStr .= ' - ' . $this->society->pincode;
            }
            $parts[] = $stateStr;
        }
        return count($parts) > 0 ? implode(', ', $parts) : null;
    }

    public function kudosReceived(): HasMany
    {
        return $this->hasMany(Kudo::class, 'receiver_id');
    }

    public function kudosGiven(): HasMany
    {
        return $this->hasMany(Kudo::class, 'giver_id');
    }
}
