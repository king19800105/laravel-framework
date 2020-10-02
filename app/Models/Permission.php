<?php

namespace App\Models;


use Spatie\Permission\Models\Permission as Model;


class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'belong_to', 'uri', 'guard_name',
    ];
}
