<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{

    protected $table = 'wechat';
    //
    public $fillable = [
        'code',
        'account',
        'phone',
        'qrcode',
        'sort'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales_data(){
        return $this->belongsToMany(SalesData::class);
    }


    public function wechat_to_channel(){
        return $this->hasMany(WechatToChannel::class,'id','channel_assgin_id');
    }
}
