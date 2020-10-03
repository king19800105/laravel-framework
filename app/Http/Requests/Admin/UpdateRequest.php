<?php


namespace App\Http\Requests\Admin;


use App\Http\Rules\ValidMobile;
use App\Models\Admin;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends StoreRequest
{
    public function authorize()
    {
        Gate::authorize('update', Admin::class);
        return true;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'mobile'   => ['bail', 'required', new ValidMobile(), 'unique:admins,mobile,' . $this->admin],
            'password' => 'string|between:8,40',
        ]);
    }
}
