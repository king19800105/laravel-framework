<?php

namespace App\Http\Requests\User;


use App\Traits\VerifyRequestId;
use Illuminate\Foundation\Http\FormRequest;

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
        return true;
    }

    public function getIdName(): string
    {
        return 'id';
    }
}
