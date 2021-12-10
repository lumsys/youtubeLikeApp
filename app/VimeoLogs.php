<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VimeoLogs extends Model
{
    protected $fillable = [
        'user_id', 'video_id'
    ];
}
