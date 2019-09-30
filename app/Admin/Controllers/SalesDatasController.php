<?php

namespace App\Admin\Controllers;

use App\Models\Channel;
use App\Models\SalesData;
use App\Models\WechatToChannel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class SalesDatasController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '销售数据';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SalesData);
        $grid->model()->orderby('sales_time','desc');
        //$grid->column('id', __('Id'));
        $grid->column('wechat.code', '微信编号')->sortable();
        //$grid->column('wechat.sort', '排序')->sortable();
        $grid->column('user.name', '下单员')->sortable();
        $grid->column('wechat.account', '进线微信号');
        $grid->column('sales_time', '进线日期')->sortable();
        $grid->column('channels', '进线渠道')->display(function (){
            if($this->sales_time && $this->wechat_id){
                $channel_id = \DB::table('wechat_to_channels')->where([
                    ['datetime', '=', $this->sales_time],
                    ['wechat_id', '=', $this->wechat_id],
                ])->value('channel_id');

                 return \DB::table('channels')->where('id',$channel_id)->value('name');
                //return $channel_id;
            }
            return '';
        });
        $grid->column('enter_number','进线人数');
        $grid->column('repay_number', '回复人数');
        $grid->column('delete_number', '删除人数');
        $grid->column('transaction_amount','交易金额');
        $grid->column('transaction_number', '交易订单数');
        $grid->column('delete_rate','删粉率')->display(function (){
            return $this->enter_number == 0 ? 0 : number_format($this->delete_number/$this->enter_number,4)*100 .'%';
        });

        $grid->column('repay_rate','回复率')->display(function (){
            return $this->enter_number == 0 ? 0 : number_format($this->repay_number/$this->enter_number,4)*100 .'%';
        });
        //$grid->column('created_at', );
        $grid->column('updated_at','上次更新时间');

        $grid->filter(function ($filter){
            $filter->disableIdFilter();
            $filter->like('sales_time', '销售日期');
            $filter->like('user.name', '下单员');
        });
        $grid->disableCreateButton();
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
        $show = new Show(SalesData::findOrFail($id));

        //$show->field('id', __('Id'));
        $show->field('user_id', '下单员');
        $show->field('sales_time','销售日期');
        $show->field('channel', '进线渠道');
        $show->field('enter_number', '进线人数');
        $show->field('repay_number', '回复人数');
        $show->field('delete_number', '删除人数');
        $show->field('transaction_amount', '交易金额');
        $show->field('transaction_number', '交易订单数');
        $show->field('mark', '日志')->unescape()->as(function ($mark){
            $html = "";
            if(is_null($mark)){
                return $html;
            }
            foreach ($mark as $value){
                $html2 = $value['updated_at'].':';
                $html2 = $html2."进线渠道:".$value['channel']
                    .",进线人数:".$value['enter_number']
                    .",回复人数:".$value['repay_number']
                    .',删粉数:'.$value['delete_number']
                    .',交易金额:'.$value['transaction_amount']
                    .',交易单数:'.$value['transaction_number']
                    .',删粉率'.(number_format($value['delete_number']/$value['enter_number'],4)*100).'%'
                    .',回复率'.(number_format($value['delete_number']/$value['enter_number'],4)*100).'%';
                //updated_at

                $html = $html.'</br>'.$html2;
            }

            return $html;
        });
//        $show->field('created_at', __('Created at'));
//        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SalesData);

        $form->number('user_id', __('User id'));
        $form->date('sales_time', __('Sales time'))->default(date('Y-m-d'));
        $form->text('channel', __('Channel'));
        $form->number('enter_number', __('Enter number'));
        $form->number('repay_number', __('Repay number'));
        $form->number('delete_number', __('Delete number'));
        $form->decimal('transaction_amount', __('Transaction amount'));
        $form->number('transaction_number', __('Transaction number'));

        return $form;
    }
}
