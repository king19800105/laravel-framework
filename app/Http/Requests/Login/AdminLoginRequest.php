<?php

namespace App\Http\Requests\Login;

use App\Http\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'mobile'   => ['bail', 'required', new ValidMobile()],
            'password' => 'required|between:6,40'
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
            'mobile'   => __('message.user.mobile'),
            'password' => __('message.user.password'),
        ];
    }
}

