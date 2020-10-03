<?php

namespace App\Http\Requests\Admin;

use App\Http\Rules\ValidMobile;
use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        Gate::authorize('create', Admin::class);
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
            'mobile'   => ['bail', 'required', new ValidMobile(), 'unique:admins'],
            'name'     => 'required|string|between:2,30',
            'password' => 'required|string|between:8,40|confirmed',
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
            'name'     => __('message.admin.name'),
            'mobile'   => __('message.admin.mobile'),
            'password' => __('message.admin.password'),
            'role_ids' => __('message.admin.role_ids')
        ];
    }
}
