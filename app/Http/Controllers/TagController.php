<?php namespace App\Http\Controllers;

use Auth;
use App\Models\Article;
use App\Models\Event;
use App\Util;
use Calendar;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Show tagged content page.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $tag = $request->route('tag');

        $articles = Article::published()->withAnyTag($tag)->orderBy('published_at', 'desc')->get();

        if (Auth::guest()) {
            $events = Event::withAnyTag($tag)->publicOnly()->get();
        } else {
            $events = Event::withAnyTag($tag)->get()->filter(function ($event) {
                return Auth::user()->can('view', $event);
            });
        }

        $calendar = Util::createCalendarFromEvents($events);
        return view('tag.show', compact('tag', 'articles', 'events', 'calendar'));
    }
}
