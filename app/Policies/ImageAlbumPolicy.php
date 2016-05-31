<?php namespace App\Policies;

use App\Models\ImageAlbum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImageAlbumPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can add a comment on the given image album.
     *
     * @param  User  $user
     * @param  ImageAlbum  $album
     * @return bool
     */
    public function addComment(User $user, ImageAlbum $album)
    {
        return $user->isActive;
    }

    /**
     * Determine if the given user can edit the given image album.
     *
     * @param  User  $user
     * @param  ImageAlbum  $album
     * @return bool
     */
    public function edit(User $user, ImageAlbum $album)
    {
        return $user->can('admin') || $user->id == $album->user->id;
    }

    /**
     * Determine if the given user can delete the given image album.
     *
     * @param  User  $user
     * @param  ImageAlbum  $album
     * @return bool
     */
    public function delete(User $user, ImageAlbum $album)
    {
        return $user->can('admin') || $user->id == $album->user->id;
    }
}
