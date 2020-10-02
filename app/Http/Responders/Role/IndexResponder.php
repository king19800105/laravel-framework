<?php


namespace App\Http\Responders\Role;


use App\Http\Responders\BaseResponder;
use App\Models\Role;

class IndexResponder extends BaseResponder
{

    /**
     * @inheritDoc
     */
    protected function transform()
    {
        return $this->result->map(function (Role $role) {
            return [
                'id'         => $role->id,
                'name'       => $role->name,
                'guard_name' => $role->guard_name,
                'created_at' => $this->formatDate($role->created_at),
            ];
        });
    }
}
