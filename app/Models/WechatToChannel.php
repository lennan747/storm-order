<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatToChannel extends Model
{
    protected $table = 'wechat_to_channels';

    protected $fillable =[
        'wechat_id',
        'channel_id',
        //'plan_id',
        'datetime',
        'mark'
    ];

    public $timestamps = false;

    public function channel(){
        return $this->belongsTo(ChannelAssgin::class);
    }
}
