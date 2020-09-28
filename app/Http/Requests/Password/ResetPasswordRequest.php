<?php


namespace App\Http\Requests\Password;


use Illuminate\Foundation\Http\FormRequest;


class ResetPasswordRequest extends FormRequest
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
            'old_password' => 'required|string|between:6,40',
            'password'     => 'required|string|between:6,40|confirmed',
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
            'password'     => __('message.user.password'),
            'old_password' => __('message.user.old_password'),
        ];
    }
}
