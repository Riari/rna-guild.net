<?php namespace App\Http\Controllers;

use Auth;
use App\Models\Event;
use App\Util;
use Calendar;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display the events overview page.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function overview(Request $request)
    {
        if (Auth::guest()) {
            $events = Event::publicOnly()->get();
        } else {
            $events = Event::all()->filter(function ($event) {
                return Auth::user()->can('view', $event);
            });
        }

        $calendar = Util::createCalendarFromEvents($events);
        return view('events.overview', compact('calendar'));
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

        return view('events.show', compact('event'));
    }
}
