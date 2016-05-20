<?php namespace App\Http\Controllers;

use Auth;
use App\Models\Event;
use App\Util;
use Calendar;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display an event index (calendar).
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guest()) {
            $events = Event::publicOnly()->get();
        } else {
            $events = Event::all()->filter(function ($event) {
                return Auth::user()->can('view', $event);
            });
        }

        $calendar = Util::createCalendarFromEvents($events);
        return view('event.index', compact('calendar'));
    }

    /**
     * Display an event.
     *
     * @param  Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        if (!$event->public) {
            $this->authorize('view', $event);
        }

        return view('event.show', compact('event') + [
            'commentPaginator' => $event->comments()->orderBy('created_at', 'desc')->paginate()
        ]);
    }
}
