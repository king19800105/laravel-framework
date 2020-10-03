<?php

namespace App\Http\Requests\Admin;


use App\Models\Admin;
use Illuminate\Support\Facades\Gate;
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
        Gate::authorize('view', Admin::class);
        return true;
    }

    public function rules()
    {
        return [];
    }
}
