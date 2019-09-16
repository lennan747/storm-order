<?php

namespace App\Admin\Controllers;

use App\Models\SalesData;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('id', __('Id'));
        $grid->column('user.name', '下单员');
        $grid->column('sales_time', '销售日期');
        $grid->column('channel', '进线渠道');
        $grid->column('enter_number','进线人数');
        $grid->column('repay_number', '回复人数');
        $grid->column('delete_number', '删除人数');
        $grid->column('transaction_amount','交易金额');
        $grid->column('transaction_number', '交易订单数');
        $grid->column('delete_rate','删粉率')->display(function (){
            return number_format($this->delete_number/$this->enter_number,4)*100 .'%';
        });

        $grid->column('repay_rate','回复率')->display(function (){
            return number_format($this->repay_number/$this->enter_number,4)*100 .'%';
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

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('sales_time', __('Sales time'));
        $show->field('channel', __('Channel'));
        $show->field('enter_number', __('Enter number'));
        $show->field('repay_number', __('Repay number'));
        $show->field('delete_number', __('Delete number'));
        $show->field('transaction_amount', __('Transaction amount'));
        $show->field('transaction_number', __('Transaction number'));
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
