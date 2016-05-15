<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new admin controller instance.
     */
    public function __construct()
    {
        $this->authorize('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard()
    {
        return view('admin.dashboard');
    }
}
