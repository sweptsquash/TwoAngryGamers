<?php

namespace App\Models;

use Database\Factories\VideosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'author',
        'filename',
        'created',
        'thumbnail',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'title'     => 'string',
        'author'    => 'string',
        'filename'  => 'string',
        'created'   => 'datetime',
        'thumbnail' => 'string',
    ];

    protected static function newFactory()
    {
        return VideosFactory::new();
    }
}