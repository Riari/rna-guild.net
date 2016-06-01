<?php namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Event;
use App\Models\Forum\Category as ForumCategory;
use App\Models\User;
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
        return view('admin.dashboard', [
            'articles' => Article::count(),
            'events' => Event::count(),
            'eventsUpcoming' => Event::upcoming()->count(),
            'forumCategories' => ForumCategory::count(),
            'users' => User::count(),
            'usersUnconfirmed' => User::unconfirmed()->count(),
            'usersUnapproved' => User::unapproved()->count()
        ]);
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

        $resource = $this->resolve($model, $id);
        $resource->delete();

        Notification::success("{$model} #{$id} deleted.");
        return redirect('admin');
    }

    /**
     * Resolve a resource using the given model name and ID.
     *
     * @param  string  $model
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function resolve($model, $id)
    {
        $class = "\App\Models\\{$model}";
        return (new $class)->findOrFail($id);
    }
}
