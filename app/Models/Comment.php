<?php namespace App\Models;

class Comment extends \Slynova\Commentable\Models\Comment
{
    /**
     * Get the name of the "updated at" column.
     *
     * @return string
     */
    public function getUpdatedAtColumn()
    {
        return null;
    }
}
