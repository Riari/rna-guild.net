<?php namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given comment is editable by the given user.
     *
     * @param  User  $user
     * @param  Comment  $comment
     * @return bool
     */
    public function edit(User $user, Comment $comment)
    {
        return $user->can('admin') || $user->id == $comment->user->id;
    }

    /**
     * Determine if the given comment is deletable by the given user.
     *
     * @param  User  $user
     * @param  Comment  $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->can('admin');
    }
}
