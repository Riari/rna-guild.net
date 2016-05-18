<?php namespace App\Http\Controllers;

use Auth;
use App\Models\Comment;
use Illuminate\Http\Request;
use Notification;

class CommentController extends Controller
{
    /**
     * Add a new comment.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'model'         => 'in:UserProfile,Event',
            'id'            => 'integer',
            'body'          => 'required|min:3',
            'redirect_to'   => 'url',
        ]);

        $class = "\\App\\Models\\{$request->route('model')}";
        $model = (new $class)->findOrFail($request->route('id'));
        $this->authorize('addComment', $model);

        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->body = $request->input('body');

        $model->comments()->save($comment);

        Notification::success("Comment added.");

        return redirect($request->input('redirect_to'));
    }
}
