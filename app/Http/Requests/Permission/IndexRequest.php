<?php

namespace App\Http\Requests\Permission;


use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;


class IndexRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        Gate::authorize('viewAny', Permission::class);
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|between:2,30'
        ];
    }
}
