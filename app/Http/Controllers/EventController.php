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
        $events = Auth::guest()
            ? Event::publicOnly()->get()
            : Event::all();

        $calendar = Util::createCalendarFromEvents(
            $events->filter(function ($event) {
                return Auth::user()->can('view', $event);
            })
        );

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
        $this->authorize('view', $event);
        return view('events.show', compact('event'));
    }
}
