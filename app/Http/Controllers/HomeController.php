<?php namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Forum\Post;
use App\Models\Forum\Thread;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Return the homepage view.
     *
     * @param  \Illuminate\Http\Request  $request
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

        return view('pages.home', [
            'quote' => $quotes[rand(0, count($quotes) - 1)],
            'newUsers' => User::orderBy('created_at', 'desc')->limit(5)->get(),
            'newThreads' => Thread::orderBy('created_at', 'desc')->limit(5)->get(),
            'newPosts' => Post::orderBy('created_at', 'desc')->limit(5)->get(),
            'articles' => Article::published()->paginate()
        ]);
    }
}
