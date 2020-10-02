<?php

namespace App\Repositories\Eloquent;


use App\Models\Admin;
use App\Repositories\Contracts\AdminRepository;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Filters\AdminIndexFilter;


class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
{
    protected const CACHE_TAG = 'AdminRepositoryEloquent:tag';

    public function entity()
    {
        return Admin::class;
    }

    public function create($data, $roleIds = [])
    {
        if (empty($roleIds)) {
            return $this->model->create($data);
        }

        BaseRepository::transaction();
        $admin = $this->model->create($data)->syncRoles($roleIds);
        if ($admin) {
            BaseRepository::commit();
            return $admin;
        }

        BaseRepository::rollBack();
        return null;
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
        BaseRepository::transaction(function () use ($id) {
            $this
                ->model
                ->find($id)
                ->syncRoles([])
                ->delete();
        });

        return true;
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
            ->filter(request()->only(['name']), AdminIndexFilter::class)
            ->select('*')
            ->latest()
            ->paginate(static::PAGE_NUM);
    }
}

