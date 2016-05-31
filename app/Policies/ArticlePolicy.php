<?php namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can add a comment on the article.
     *
     * @param  User  $user
     * @param  Article  $article
     * @return bool
     */
    public function addComment(User $user, Article $article)
    {
        return $user->isActive;
    }
}
