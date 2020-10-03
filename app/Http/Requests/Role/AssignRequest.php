<?php

namespace App\Http\Requests\Role;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AssignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        Gate::authorize('assign', Role::class);
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
            'id'               => 'required|integer|min:1',
            'permission_ids'   => 'array',
            'permission_ids.*' => 'bail|distinct|integer|min:1'
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
            'permission_ids' => __('message.role.permission_ids'),
        ];
    }

    public function messages()
    {
        $name = __('message.role.permission_ids');
        return [
            'permission_ids.*.*' => __('reason.illegal_params', ['name' => $name])
        ];
    }
}
