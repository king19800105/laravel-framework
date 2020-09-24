<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $fillable = [
        'message', 'uid', 'channel', 'ip', 'breakpoint', 'api', 'params', 'request_at'
    ];

    protected $casts = [
        'created_at' => 'Y-m-d H:i:s',
        'updated_at' => 'Y-m-d H:i:s'
    ];

    public $timestamps = false;
}
