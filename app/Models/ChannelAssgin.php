<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelAssgin extends Model
{
    //
    protected $table = 'channel_assgins';


    //
    protected $fillable =[
        'datetime',
        'wechat',
        'company',
        'details',
        'price',
        'type',
        'score',
        'mark'
    ];

    // 这是一个属性转换器
    protected $casts = [
        'wechat' => 'json',
        'datetime'  => 'date',
        'price' => 'decimal:2',
    ];

    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function wechat_to_channel(){
        return $this->hasMany(WechatToChannel::class,'id','channel_assgin_id');
    }
}
