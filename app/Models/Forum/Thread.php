<?php namespace App\Models\Forum;

use App\Models\Traits\HasTimestamps;

class Thread extends \Riari\Forum\Models\Thread
{
    use HasTimestamps;

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'Forum Thread';
}
