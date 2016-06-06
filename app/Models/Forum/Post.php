<?php namespace App\Models\Forum;

use App\Models\Traits\HasTimestamps;

class Post extends \Riari\Forum\Models\Post
{
    use HasTimestamps;

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'Forum Post';
}
