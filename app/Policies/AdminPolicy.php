<?php namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user has admin rights.
     *
     * @param  User  $user
     * @return bool
     */
    public function admin(User $user)
    {
        return $user->hasRole(['Guild Master', 'Officer', 'Webmaster']);
    }
}
