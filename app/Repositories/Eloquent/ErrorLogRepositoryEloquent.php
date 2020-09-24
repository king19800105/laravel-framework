<?php

namespace App\Repositories\Eloquent;


use App\Models\ErrorLog;
use App\Repositories\Contracts\ErrorLogRepository;
use App\Repositories\Contracts\BaseRepository;


class ErrorLogRepositoryEloquent extends BaseRepository implements ErrorLogRepository
{
    protected const CACHE_TAG = 'ErrorLogRepositoryEloquent:tag';

    public function entity()
    {
        return ErrorLog::class;
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

