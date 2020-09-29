<?php


namespace App\Http\Responders\User;


use App\Http\Responders\BaseResponder;
use App\Models\User;

class IndexResponder extends BaseResponder
{

    /**
     * @inheritDoc
     */
    protected function transform()
    {
        $this->result->getCollection()->transform(function (User $user) {
            return [
                'id'         => $user->id,
                'name'       => $user->name,
                'mobile'     => $user->mobile,
                'email'      => $user->email,
                'status'     => $user->status,
                'created_at' => $this->formatDate($user->created_at),
            ];
        });

        return $this->result;
    }
}
