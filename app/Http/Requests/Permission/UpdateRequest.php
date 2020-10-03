<?php


namespace App\Http\Requests\Permission;



use App\Models\Permission;
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
        Gate::authorize('create', Permission::class);
        return true;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'name'   => ['bail', 'required', 'between:2,30', 'unique:permissions,name,' . $this->permission],
        ]);
    }
}
