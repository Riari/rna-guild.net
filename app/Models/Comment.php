<?php namespace App\Models;

use App\Models\Traits\HasTimestamps;

class Comment extends \Slynova\Commentable\Models\Comment
{
    use HasTimestamps;

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
