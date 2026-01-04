<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like/dislike for a news item
     */
    public function toggle(Request $request, $newsId)
    {
        $request->validate([
            'is_like' => 'required|boolean', // true = like, false = dislike
        ]);

        // Update existing like/dislike or create new
        $like = Like::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'news_id' => $newsId,
            ],
            [
                'is_like' => $request->is_like,
            ]
        );

        return back()->with('success', $request->is_like ? 'Liked!' : 'Disliked!');
    }
}
