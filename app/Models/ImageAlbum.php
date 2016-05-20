<?php namespace App\Models;

use App\Models\Traits\HasOwner;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Image;
use Slynova\Commentable\Traits\Commentable;
use TeamTeaTime\Filer\HasAttachments;

class ImageAlbum extends Model
{
    use Commentable, HasAttachments, HasOwner, Taggable;

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
        return route('image-album.show', ['id' => $this->user->id, 'name' => str_slug($this->user->name)]);
    }
}
