<?php namespace App\Models;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body'];
}
