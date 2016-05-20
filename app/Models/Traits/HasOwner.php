<?php namespace App\Models\Traits;

use App\Models\User;

trait HasOwner
{
    /**
     * Relationship: user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: by user
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  User  $user
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}
