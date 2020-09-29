<?php

namespace App\Repositories\Filters;

use EloquentFilter\ModelFilter;

class UserIndexFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    protected $drop_id = false;

    public function mobile($val)
    {
        return $this->where('mobile', $val);
    }
}
