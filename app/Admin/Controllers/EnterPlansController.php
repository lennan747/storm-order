<?php

namespace App\Admin\Controllers;

use App\Models\Channel;
use App\Models\Wechat;
use App\Models\WechatToChannel;
use Encore\Admin\Controllers\AdminController;;
use Encore\Admin\Grid;

class EnterPlansController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '进线计划';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        // 获取所有微信号
        $wechats = Wechat::query()->orderBy('id','desc')->get();
        // 渠道与微信关系
        $wechats_to_channels = WechatToChannel::query()->orderBy('wechat_id','desc')->get()->groupBy('datetime');
        // 获取所有渠道公司
        //$channels = Channel::query()->groupBy('name','desc')
        return view('admin.plans.index',['wechats' => $wechats,'wechats_to_channels' => $wechats_to_channels]);
    }


    public function update($id)
    {
        dd(request()->all());
        if(isset(request()->check_channel) && !is_null(request()->check_channel) && Channel::query()->when('id',request()->check_channel)->exists()){
            $channel = new Channel([
                'name' => request()->check_channel
            ]);
            if($channel->save()){
                dd($channel->id);
            };
        }
        dd(request()->all());
        // 保存到管理表
    }
}
