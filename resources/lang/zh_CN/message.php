<?php

return [
    'user'       => [
        'mobile'                => '手机号码',
        'password'              => '用户密码',
        'password_confirmation' => '确认密码',
    ],
    'admin'      => [
        'mobile'   => '管理员手机号码',
        'password' => '管理员密码',
        'remark'   => '备注信息',
        'name'     => '姓名',
        'email'    => '邮箱地址',
        'status'   => '状态',
    ],
    'permission' => [
        'name'      => '权限名称',
        'belong_to' => '所属分组',
        'uri'       => '路由地址',
        'ids'       => '权限列表'
    ],
    'role'       => [
        'name'     => '角色名称',
        'ids'      => '角色列表',
        'auth_ids' => '权限列表'
    ],
    //end-field
];
