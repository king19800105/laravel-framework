<?php

namespace App\Repositories\Eloquent;


use App\Models\User;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Filters\UserIndexFilter;


class UserRepositoryEloquent extends BaseRepository implements UserRepository
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

    public function update($data, $id, $roleIds = [])
    {
        BaseRepository::transaction(function () use ($data, $id, $roleIds) {
            $this
                ->model
                ->find($id)
                ->syncRoles($roleIds)
                ->update($data);
        });

        return true;
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
            ->filter(request()->only(['mobile']), UserIndexFilter::class)
            ->select('*')
            ->latest()
            ->paginate(static::PAGE_NUM);
    }

    public function findByMobile($mobile)
    {
        return $this
            ->model
            ->select('*')
            ->where(['mobile' => $mobile])
            ->first();
    }
}

