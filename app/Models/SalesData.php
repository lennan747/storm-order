<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesData extends Model
{

    protected $table = 'sales_datas';
    //
    protected $fillable = [
        'channel',
        'enter_number',
        'repay_number',
        'delete_number',
        'transaction_amount',
        'sales_time',
        'transaction_number',
        'mark',
        'wechat_id'
    ];

    protected $casts = [
        'transaction_amount' => 'decimal:2',
        'mark'               => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wechat(){
        return $this->belongsTo(Wechat::class);
    }
}
