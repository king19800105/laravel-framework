<?php

namespace App\Models;


use Spatie\Permission\Models\Role as Model;


class Role extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'guard_name',
    ];

//    public function __construct()
//    {
//        // todo... 可以通过 $this->setAttribute('guard_name', 'api') 来改变guard
//        // todo... 该对象有user()方法，可以根据当前角色获取对应的用户信息，和上面结合使用
//        parent::__construct(['guard_name' => 'admin']);
//    }

}
