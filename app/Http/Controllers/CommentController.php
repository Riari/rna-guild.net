<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Notification;
use Slynova\Commentable\Models\Comment;

class CommentController extends Controller
{
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

        $model = $this->getModel($request->route('model'), $request->route('id'));
        $this->authorize('addComment', $model);

        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->body = $request->input('body');

        $model->comments()->save($comment);

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

    /**
     * Retrieve a model by name and ID.
     *
     * @param  string  $name
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getModel($name, $id)
    {
        $class = "\\App\\Models\\{$name}";
        return(new $class)->findOrFail($id);
    }
}
