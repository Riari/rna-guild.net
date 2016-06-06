<?php namespace App\Models;

use App\Models\Traits\HasOwner;
use App\Models\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class UserConfirmation extends Model
{
    use HasOwner, HasTimestamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'token',
    ];

    /**
     * (Overridden to disable updated_at)
     *
     * @return void
     */
    public function setUpdatedAtAttribute($value)
    {
    }

    /**
     * Scope: for token
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string  $token
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeForToken($query, $token)
    {
        return $query->where('token', $token);
    }

    /**
     * Helper: create a confirmation for the given user
     *
     * @param  User  $user
     * @return static
     */
    public static function createForUser(User $user)
    {
        do {
            $token = str_random(32);
        } while (static::forToken($token)->first() instanceof UserConfirmation);

        return static::create([
            'user_id' => $user->id,
            'token' => $token
        ]);
    }
}
