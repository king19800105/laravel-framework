<?php

return [
    'user'       => [
        'mobile'       => '手机号码',
        'password'     => '用户密码',
        'old_password' => '原始密码',
        'email'        => '邮箱地址',
        'code'         => '验证码',
        'role_ids'     => '用户角色列表'
    ],
    'admin'      => [
        'mobile'   => '管理员手机号码',
        'password' => '管理员密码',
        'name'     => '姓名',
        'status'   => '状态',
        'role_ids' => '管理员角色列表'
    ],
    'permission' => [
        'name' => '权限名称',
    ],
    'role'       => [
        'name'           => '角色名称',
        'permission_ids' => '权限列表'
    ],
    //end-field
];
