<?php


namespace App\Http\Responders\Role;


use App\Http\Responders\BaseResponder;
use App\Models\Permission;
use Illuminate\Support\Arr;

class ShowResponder extends BaseResponder
{

    /**
     * @inheritDoc
     */
    protected function transform()
    {
        return [
            'id'          => $this->result->id,
            'name'        => $this->result->name,
            'guard_name'  => $this->result->guard_name,
            'created_at'  => $this->formatDate($this->result->created_at),
            'permissions' => $this->result->permissions->isEmpty()
                ? []
                : $this->result->permissions->map(function ($item) {
                    return [
                        'id'   => $item->id,
                        'name' => $item->name,
                    ];
                })
        ];
    }
}
