<?php namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasTimestamps;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use Commentable, HasOwner, HasTimestamps, Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'description', 'location', 'all_day', 'public', 'starts_at', 'ends_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['starts_at', 'ends_at'];

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'Event';

    /**
     * The format to use for formatted dates.
     *
     * @var string
     */
    const DATE_FORMAT = '%A %d %B %Y';

    /**
     * The format to use for formatted datetimes.
     *
     * @var string
     */
    const DATETIME_FORMAT = '%A %d %B %Y, %l%P';

    /**
     * Scope: public only
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopePublicOnly($query)
    {
        return $query->where('public', 1);
    }

    /**
     * Scope: upcoming
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('ends_at', '>', Carbon::now());
    }

    /**
     * Attribute: url
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('event.show', ['event' => $this->id, 'title' => str_slug($this->title, '-')]);
    }

    /**
     * Attribute: start time.
     *
     * @return \Carbon\Carbon
     */
    public function getStartsAttribute()
    {
        return $this->starts_at->setTimezone($this->getUserTimezone());
    }

    /**
     * Attribute: end time.
     *
     * @return \Carbon\Carbon
     */
    public function getEndsAttribute()
    {
        return $this->ends_at->setTimezone($this->getUserTimezone());
    }

    /**
     * Helper: formatted 'starts' datetime
     *
     * @return string
     */
    public function startsOn()
    {
        return $this->starts->formatLocalized($this->getFormat());
    }

    /**
     * Helper: formatted 'ends' datetime
     *
     * @return string
     */
    public function endsOn()
    {
        return $this->ends->setTimezone($this->getUserTimezone())->formatLocalized($this->getFormat());
    }

    /**
     * Helper: get date(time) format to be used for this event.
     *
     * @return string
     */
    private function getFormat()
    {
        return $this->all_day ? self::DATE_FORMAT : self::DATETIME_FORMAT;
    }
}
