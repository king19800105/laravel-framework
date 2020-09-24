<?php

namespace App\Repositories\Eloquent;


use App\Models\OperateLog;
use App\Repositories\Contracts\OperateLogRepository;
use App\Repositories\Contracts\BaseRepository;


class OperateLogRepositoryEloquent extends BaseRepository implements OperateLogRepository
{
    protected const CACHE_TAG = 'OperateLogRepositoryEloquent:tag';

    public function entity()
    {
        return OperateLog::class;
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
        return $this->model->find($id);
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

