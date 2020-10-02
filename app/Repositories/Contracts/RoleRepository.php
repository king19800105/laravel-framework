<?php

namespace App\Repositories\Contracts;



interface RoleRepository
{
    public function findById($id);

    public function findList();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);
}
