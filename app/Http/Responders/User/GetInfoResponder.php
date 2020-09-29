<?php


namespace App\Http\Responders\User;


use App\Http\Responders\BaseResponder;

class GetInfoResponder extends BaseResponder
{

    /**
     * @inheritDoc
     */
    protected function transform()
    {
        return [
            'id'          => $this->result->id,
            'mobile'      => $this->result->mobile,
            'name'        => $this->result->name,
            'email'       => $this->result->email,
        ];
    }
}
