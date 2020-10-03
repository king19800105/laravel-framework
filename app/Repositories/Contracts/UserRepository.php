<?php

namespace App\Repositories\Contracts;



interface UserRepository
{
    public function findById($id);

    public function findList();

    public function create(array $data);

    public function update(array $data, $id, $roleIds = []);

    public function delete($id);

    public function findByMobile($mobile);
}
