<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole(['warden', 'admin']);
    }

    public function update(User $user, Announcement $announcement): bool
    {
        return $user->hasRole('admin') || ($user->hasRole('warden') && $user->zone_id === $announcement->zone_id);
    }

    public function delete(User $user, Announcement $announcement): bool
    {
        return $this->update($user, $announcement);
    }
}
