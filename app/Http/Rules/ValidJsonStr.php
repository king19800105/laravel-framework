<?php


namespace App\Http\Rules;


use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ValidJsonStr implements Rule
{
    protected $inKeys;

    public function __construct($keys = [])
    {
        $this->inKeys = $keys;
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
        if (!is_array($value)) {
            return false;
        }

        if (empty($this->inKeys) && empty($value)) {
            return true;
        }

        $keys = array_keys($value);
        if (!empty($keys)) {
            foreach ($keys as $item) {
                if (!in_array($item, $this->inKeys)) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.custom.valid_json_str');
    }
}