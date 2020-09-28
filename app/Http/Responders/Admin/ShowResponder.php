<?php


namespace App\Http\Responders\Admin;


use App\Http\Responders\BaseResponder;

class ShowResponder extends BaseResponder
{

    /**
     * @inheritDoc
     */
    protected function transform()
    {
        return [
            'id'         => $this->result->id,
            'mobile'     => $this->result->mobile,
            'name'       => $this->result->name,
            'created_at' => $this->formatDate($this->result->created_at)
        ];
    }
}
