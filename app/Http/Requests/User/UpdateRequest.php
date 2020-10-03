<?php


namespace App\Http\Requests\User;


use App\Http\Rules\ValidMobile;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        Gate::authorize('update', User::class);
        return true;
    }

    public function rules()
    {
        return [
            'mobile'   => ['bail', 'required', new ValidMobile(), 'unique:users,mobile,' . $this->user],
            'name'     => 'required|string|between:2,30',
            'role_ids' => 'array',
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
            'role_ids' => __('message.user.role_ids')
        ];
    }
}
