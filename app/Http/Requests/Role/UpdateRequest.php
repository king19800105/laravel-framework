<?php


namespace App\Http\Requests\Role;



use App\Models\Role;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends StoreRequest
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

    public function rules()
    {
        return array_merge(parent::rules(), [
            'name'   => ['bail', 'required', 'between:2,30', 'unique:roles,name,' . $this->role],
        ]);
    }
}
