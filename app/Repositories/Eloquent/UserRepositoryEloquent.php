<?php

namespace App\Repositories\Eloquent;


use App\Models\User;
use App\Repositories\Contracts\AdminRepository;
use App\Repositories\Contracts\BaseRepository;


class UserRepositoryEloquent extends BaseRepository implements AdminRepository
{
    protected const CACHE_TAG = 'UserRepositoryEloquent:tag';

    public function entity()
    {
        return User::class;
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

