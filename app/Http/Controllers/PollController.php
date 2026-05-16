<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $polls = Poll::with('options')
            ->where('zone_id', $user->zone_id)
            ->where('is_active', true)
            ->latest()
            ->get();
            
        return view('polls.index', compact('polls'));
    }

    public function vote(Request $request, Poll $poll)
    {
        $request->validate([
            'poll_option_id' => 'required|exists:poll_options,id'
        ]);

        $alreadyVoted = PollVote::where([
            'poll_id' => $poll->id,
            'user_id' => auth()->id(),
        ])->exists();

        if($alreadyVoted){
            return response()->json([
                'error' => 'Already voted'
            ], 422);
        }

        PollVote::create([
            'poll_id'        => $poll->id,
            'poll_option_id' => $request->poll_option_id,
            'user_id'        => auth()->id(),
        ]);

        $results = $poll->options->map(fn($opt) => [
            'id'    => $opt->id,
            'text'  => $opt->option_text,
            'votes' => $opt->votes()->count(),
            'pct'   => $poll->votes()->count() > 0
            ? round(
                ($opt->votes()->count() /
                $poll->votes()->count()) * 100
                )
            : 0,
        ]);

        return response()->json([
            'success' => true,
            'results' => $results,
            'total'   => $poll->votes()->count(),
        ]);
    }
}
