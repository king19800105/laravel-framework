<?php

namespace App\Repositories\Eloquent;



use App\Models\Permission;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\PermissionRepository;


class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    protected const CACHE_TAG = 'PermissionRepositoryEloquent:tag';

    public function entity()
    {
        return Permission::class;
    }

    public function create($data)
    {
        return $this->cleanByTag(self::CACHE_TAG, function () use ($data) {
            return $this
                ->model
                ->create($data);
        });
    }

    public function update($data, $id)
    {
        return $this->cleanByTag(self::CACHE_TAG, function () use ($data, $id) {
            return $this
                ->model
                ->find($id)
                ->update($data);
        });
    }

    public function delete($id)
    {
        return $this->cleanByTag(self::CACHE_TAG, function () use ($id) {
            return $this
                ->model
                ->destroy($id);
        });
    }

    public function findById($id)
    {
        return $this
            ->model
            ->find($id);
    }

    public function findList()
    {
        return $this->getOrCache('permission:find:list', function () {
            return $this
                ->model
                ->select('*')
                ->latest()
                ->get();
        }, self::CACHE_TAG, 300);

    }
}

