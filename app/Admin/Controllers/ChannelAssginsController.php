<?php

namespace App\Admin\Controllers;

use App\Models\Channel;
use App\Models\ChannelAssgin;
use App\Models\Wechat;
use App\Models\WechatToChannel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ChannelAssginsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '派单管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ChannelAssgin);

        //$grid->column('id', __('Id'));
        $grid->column('channel.code', __('渠道编号'));
        $grid->column('channel.name', __('渠道公司名称'));
        $grid->column('datetime', __('派单时间'));
        $grid->column('wechat', __('微信号'))->display(function ($wechat){
            //$this->wechat
            $html = "";
            foreach ($wechat as $value){
                $account = Wechat::query()->where('id',$value)->value('account');
                $html .= "<span class='label label-warning margin-r-5'>{$account}</span>";
            }
            return $html;
        });
        $grid->column('company', __('指派人'));
        $grid->column('details', __('派单详情'));
        $grid->column('price', __('万粉单价'));
        $grid->column('type', __('粉丝类型'));
        $grid->column('score', __('渠道评分'));
        $grid->column('mark', __('备注'));
//        $grid->column('created_at', __('Created at'));
//        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ChannelAssgin::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('channel_id', __('Channel id'));
        $show->field('wechat', __('Wechat'));
        $show->field('company', __('Company'));
        $show->field('details', __('Details'));
        $show->field('price', __('Price'));
        $show->field('type', __('Type'));
        $show->field('score', __('Score'));
        $show->field('mark', __('Mark'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ChannelAssgin);

        //$form->number('channel_id', __('Channel id'));
        $form->select('channel_id','渠道号')->options(Channel::all()->pluck('code','id')->toArray());
        $form->date('datetime','派单时间')->default(date('Y-m-d'));
        //$form->text('wechat', __('Wechat'));
        $form->multipleSelect('wechat','微信号')->options(Wechat::all()->pluck('account', 'id')->toArray());
        $form->text('company', __('派单人'));
        $form->text('details', __('派单详情'));
        $form->decimal('price', __('万粉单价'));
        $form->text('type', __('粉丝类型'));
        $form->number('score', __('渠道评分'));
        $form->textarea('mark', __('备注'));

        //保存后回调
        $form->saved(function (Form $form) {
            foreach ($form->wechat as $value){
                if($value != null && !WechatToChannel::query()->where('channel_assgin_id',$form->model()->id)->exists()){
                    $data = new WechatToChannel([
                        'wechat_id'         => $value,
                        'channel_id'        => $form->channel_id,
                        'channel_assgin_id' => $form->model()->id,
                        'datetime'          => $form->datetime
                    ]);
                    $data->save();
                }
            }
        });

        return $form;
    }
}
