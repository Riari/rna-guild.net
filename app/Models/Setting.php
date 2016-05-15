<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];

    /**
     * Helper: get a setting value by key, optionally with a default
     *
     * @param  string  $key
     * @param  null|string  $default
     * @return string
     */
    public static function get($key, $default = null)
    {
        $setting = static::where(compact('key'))->first();
        return $setting instanceof static ? $setting->value : $default;
    }

    /**
     * Helper: store a given value with the given key
     *
     * @param  string  $key
     * @param  string  $value
     * @return bool
     */
    public static function set($key, $value)
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = $value;
        return $setting->save();
    }

    /**
     * Helper: delete a setting
     *
     * @param  string  $key
     * @return bool
     */
    public static function forget($key)
    {
        return self::where(compact('key'))->delete();
    }
}
