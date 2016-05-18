<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Notification;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard()
    {
        $links = [
            'article'           => 'Articles',
            'event'             => 'Events',
            'forum/category'    => 'Forum Categories'
        ];

        return view('admin.dashboard', compact('links'));
    }

    /**
     * Show the resource deletion page.
     *
     * @param  string  $model
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDeleteResource($model, $id)
    {
        return view('admin.delete-resource', compact('model', 'id'));
    }

    /**
     * Handle a resource deletion request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postDeleteResource(Request $request)
    {
        $model = $request->route('model');
        $id = $request->route('id');

        $class = "\App\Models\\{$model}";
        $resource = (new $class)->findOrFail($id);
        $resource->delete();

        Notification::success("{$model} #{$id} deleted.");
        return redirect('admin');
    }
}
