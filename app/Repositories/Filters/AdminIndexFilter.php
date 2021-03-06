<?php

namespace App\Repositories\Filters;

use EloquentFilter\ModelFilter;

class AdminIndexFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    protected $drop_id = false;

    public function name($val)
    {
        return $this->where('name', 'like', $val . '%');
    }
}
