<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterPlan extends Model
{
    //
    protected $fillable = [
        'enter_time',
        'a1',
        'a2',
        'a3',
        'a4',
        'a5',
        'a6',
        'a7',
        'a8',
        'a9',
        'a10',
        'a11',
        'a12',
        'a13',
        'a14',
        'a15',
        'a16',
        'a17',
        'a18',
        'a19',
        'a20',
        'a21',
        'a22',
        'a23',
        'a24',
        'a25',
        'a27',
        'a28',
        'a29',
        'a30'
    ];

    protected $casts = [
        'enter_time'  => 'date',
    ];
}
