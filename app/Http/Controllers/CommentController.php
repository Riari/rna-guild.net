<?php namespace App\Http\Controllers;

use App\Models\Comment;
use App\Support\Traits\ResolvesModels;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;
use Notifynder;

class CommentController extends Controller
{
    use ResolvesModels;

    /**
     * Add a new comment.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'model'         => 'in:UserProfile,Event',
            'id'            => 'integer',
            'body'          => 'required|min:3',
            'redirect_to'   => 'url',
        ]);

        $model = $this->resolve($request->route('model'), $request->route('id'));
        $this->authorize('addComment', $model);

        $comment = new Comment;
        $comment->user_id = Auth::id();
        $comment->body = $request->input('body');

        $model->comments()->save($comment);

        if ($model->user->preference('comment_notifications', 1)) {
            Notifynder::category('comment.added')
                       ->from($comment->user)
                       ->to($model->user)
                       ->url("{$model->url}#comments")
                       ->extra(['model_name' => $model->friendlyName])
                       ->sendWithEmail();
        }

        Notification::success("Comment added.");

        return redirect($request->input('redirect_to'));
    }

    /**
     * Show the comment edit form.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        $this->authorize($comment);
        return view('comment.edit', compact('comment'));
    }

    /**
     * Update a comment.
     *
     * @param  Comment  $comment
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Comment $comment, Request $request)
    {
        $this->authorize('edit', $comment);
        $this->validate($request, [
            'body'          => 'required|min:3',
            'redirect_to'   => 'url',
        ]);

        $comment->body = $request->input('body');
        $comment->updated_at = Carbon::now();
        $comment->save();

        Notification::success("Comment updated.");

        return redirect($request->input('redirect_to'));
    }

    /**
     * Delete a comment.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function delete(Comment $comment)
    {
        $this->authorize($comment);

        $comment->delete();

        Notification::success("Comment removed.");

        return redirect()->back();
    }
}
