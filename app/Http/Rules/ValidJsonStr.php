<?php


namespace App\Http\Rules;


use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ValidJsonStr implements Rule
{
    public const MUST_ALL = true;

    protected $inKeys;

    protected $must;

    public function __construct($keys = [], $must = null)
    {
        $this->inKeys = $keys;
        $this->must = $must;
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
        if (!empty($this->must)) {
            if (!$this->validateMustFields($keys)) {
                return false;
            }
        }

        foreach ($keys as $item) {
            if (!in_array($item, $this->inKeys)) {
                return false;
            }
        }

        return true;
    }

    protected function validateMustFields($keys)
    {
        $diff = array_diff($this->inKeys, $keys);
        if ($this->must === self::MUST_ALL) {
            return empty($diff);
        }

        if (is_array($this->must)) {
            foreach ($this->must as $key => $item) {
                if (in_array($item, $diff)) {
                    return false;
                }
            }
        }

        return true;
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
