<?php namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasTimestamps;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Image;
use TeamTeaTime\Filer\HasAttachments;

class ImageAlbum extends Model
{
    use HasAttachments, Commentable, HasOwner, HasTimestamps, Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'description'];

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'Image Album';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function ($album) {
            foreach ($album->attachments as $attachment) {
                $attachment->delete();
            }
            foreach ($album->comments as $comment) {
                $comment->delete();
            }
        });
    }

    /**
     * Attribute: has multiple images.
     *
     * @return boolean
     */
    public function getHasMultipleImagesAttribute()
    {
        return $this->attachments->count() > 1;
    }

    /**
     * Attribute: cover URL.
     *
     * @return string
     */
    public function getCoverUrlAttribute()
    {
        return route('imagecache', ['template' => 'large', 'filename' => $this->attachments->first()->item->getRelativePath()]);
    }

    /**
     * Attribute: URL.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('image-album.show', ['id' => $this->id, 'name' => str_slug($this->title)]);
    }
}
