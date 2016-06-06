<?php namespace App\Models\Forum;

use App\Models\Traits\HasTimestamps;

class Category extends \Riari\Forum\Models\Category
{
    use HasTimestamps;

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'Forum Category';
}
