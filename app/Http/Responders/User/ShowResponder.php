<?php


namespace App\Http\Responders\User;


use App\Http\Responders\BaseResponder;

class ShowResponder extends BaseResponder
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
            'status'      => $this->result->status,
            'email'       => $this->result->email,
            'wx_open_id'  => $this->result->wx_open_id,
            'wx_union_id' => $this->result->wx_union_id,
            'created_at'  => $this->formatDate($this->result->created_at)
        ];
    }
}
