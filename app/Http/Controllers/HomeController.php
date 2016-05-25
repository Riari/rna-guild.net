<?php namespace App\Http\Controllers;

use Auth;
use App\Models\Article;
use App\Models\Event;
use App\Models\Forum\Post;
use App\Models\Forum\Thread;
use App\Models\Session;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Return the homepage view.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $quotes = [
            "'Tis but a scratch!",
            "I fart in your general direction! Your mother was a hamster and your father smelt of elderberries!",
            "Listen, strange women lyin' in ponds distributin' swords is no basis for a system of government.",
            "It's just a flesh wound.",
            "How could a 5-ounce bird possibly carry a 1-pound coconut?",
            "Please! This is supposed to be a happy occasion. Let's not bicker and argue over who killed who.",
            "Look, that rabbit's got a vicious streak a mile wide! It's a killer!",
        ];

        $events = Auth::check() ? Event::upcoming() : Event::publicOnly()->upcoming();

        return view('page.home', [
            'quote' => $quotes[rand(0, count($quotes) - 1)],
            'upcomingEvents' => $events->orderBy('ends', 'desc')->limit(5)->get(),
            'newUsers' => User::activated()->orderBy('created_at', 'desc')->limit(5)->get(),
            'onlineUsers' => Session::authenticated()->groupBy('user_id')->recent()->limit(10)->get(),
            'newThreads' => Thread::with(['author', 'posts'])->orderBy('created_at', 'desc')->limit(5)->get(),
            'newPosts' => Post::where('post_id', '!=', null)->orderBy('created_at', 'DESC')->limit(5)->get(),
            'articles' => Article::published()->orderBy('published_at', 'desc')->paginate()
        ]);
    }
}
