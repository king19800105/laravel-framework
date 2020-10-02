<?php

namespace App\Repositories\Contracts;



interface AdminRepository
{
    public function findById($id);

    public function findList();

    public function create(array $data, $roleIds = []);

    public function update(array $data, $id, $roleIds = []);

    public function delete($id);
}
