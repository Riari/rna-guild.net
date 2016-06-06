<?php namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasTimestamps;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Commentable, HasOwner, HasTimestamps, Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'body', 'published_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'Article';

    /**
     * Scope: published
     *
     * @param  \Illuminate\Database\Query\Builder
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopePublished($query)
    {
        return $this->where('published_at', '<=', Carbon::now());
    }

    /**
     * Attribute: get 'published' time in diffForHumans format.
     *
     * @return string
     */
    public function getPublishedAgoAttribute()
    {
        return $this->published_at->setTimezone($this->getUserTimezone())->diffForHumans();
    }

    /**
     * Attribute: URL.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('article.show', ['article' => $this->id, 'title' => str_slug($this->title, '-')]);
    }
}
