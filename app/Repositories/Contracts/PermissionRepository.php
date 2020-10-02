<?php

namespace App\Repositories\Contracts;



interface PermissionRepository
{
    public function findById($id);

    public function findList();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);
}
