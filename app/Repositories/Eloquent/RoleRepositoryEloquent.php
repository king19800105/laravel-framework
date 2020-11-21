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

    public function create($data, $permissionIds)
    {
        return $this
            ->model
            ->create($data)
            ->syncPermissions($permissionIds);

    }

    public function update($data, $id, $permissionIds)
    {
        $model = $this->model->find($id);
        if (!$model) {
            return false;
        }

        self::transaction(function () use ($model, $data, $id, $permissionIds) {
            $model->update($data);
            $model->syncPermissions($permissionIds);
        });

        return true;
    }

    public function delete($id)
    {
        BaseRepository::transaction(function () use ($id) {
            $this->model->find($id)->syncPermissions([]);
            $this->model->destroy($id);
        });

        return true;
    }

    public function findById($id)
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->load('permissions');
        }

        return $model;
    }

    public function findList()
    {
        return $this
            ->model
            ->select('*')
            ->latest()
            ->paginate(self::PAGE_NUM);
    }

    public function assign($roleId, $permissionIds)
    {
        return $this
            ->model
            ->find($roleId)
            ->syncPermissions($permissionIds);
    }

    public function findAll($guard = 'admin')
    {
        return $this
            ->model
            ->select('*')
            ->where('guard_name', $guard)
            ->latest()
            ->get();
    }
}

