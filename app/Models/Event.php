<?php namespace App\Models;

use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'description', 'location', 'all_day', 'public', 'starts', 'ends'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['starts', 'ends'];

    /**
     * Relationship: user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

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
        return $query->where('ends', '>', Carbon::now());
    }

    /**
     * Attribute: url
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('event.view', ['id' => $this->id, 'title' => str_slug($this->title, '-')]);
    }
}
