<?php

return [
    'user'       => [
        'mobile'       => '手机号码',
        'password'     => '用户密码',
        'old_password' => '原始密码',
        'email'        => '邮箱地址',
        'code'         => '验证码'
    ],
    'admin'      => [
        'mobile'   => '管理员手机号码',
        'password' => '管理员密码',
        'name'     => '姓名',
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
