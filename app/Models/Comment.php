<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'model_class', 'model_id', 'body'];

    /**
     * Relationship: author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    /**
     * Scope: on model
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  Model  $model
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeOnModel($query, Model $model)
    {
        return $query->where([
            'model_class'   => get_class($model),
            'model_id'      => $model->id
        ]);
    }

    /**
     * Helper: add a new comment with the given model and user
     *
     * @param  Model  $model
     * @param  User  $user
     * @param  string  $body
     * @return static
     */
    public static function add(Model $model, User $user, $body)
    {
        return static::create([
            'user_id'       => $user->id,
            'model_class'   => get_class($model),
            'model_id'      => $model->id,
            'body'          => $body
        ]);
    }
}
