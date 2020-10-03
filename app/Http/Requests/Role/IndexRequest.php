<?php

namespace App\Http\Requests\Role;


use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;


class IndexRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        Gate::authorize('viewAny', Role::class);
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|between:2,30'
        ];
    }
}
