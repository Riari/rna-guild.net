<?php namespace App\Policies;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can add a comment on the given user profile.
     *
     * @param  User  $user
     * @param  UserProfile  $profile
     * @return bool
     */
    public function addComment(User $user, UserProfile $profile)
    {
        return $user->isActive;
    }
}
