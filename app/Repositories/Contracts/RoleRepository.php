<?php

namespace App\Repositories\Contracts;



interface RoleRepository
{
    public function findById($id);

    public function findList();

    public function create(array $data, $permissionIds);

    public function update(array $data, $id, $permissionIds);

    public function delete($id);

    public function assign($roleId, $permissionIds);

    public function findAll($guard = 'admin');
}
