<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Wechat;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WechatsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '微信号';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Wechat);

        $grid->column('id', __('Id'));
        $grid->column('user.name', '所属下单员');
        $grid->column('code', '编号');
        $grid->column('account', '微信号');
        $grid->column('phone', '手机号');
        $grid->column('qrcode', '二维码')->image('http://'.$_SERVER["HTTP_HOST"].'/upload',50,50);
        $grid->column('sort','排序');
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
        $show = new Show(Wechat::findOrFail($id));

        //$show->field('id', __('Id'));
        $show->field('user.name', '所属下单员');
        $show->field('code','编号');
        $show->field('account', '微信号');
        $show->field('phone', '手机号');
        $show->field('qrcode', '二维码');
        $show->field('sort', '排序');
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
        $form = new Form(new Wechat);

        $form->select('user_id','所属下单员')->options(function (){
            $data = \DB::table('users')->select('id','name')->get();
            $res = [];
            foreach ($data as $v){
                $res[$v->id] = $v->name;
            }

            return $res;
        });
        $form->text('code', '编号');
        $form->text('account', ' 微信号');
        $form->mobile('phone', '手机号');
        $form->image('qrcode', '二维码')->move('public/upload/qrcode');
        $form->number('sort', '排序');

        return $form;
    }
}
