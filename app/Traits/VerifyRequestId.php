<?php


namespace App\Traits;


trait VerifyRequestId
{
    abstract public function getIdName(): string;

    public function input($key = null, $default = null)
    {
        $routeId    = $this->getIdName();
        $data       = parent::input($key, $default);
        $data['id'] = $this->route($routeId);
        request()->merge(['{' . $routeId . '}' => $data['id']]);
        return $data;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer|min:1',
        ];
    }
}
