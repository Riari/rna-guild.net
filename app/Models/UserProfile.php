<?php namespace App\Models;

use Cache;
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
     * Attribute: avatar.
     *
     * @return \TeamTeaTime\Filer\Attachment
     */
    public function getAvatarAttribute()
    {
        return Cache::remember("user_{$this->user->id}_avatar", 5, function () {
            return $this->attachments()->key('avatar')->first();
        });
    }

    /**
     * Attribute: avatar URL.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return (is_null($this->avatar))
            ? config('user.default_avatar_path')
            : $this->avatar->getUrl();
    }

    /**
     * Attribute: URL.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('user.profile', ['id' => $this->user->id, 'name' => str_slug($this->user->name)]);
    }
}
