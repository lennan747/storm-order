<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Faker\Generator;
use Illuminate\Support\Facades\Hash;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->column('id', __('ID'));
        $grid->column('name', __('username'));
        //$grid->column('email', __('Email'));
        //$grid->column('email_verified_at', __('Email verified at'));
        //$grid->column('password', __('password'));
        //$grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('Created at'));
        //$grid->column('updated_at', __('Updated at'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        //$show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        //$show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User);

        $form->text('name', __('Name'))->rules(["required", "unique:users"]);
        //$form->email('email', __('Email'));
        ///$form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'))->rules(["required"]);
        $form->password('sure_password', __('SurePassword'))->rules(["required"]);
        //$form->text('remember_token', __('Remember token'));
        $form->ignore(['sure_password']);

        $form->submitted(function (Form $form) {
            if ($form->password !== $form->sure_password){
                admin_toastr('密码不一直', 'error');
            }
        });

        $form->saving(function (Form $form) {
            $form->model()->email = \Faker\Factory::create()->safeEmail;
            $form->password = Hash::make($form->password);
        });

        return $form;
    }
}
