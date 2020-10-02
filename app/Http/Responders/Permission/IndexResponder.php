<?php


namespace App\Http\Responders\Permission;


use App\Http\Responders\BaseResponder;
use App\Models\Permission;

class IndexResponder extends BaseResponder
{

    /**
     * @inheritDoc
     */
    protected function transform()
    {
        return $this->result->map(function (Permission $permission) {
            return [
                'id'         => $permission->id,
                'name'       => $permission->name,
                'updated_at' => $this->formatDate($permission->updated_at),
                'created_at' => $this->formatDate($permission->created_at),
            ];
        });
    }
}
