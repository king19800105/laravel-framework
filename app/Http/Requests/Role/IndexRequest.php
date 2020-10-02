<?php

namespace App\Http\Requests\Role;


use Illuminate\Foundation\Http\FormRequest;


class IndexRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        Gate::authorize('view', Admin::class);
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|between:2,30'
        ];
    }
}
