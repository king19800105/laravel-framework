<?php

namespace App\Http\Requests\User;


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
//        Gate::authorize('view', User::class);
        return true;
    }

    public function rules()
    {
        return [];
    }
}
