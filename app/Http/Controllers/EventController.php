<?php namespace App\Http\Controllers;

use Auth;
use App\Models\Event;
use App\Utils;
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
        $calendar = Utils::createCalendarFromEvents(Auth::check() ? Event::all() : Event::publicOnly()->get());
        return view('events.overview', compact('calendar'));
    }

    /**
     * Display an event.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $event = Event::findOrFail($request->route('id'));
        return view('events.show', compact('event'));
    }
}
