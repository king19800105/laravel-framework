<?php


namespace App\Http\Requests\User;


use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ViewDocRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        Gate::authorize('viewDoc', User::class);
        return true;
    }

    public function rules()
    {
        return [];
    }
}
