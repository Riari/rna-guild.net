<?php namespace App\Models;

use App\Models\Traits\HasOwner;
use App\Models\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class UserAuth extends Model
{
    use HasOwner, HasTimestamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'provider', 'provider_user_id', 'provider_user_email', 'token'];

    /**
     * Scope: for provider
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string  $key
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeForProvider($query, $key)
    {
        return $query->where('provider', $key);
    }

    /**
     * Helper: create a new auth from the given user and socialite user
     *
     * @param  User  $user
     * @param  string  $provider
     * @param  SocialiteUser  $user
     * @return static
     */
    public static function createFromSocialite(User $user, $provider, SocialiteUser $socialiteUser)
    {
        return static::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_user_id' => $socialiteUser->id,
            'provider_user_email' => $socialiteUser->email,
            'token' => $socialiteUser->token
        ]);
    }
}
