<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;

class EventController extends Controller
{
    /**
     * @var array
     */
    protected $rules = [
        'title' => 'required'
    ];

    /**
     * Display an index of events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.event.index', [
            'paginator' => Event::orderBy('created_at', 'desc')->paginate()
        ]);
    }

    /**
     * Display a create event page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->edit(new Event);
    }

    /**
     * Store an event.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $event = Event::create([
            'user_id' => Auth::user()->id,
            'starts_at' => Carbon::createFromFormat(DT_INPUT_FORMAT, $request->input('starts_at')),
            'ends_at' => Carbon::createFromFormat(DT_INPUT_FORMAT, $request->input('ends_at'))
        ] + $request->only('title', 'description', 'location', 'all_day', 'public'));

        if ($request->has('tags')) {
            $event->tag($request->input('tags'));
        }

        Notification::success("Event created.");
        return redirect('admin/event');
    }

    /**
     * Display an edit event page.
     *
     * @param  Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $tags = implode(',',  $event->tagNames());
        $starts = !empty($event->starts_at)
            ? $event->starts_at->format(DT_INPUT_FORMAT)
            : Carbon::now()->format(DT_INPUT_FORMAT);
        $ends = !empty($event->ends_at)
            ? $event->ends_at->format(DT_INPUT_FORMAT)
            : Carbon::now()->format(DT_INPUT_FORMAT);

        return view('admin.event.edit', compact('event', 'tags', 'starts', 'ends'));
    }

    /**
     * Update an event.
     *
     * @param  Event  $event
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Event $event, Request $request)
    {
        $this->validate($request, $this->rules);

        $event->update([
            'starts_at' => Carbon::createFromFormat(DT_INPUT_FORMAT, $request->input('starts_at')),
            'ends_at' => Carbon::createFromFormat(DT_INPUT_FORMAT, $request->input('ends_at')),
        ] + $request->only('title', 'description', 'location', 'all_day', 'public'));

        if ($request->has('tags')) {
            $event->retag($request->input('tags'));
        }

        Notification::success("Event updated.");
        return redirect('admin/event');
    }
}
