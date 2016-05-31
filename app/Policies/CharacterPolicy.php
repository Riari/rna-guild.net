<?php namespace App\Policies;

use App\Models\User;
use App\Models\Character;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can add a comment on the given character.
     *
     * @param  User  $user
     * @param  Character  $character
     * @return bool
     */
    public function addComment(User $user, Character $character)
    {
        return $user->isActive;
    }

    /**
     * Determine if the given user can edit the given character.
     *
     * @param  User  $user
     * @param  Character  $character
     * @return bool
     */
    public function edit(User $user, Character $character)
    {
        return $user->can('admin') || $user->id == $character->user->id;
    }

    /**
     * Determine if the given user can delete the given image album.
     *
     * @param  User  $user
     * @param  Character  $character
     * @return bool
     */
    public function delete(User $user, Character $character)
    {
        return $user->can('admin') || $user->id == $character->user->id;
    }
}
