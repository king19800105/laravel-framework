<?php

namespace App\Http\Requests\Role;


use App\Models\Role;
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
        Gate::authorize('create', Role::class);
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
            'name'       => 'required|string|between:2,30|unique:roles',
            'guard_name' => 'in:api,admin'
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
            'name' => __('message.role.name'),
        ];
    }
}
