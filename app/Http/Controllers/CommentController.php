<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Policies\CommentPolicy;
use App\Models\Business;
use Illuminate\Support\Facades\Gate;
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

    public function updateComment(Request $request, Comment $comment){
        
        if(Gate::denies('update', $comment)){
            return back()->with('error', 'Unauthroized to update this comment.');
        }

        $request->validate([
            'content' => 'required|min:5',
        ]);

        $comment->update(['content' => $request->content]);

        return back()->with('success', 'Comment updated successfully.');
    }

    public function deleteComment(Comment $comment)
    {
        if (Gate::denies('delete', $comment)) {
            return back()->with('error', 'Unauthorized to delete this comment.');
        }
    
        $comment->delete();
    
        return back()->with('success', 'Comment deleted successfully.');
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

    public function updateReply(Request $request, Comment $reply)
    {
        if (Gate::denies('update', $reply)) {
            return back()->with('error', 'Unauthorized to update this reply.');
        }

        $request->validate([
            'content' => 'required|min:5',
        ]);

        $reply->update(['content' => $request->content]);

        return back()->with('success', 'Reply updated successfully.');
    }

    public function deleteReply(Comment $reply)
    {
        if (Gate::denies('delete', $reply)) {
            return back()->with('error', 'Unauthorized to delete this reply.');
        }

        $reply->delete();

        return back()->with('success', 'Reply deleted successfully.');
    }
}
