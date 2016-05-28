<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterClass extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'character_classes';

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'Character Class';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
        });
    }

    /**
     * Attribute: icon URL.
     *
     * @return string
     */
    public function getIconUrlAttribute()
    {
        return url('images/game/class/icon_' . strtolower($this->name) . '.png');
    }
}
