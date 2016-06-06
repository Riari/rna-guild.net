<?php namespace App\Models\Traits;

use Auth;

trait HasTimestamps
{
    /**
     * Display a 'created' datetimestamp in the current user's timezone.
     *
     * @return string
     */
    public function getCreatedAttribute()
    {
        return $this->created_at->setTimezone($this->getUserTimezone());
    }

    /**
     * Display a 'created' datetime in diffForHumans format.
     *
     * @return string
     */
    public function getCreatedAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Display a 'created' datetimestamp in the curent user's timezone.
     *
     * @return string
     */
    public function getUpdatedAttribute()
    {
        return $this->updated_at->setTimezone($this->getUserTimezone());
    }

    /**
     * Display an 'updated' time in diffForHumans format.
     *
     * @return string
     */
    public function getUpdatedAgoAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    /**
     * Get the current user's timezone.
     *
     * @return string
     */
    protected function getUserTimezone()
    {
        return Auth::check() ? Auth::user()->preference('timezone', 'UTC') : 'UTC';
    }
}
