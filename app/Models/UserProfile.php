<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TeamTeaTime\Filer\AttachableTrait as Attachable;
use Slynova\Commentable\Traits\Commentable;

class UserProfile extends Model
{
    use Attachable, Commentable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'about', 'signature'];

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'User Profile';

    /**
     * Relationship: User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Attribute: Picture.
     *
     * @return \TeamTeaTime\Filer\Attachment
     */
    public function getPictureAttribute()
    {
        return $this->attachments()->key('picture')->first();
    }

    /**
     * Attribute: Backdrop.
     *
     * @return \TeamTeaTime\Filer\Attachment
     */
    public function getBackdropAttribute()
    {
        return $this->attachments()->key('backdrop')->first();
    }

    /**
     * Attribute: Picture URL.
     *
     * @return string
     */
    public function getPictureURLAttribute()
    {
        return !empty($this->picture->url) ? "/{$this->picture->url}" : config('user.default_picture_path');
    }

    /**
     * Attribute: Backdrop URL.
     *
     * @return string
     */
    public function getBackdropURLAttribute()
    {
        return !empty($this->backdrop->url) ? "/{$this->backdrop->url}" : config('user.default_backdrop_path');
    }

    /**
     * Attribute: Route.
     *
     * @return string
     */
    public function getRouteAttribute()
    {
        return route('user.profile', ['username' => strtolower($this->user->username)]);
    }
}
