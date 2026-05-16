<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;

class CommentPolicy
{
    public function create(User $user, Incident $incident): bool
    {
        return $user->is_approved && $incident->status !== 'dismissed';
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->hasRole(['admin', 'warden']);
    }
}
