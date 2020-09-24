<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidMobile implements Rule
{
    protected const REGEX = '/^1[3456789]{1}\d{9}$/';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return 1 === preg_match(static::REGEX, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.custom.valid_mobile');
    }
}
