<?php


namespace App\Http\Requests\Password;


use App\Http\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
            'mobile'   => ['bail', 'required', new ValidMobile()],
            'password' => 'required|between:6,40|confirmed',
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
            'code'     => __('message.user.code'),
            'mobile'   => __('message.user.mobile'),
            'password' => __('message.user.password')
        ];
    }
}
