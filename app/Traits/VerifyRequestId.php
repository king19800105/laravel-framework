<?php


namespace App\Traits;


trait VerifyRequestId
{
    protected $idName = 'id';

    public function setIdName($name)
    {
        $this->idName = $name;
    }

    public function input($key = null, $default = null)
    {
        $data                = parent::input($key, $default);
        $data[$this->idName] = $this->route($this->idName);
        request()->merge(['{' . $this->idName . '}' => $data[$this->idName]]);
        return $data;
    }

    public function rules()
    {
        return [
            $this->idName => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        $reason = __('reason.illegal_id');
        return [
            'required' => $reason,
            'integer'  => $reason,
            'min'      => $reason
        ];
    }
}
