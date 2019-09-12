<?php

namespace App\Admin\Controllers;

use App\Models\EnterPlan;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EnterPlansController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\EnterPlan';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EnterPlan);

        $grid->column('id', __('Id'));
        $grid->column('enter_time', '进线时间')->display(function (){
            return $this->id == 1 ? '微信号': $this->enter_time->format('Y-m-d');
        });
        $grid->column('a1', __('1'))->editable();
        $grid->column('a2', __('1A'))->editable();
        $grid->column('a3', __('2'))->editable();
        $grid->column('a4', __('2A'))->editable();
        $grid->column('a5', __('3'))->editable();
        $grid->column('a6', __('5'))->editable();
        $grid->column('a7', __('10'))->editable();
        $grid->column('a8', __('11'))->editable();
        $grid->column('a9', __('11A'))->editable();
        $grid->column('a10', __('10'))->editable();
        $grid->column('a11', __('12'))->editable();
        $grid->column('a12', __('13'))->editable();
        $grid->column('a13', __('15'))->editable();
        $grid->column('a14', __('16'))->editable();
        $grid->column('a15', __('16A'))->editable();
        $grid->column('a16', __('17'))->editable();
        $grid->column('a17', __('18'))->editable();
        $grid->column('a18', __('19'))->editable();
//        $grid->column('a19', __('19'))->editable();
//        $grid->column('a20', __('20'))->editable();
//        $grid->column('a21', __('21'))->editable();
//        $grid->column('a22', __('22'))->editable();
//        $grid->column('a23', __('23'))->editable();
//        $grid->column('a24', __('24'))->editable();
//        $grid->column('a25', __('25'))->editable();
//        $grid->column('a26', __('A26'))->editable();
//        $grid->column('a27', __('A27'))->editable();
//        $grid->column('a28', __('A28'))->editable();
//        $grid->column('a29', __('A29'))->editable();
//        $grid->column('a30', __('A30'))->editable();
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
        $show = new Show(EnterPlan::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('enter_time', __('Enter time'));
        $show->field('a1', __('A1'));
        $show->field('a2', __('A2'));
        $show->field('a3', __('A3'));
        $show->field('a4', __('A4'));
        $show->field('a5', __('A5'));
        $show->field('a6', __('A6'));
        $show->field('a7', __('A7'));
        $show->field('a8', __('A8'));
        $show->field('a9', __('A9'));
        $show->field('a10', __('A10'));
        $show->field('a11', __('A11'));
        $show->field('a12', __('A12'));
        $show->field('a13', __('A13'));
        $show->field('a14', __('A14'));
        $show->field('a15', __('A15'));
        $show->field('a16', __('A16'));
        $show->field('a17', __('A17'));
        $show->field('a18', __('A18'));
        $show->field('a19', __('A19'));
        $show->field('a20', __('A20'));
        $show->field('a21', __('A21'));
        $show->field('a22', __('A22'));
        $show->field('a23', __('A23'));
        $show->field('a24', __('A24'));
        $show->field('a25', __('A25'));
        $show->field('a26', __('A26'));
        $show->field('a27', __('A27'));
        $show->field('a28', __('A28'));
        $show->field('a29', __('A29'));
        $show->field('a30', __('A30'));
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
        $form = new Form(new EnterPlan);

        $form->date('enter_time', __('Enter time'))->default(date('Y-m-d'));
        $form->text('a1', __('A1'));
        $form->text('a2', __('A2'));
        $form->text('a3', __('A3'));
        $form->text('a4', __('A4'));
        $form->text('a5', __('A5'));
        $form->text('a6', __('A6'));
        $form->text('a7', __('A7'));
        $form->text('a8', __('A8'));
        $form->text('a9', __('A9'));
        $form->text('a10', __('A10'));
        $form->text('a11', __('A11'));
        $form->text('a12', __('A12'));
        $form->text('a13', __('A13'));
        $form->text('a14', __('A14'));
        $form->text('a15', __('A15'));
        $form->text('a16', __('A16'));
        $form->text('a17', __('A17'));
        $form->text('a18', __('A18'));
        $form->text('a19', __('A19'));
        $form->text('a20', __('A20'));
        $form->text('a21', __('A21'));
        $form->text('a22', __('A22'));
        $form->text('a23', __('A23'));
        $form->text('a24', __('A24'));
        $form->text('a25', __('A25'));
        $form->text('a26', __('A26'));
        $form->text('a27', __('A27'));
        $form->text('a28', __('A28'));
        $form->text('a29', __('A29'));
        $form->text('a30', __('A30'));

        return $form;
    }
}
