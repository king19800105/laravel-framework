<?php


namespace App\Http\Requests\Login;


use App\Http\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile'   => ['bail', 'required', new ValidMobile(), 'unique:users'],
            'name'     => 'required|string|between:2,30',
            'password' => 'required|string|between:6,40|confirmed',
            'email'    => 'required|email|max:50',
            'code'     => 'required|size:6'
        ];
    }

    /**
     * 字段名称
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'     => __('message.user.name'),
            'mobile'   => __('message.user.mobile'),
            'password' => __('message.user.password'),
            'code'     => __('message.user.code'),
        ];
    }
}
