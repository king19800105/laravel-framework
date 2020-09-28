<?php

namespace App\Traits;


use Illuminate\Support\Carbon;


trait FormatDate
{
    public function formatDate($date, $format = 'Y-m-d H:i:s')
    {
        if ($date instanceof Carbon) {
            return $date->format($format);
        }

        if (is_string($date)) {
            return $date;
        }

        if (is_int($date)) {
            return date('Y-m-d H:i:s', $date);
        }

        return '';
    }
}
