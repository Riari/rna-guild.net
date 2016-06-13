<?php namespace App\Policies\Forum;

use Riari\Forum\Models\Category;

class CategoryPolicy extends \Riari\Forum\Policies\CategoryPolicy
{
    /**
     * Permission: Create threads in category.
     *
     * @param  object  $user
     * @param  Category  $category
     * @return bool
     */
    public function createThreads($user, Category $category)
    {
        return $user->isActive;
    }

    /**
     * Permission: Delete threads in category.
     *
     * @param  object  $user
     * @param  Category  $category
     * @return bool
     */
    public function deleteThreads($user, Category $category)
    {
        return $user->can('admin');
    }

    /**
     * Permission: Enable threads in category.
     *
     * @param  object  $user
     * @param  Category  $category
     * @return bool
     */
    public function enableThreads($user, Category $category)
    {
        return $user->can('admin');
    }

    /**
     * Permission: Move threads from category.
     *
     * @param  object  $user
     * @param  Category  $category
     * @return bool
     */
    public function moveThreadsFrom($user, Category $category)
    {
        return $user->can('admin');
    }

    /**
     * Permission: Move threads to category.
     *
     * @param  object  $user
     * @param  Category  $category
     * @return bool
     */
    public function moveThreadsTo($user, Category $category)
    {
        return $user->can('admin');
    }

    /**
     * Permission: Lock threads in category.
     *
     * @param  object  $user
     * @param  Category  $category
     * @return bool
     */
    public function lockThreads($user, Category $category)
    {
        return $user->can('admin');
    }

    /**
     * Permission: Pin threads in category.
     *
     * @param  object  $user
     * @param  Category  $category
     * @return bool
     */
    public function pinThreads($user, Category $category)
    {
        return $user->can('admin');
    }

    /**
     * Permission: View category. Only takes effect for 'private' categories.
     *
     * @param  object  $user
     * @param  Category  $category
     * @return bool
     */
    public function view($user, Category $category)
    {
        return $user->can('admin');
    }

    /**
     * Permission: Delete category.
     *
     * @param  object  $user
     * @param  Category  $category
     * @return bool
     */
    public function delete($user, Category $category)
    {
        return $user->can('admin');
    }
}
