<?php


namespace App\Http\Requests\Admin;

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
        $this->setIdName('admin');
//        Gate::authorize('view', Admin::class);
        return true;
    }
}
