<?php namespace App\Models;

use App\Models\Traits\HasOwner;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasOwner, Taggable;

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
     * Scope: published
     *
     * @param  \Illuminate\Database\Query\Builder
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopePublished($query)
    {
        return $this->where('published_at', '<=', Carbon::now());
    }
}
