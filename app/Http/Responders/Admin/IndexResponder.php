<?php


namespace App\Http\Responders\Admin;


use App\Http\Responders\BaseResponder;
use App\Models\Admin;

class IndexResponder extends BaseResponder
{

    /**
     * @inheritDoc
     */
    protected function transform()
    {
        $this->result->getCollection()->transform(function (Admin $admin) {
            return [
                'id'         => $admin->id,
                'name'       => $admin->name,
                'mobile'     => $admin->mobile,
                'created_at' => $this->formatDate($admin->created_at),
            ];
        });

        return $this->result;
    }
}
