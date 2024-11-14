<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function storeComment(Request $request, $businessId)
    {
        $request->validate([
            'content' => 'required|min:5',
        ]);

        Comment::create([
            'content'=> $request->input('content'),
            'user_id'=> Auth::user()->id,
            'business_id'=> $businessId,
        ]);

        return back()->with('success', 'Comment posted successfully.');
    }

    public function reply(Request $request, Business $business, Comment $comment)
    {
        $request->validate([
            'content' => 'required|min:5',
        ]);

        // Create a reply linked to the parent comment
        $comment->replies()->create([
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'business_id' => $business->id,
            'parent_id' => $comment->id,
        ]);

        return back()->with('success', 'Reply posted successfully.');
    }
}
