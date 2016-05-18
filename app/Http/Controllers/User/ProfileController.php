<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show a user profile by user ID.
     *
     * @param  int  $id
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show($id, $name)
    {
        $user = User::findOrFail($id);
        return view('user.profile.show', compact('user') + [
            'commentPaginator' => $user->profile->comments()->orderBy('created_at', 'desc')->paginate()
        ]);
    }
}
