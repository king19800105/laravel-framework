<?php


namespace App\Http\Rules;


use Illuminate\Contracts\Validation\Rule;

class ValidBetweenDate implements Rule
{
    protected $limit;

    protected $flag;

    public function __construct($day, $flag = '~')
    {
        $this->limit = $day;
        $this->flag  = $flag;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $result = explode($this->flag, $value);
        if (2 !== count($result)) {
            return false;
        }

        $start = strtotime($result[0]);
        $end = strtotime($result[1]);
        if (!$start || !$end) {
            return false;
        }

        if ($start > $end) {
            return false;
        }

        return (($end - $start) / 86400) <= $this->limit;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return __('validation.custom.valid_between_date', ['max' => $this->limit]);
    }
}
