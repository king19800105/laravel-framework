<?php


namespace App\Http\Requests\Permission;


use App\Traits\VerifyRequestId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DestroyRequest extends FormRequest
{
    use VerifyRequestId;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setIdName('permission');
//        Gate::authorize('delete', Admin::class);
        return true;
    }
}
