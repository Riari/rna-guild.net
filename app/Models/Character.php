<?php namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\HasOwner;
use Illuminate\Database\Eloquent\Model;
use TeamTeaTime\Filer\HasAttachments;

class Character extends Model
{
    use HasAttachments, Commentable, HasOwner;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'class_id', 'name', 'age', 'occupation', 'description', 'main'];

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'Character';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function ($character) {
            foreach ($character->attachments as $attachment) {
                $attachment->delete();
            }
            foreach ($character->comments as $comment) {
                $comment->delete();
            }
        });
    }

    /**
     * Relationship: class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameClass()
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /**
     * Attribute: portrait.
     *
     * @return \TeamTeaTime\Filer\Attachment
     */
    public function getPortraitAttribute()
    {
        return $this->findAttachmentByKey('portrait');
    }

    /**
     * Attribute: portrait URL.
     *
     * @return string
     */
    public function getPortraitUrlAttribute()
    {
        return !is_null($this->portrait) ? $this->portrait->getUrl() : url('images/game/class/' . strtolower($this->gameClass->name) . '.jpg');
    }

    /**
     * Attribute: URL.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('character.show', ['character' => $this->id, 'name' => str_slug($this->name, '-')]);
    }
}
