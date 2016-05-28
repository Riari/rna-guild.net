<?php namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeneralPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user is allowed to create image albums.
     *
     * @param  User  $user
     * @return bool
     */
    public function createImageAlbums(User $user)
    {
        return !$user->isNew;
    }

    /**
     * Determine if the given user is allowed to create characters.
     *
     * @param  User  $user
     * @return bool
     */
    public function createCharacters(User $user)
    {
        return !$user->isNew;
    }

    /**
     * Determine if the given user is allowed to view characters.
     *
     * @param  User  $user
     * @return bool
     */
    public function viewCharacters(User $user)
    {
        return !$user->isNew;
    }
}
