<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreCommentRequest $request, Incident $incident)
    {
        $this->authorize('create', [Comment::class, $incident]);

        $user = $request->user();

        Comment::create([
            'incident_id' => $incident->id,
            'user_id' => $user->id,
            'body' => $request->body,
            'is_official' => $user->hasRole(['warden', 'law_enforcement', 'admin'])
        ]);

        return back()->with('success', 'Comment added.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
