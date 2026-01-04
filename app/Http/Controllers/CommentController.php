<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Store a comment for a news item
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $newsId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, int $newsId): RedirectResponse
    {
        $user = Auth::user();

        // Check if user is blocked
        if ($user->is_blocked) {
            return back()->withErrors([
                'comment' => 'You are blocked from commenting.'
            ]);
        }

        // Validate input
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Ensure the news exists
        $news = News::findOrFail($newsId);

        // Create comment
        Comment::create([
            'user_id' => $user->id,
            'news_id' => $news->id,
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Comment added successfully!');
    }
}
