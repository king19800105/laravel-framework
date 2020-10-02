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
        $this->result->getCollection()->transform(function (Permission $permission) {
            return [
                'id'         => $permission->id,
                'name'       => $permission->name,
                'created_at' => $this->formatDate($permission->created_at),
            ];
        });

        return $this->result;
    }
}
