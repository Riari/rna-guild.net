<?php namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'activated',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship: profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Relationship: socialite auths
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auths()
    {
        return $this->hasMany(UserAuth::class);
    }

    /**
     * Relationship: roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Attribute: role list
     *
     * @return string
     */
    public function getRoleListAttribute()
    {
        return implode(', ', $this->roles()->lists('name')->toArray());
    }

    /**
     * Attribute: slugified name
     *
     * @return string
     */
    public function getSlugAttribute()
    {
        return str_slug($this->name, '-');
    }

    /**
     * Attribute: profile URL
     *
     * @return string
     */
    public function getProfileUrlAttribute()
    {
        return url("user/{$this->id}-{$this->slug}");
    }

    /**
     * Helper: determine if the user has a given role (or one of multiple given roles)
     *
     * @param  string|array  $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_array($role)) {
            foreach ($role as $r) {
                if ($this->hasRole($r)) return true;
            }

            return false;
        }

        foreach ($this->roles as $r) {
            if ($r->name == $role) return true;
        }

        return false;
    }

    /**
     * Helper: activate the user
     *
     * @return void
     */
    public function activate()
    {
        if ($this->activated) {
            return;
        }

        $this->activated = 1;
        $this->save();
    }

    /**
     * Helper: deactivate the user
     *
     * @return void
     */
    public function deactivate()
    {
        if (!$this->activated) {
            return;
        }

        $this->activated = 0;
        $this->save();
    }
}
