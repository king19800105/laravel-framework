<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperateLog extends Model
{
    protected $fillable = [
        'module', 'uid', 'exec', 'ip', 'api', 'params', 'operated_at'
    ];

    protected $casts = [
        'created_at' => 'Y-m-d H:i:s',
        'updated_at' => 'Y-m-d H:i:s'
    ];

    public $timestamps = false;
}
