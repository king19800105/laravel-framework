<?php

namespace App\Repositories\Eloquent;



use App\Models\Role;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\RoleRepository;


class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    protected const CACHE_TAG = 'RoleRepositoryEloquent:tag';

    public function entity()
    {
        return Role::class;
    }

    public function create($data)
    {
        return $this
            ->model
            ->create($data);
    }

    public function update($data, $id)
    {
        return $this
            ->model
            ->find($id)
            ->update($data);
    }

    public function delete($id)
    {
        return $this
            ->model
            ->destroy($id);
    }

    public function findById($id)
    {
        return $this
            ->model
            ->find($id);
    }

    public function findList()
    {
        return $this
            ->model
            ->select('*')
            ->latest()
            ->paginate(static::PAGE_NUM);
    }
}

