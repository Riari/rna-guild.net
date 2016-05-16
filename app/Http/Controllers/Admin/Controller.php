<?php namespace App\Http\Controllers\Admin;

use App;

class Controller extends \App\Http\Controllers\Controller
{
    /**
     * Create a new admin controller instance.
     */
    public function __construct()
    {
        if (!App::runningInConsole()) {
            $this->authorize('admin');
        }
    }
}
