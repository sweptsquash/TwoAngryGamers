<?php

namespace App\Models;

use Database\Factories\EditorsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editors extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'editors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'role_id',
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
        'name'      => 'string',
        'role_id'   => 'integer',
    ];

    protected static function newFactory()
    {
        return EditorsFactory::new();
    }

    public function permissions()
    {
        $permissions = $this->hasOne(Roles::class, 'id', 'id');

        if (empty($permissions)) {
            return ['Can Download'];
        }

        return explode(',', $permissions->permissions);
    }
}