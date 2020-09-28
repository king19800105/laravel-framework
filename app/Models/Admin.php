<?php

namespace App\Models;


use EloquentFilter\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Admin
 * @package App\Models
 */
class Admin extends Authenticatable implements JWTSubject
{
    use Filterable, HasRoles, SoftDeletes;

    /**
     * @var string
     */
    protected $guard_name = 'admin';

    protected $deleted_at;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'mobile', 'last_logged_ip', 'ic_card', 'deleted_at', 'logged_at', 'wx_union_id', 'wx_open_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return ['role' => 'admin'];
    }
}
