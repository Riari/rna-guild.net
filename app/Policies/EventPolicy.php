<?php namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can add a comment on the given event.
     *
     * @param  User  $user
     * @param  Event  $event
     * @return bool
     */
    public function addComment(User $user, Event $event)
    {
        return $user->isActive;
    }

    /**
     * Determine if the given user can view the given event.
     *
     * @param  User  $user
     * @param  Event  $event
     * @return bool
     */
    public function view(User $user, Event $event)
    {
        return $user->isActive;
    }
}
