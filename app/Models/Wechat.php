<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    //
    public $fillable = [
        'code',
        'account',
        'phone',
        'qrcode',
        'sort'
    ];
}
