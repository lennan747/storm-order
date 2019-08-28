<?php

namespace App\Admin\Controllers;

use App\Models\Payment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PaymentsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '支付管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Payment);

        $grid->column('id', __('Id'));
        $grid->column('char', __('Char'));
        $grid->column('name', __('Name'));
        //$grid->column('created_at', __('Created at'));
        //$grid->column('updated_at', __('Updated at'));
        $grid->disablePagination();
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableFilter();

        $grid->actions(function ($actions){
            $actions->disableDelete();
            //$actions->disableEdit();
        });
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
        $show = new Show(Payment::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('char', __('Char'));
        $show->field('name', __('Name'));
        $show->field('created_at', __('Created at'));
        //$show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Payment);

        $form->text('char', __('Char'))->rules(['required']);
        $form->text('name', __('Name'))->rules(['required']);

        return $form;
    }
}
