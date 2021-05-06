<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editors extends Model
{
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

    public function permissions()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }

    public function hasPermission($permission = null)
    {
        if (! empty($permission)) {
            $permissions = $this->permissions()->first();

            return in_array($permission, explode(',', $permissions->permissions));
        }

        return false;
    }
}
