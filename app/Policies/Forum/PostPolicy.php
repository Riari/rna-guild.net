<?php namespace App\Policies\Forum;

class PostPolicy extends \Riari\Forum\Policies\PostPolicy
{
    /**
     * Permission: Delete post.
     *
     * @param  object  $user
     * @param  Post  $post
     * @return bool
     */
    public function delete($user, Post $post)
    {
        return Gate::forUser($user)->allows('deletePosts', $post->thread);
    }
}
