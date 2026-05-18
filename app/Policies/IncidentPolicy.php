<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\User;

class IncidentPolicy
{
    public function view(User $user, Incident $incident): bool
    {
        return $user->id === $incident->user_id 
            || $user->society_id === $incident->society_id 
            || $user->locality_id === $incident->locality_id 
            || $user->zone_id === $incident->zone_id 
            || $user->hasRole(['admin', 'warden', 'law_enforcement']);
    }

    public function create(User $user): bool
    {
        return $user->is_approved;
    }

    public function update(User $user, Incident $incident): bool
    {
        return $user->id === $incident->user_id || $user->hasRole(['warden', 'admin']);
    }

    public function delete(User $user, Incident $incident): bool
    {
        return $user->hasRole('admin');
    }

    public function updateStatus(User $user, Incident $incident): bool
    {
        return $user->hasRole(['warden', 'law_enforcement', 'admin']);
    }
}
