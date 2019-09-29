<?php

namespace App\Admin\Controllers;

use App\Models\Channel;
use App\Models\Wechat;
use App\Models\WechatToChannel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;

class PlansController extends AdminController
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
        // 时间选择
        $datetime_start = request()->datetime_start ? request()->datetime_start: '1970-00-00';
        $datetime_end = request()->datetime_end ? request()->datetime_end : '2049-09-28';
        // 获取所有微信号
        $wechats = Wechat::query()->orderBy('id', 'asc')->get();
        // 渠道与微信关系
        $plans = WechatToChannel::query()
            ->where('datetime','>=',$datetime_start)
            ->where('datetime','<=',$datetime_end)
            ->orderBy('datetime', 'desc')
            ->orderBy('wechat_id', 'asc')
            ->get()
            ->groupBy('datetime');
        // 获取所有渠道公司
        $channels = Channel::query()->pluck('name', 'id');

        return view('admin.plans.index2', ['wechats' => $wechats, 'plans' => $plans, 'channels' => $channels]);
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
//        $show = new Show(Plan::findOrFail($id));
//
//        $show->field('id', __('Id'));
//        $show->field('wechat_id', __('Wechat id'));
//        $show->field('channel_id', __('Channel id'));
//        $show->field('datetime', __('Datetime'));
//
//        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WechatToChannel);
        $form->date('datetime', '日期')->default(date('Y-m-d'));
        return $form;
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws \Exception
     */
    public function store()
    {
        if(request()->plan_datetime == ''){
            $error = new MessageBag([
                'title' => '添加计划',
                'message' => '请输入时间',
            ]);
            return back()->with(compact('error'));
        }
        if (WechatToChannel::query()->where('datetime', request()->plan_datetime)->exists()) {
            $error = new MessageBag([
                'title' => '添加计划',
                'message' => request()->plan_datetime . '计划已存在',
            ]);
            return back()->with(compact('error'));
        }

        $wechat_ids = Wechat::query()->pluck('id');
        $data = [];

        foreach ($wechat_ids as $k => $v) {
            $data[$k] = [
                'wechat_id' => $v,
                'datetime' => request()->plan_datetime,
            ];
        }

        WechatToChannel::insert($data);
        return back()->with(compact('success'));
    }

    // 添加嘉华
    public function add_plans(){

        if(!request()->datetime){
            $error = new MessageBag([
                'title' => '计划错误',
                'message' => '请选择计划时间',
            ]);
            return back()->with(compact('error'));
        }

        if(!request()->channels){
            $error = new MessageBag([
                'title' => '计划错误',
                'message' => '请选择计划渠道',
            ]);
            return back()->with(compact('error'));
        }

        if(!request()->wechats){
            $error = new MessageBag([
                'title' => '计划错误',
                'message' => '请选择计划微信',
            ]);
            return back()->with(compact('error'));
        }

        // 当前日期不存在,创建当日计划
        if (!WechatToChannel::query()->where('datetime', request()->datetime)->exists()) {
            $wechat_ids = Wechat::query()->pluck('id');
            $data = [];
            foreach ($wechat_ids as $k => $v) {
                $data[$k] = [
                    'wechat_id' => $v,
                    'datetime' => request()->datetime,
                ];
            }
            WechatToChannel::insert($data);
        }
        // 批量更新渠道
        $id = \DB::update(\DB::raw("UPDATE wechat_to_channels SET "
                ."channel_id = ". request()->channels." ,"
                ." mark = '". request()->mark
                ."' WHERE wechat_id in (".request()->wechats.")".
                " AND datetime = '".request()->datetime)."'");
        if($id){
            return back()->with(compact('success'));
        }
        return back()->with(compact('error'));
    }


    public function clear()
    {
        WechatToChannel::query()->where('id', request()->id)->update([
            'channel_id' => null,
            'mark' => null
        ]);
        $success = new MessageBag([
            'title' => '清除计划',
            'message' => '清除计划 成功',
        ]);
        return response()->json(true);
    }
}
