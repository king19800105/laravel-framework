<?php


namespace App\Http\Requests\Role;

use App\Traits\VerifyRequestId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ShowRequest extends FormRequest
{
    use VerifyRequestId;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setIdName('role');
//        Gate::authorize('view', Admin::class);
        return true;
    }
}
