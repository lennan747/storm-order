<?php

namespace App\Admin\Controllers;

use App\Models\Channel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ChannelsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '渠道';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Channel);

        //$grid->column('id', __('Id'));
        $grid->column('code', __('渠道编号'));
        $grid->column('name', __('渠道公司名称'));
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
        $show = new Show(Channel::findOrFail($id));

        //$show->field('id', __('Id'));
        $show->field('code', '渠道编号');
        $show->field('name', '渠道公司名称');
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
        $form = new Form(new Channel);

        $form->text('code', __('渠道编号'));
        $form->text('name', __('渠道公司名称'));

        return $form;
    }

    public function check_channel()
    {
        //$code = request()->code;
        $name = request()->name;

//        if(!$name){
//            // 检查
//            $channel = Channel::query()
//                ->where('code',$code)
//                ->get()
//                ->toArray();
//        }else{
//            // 检查
//            $channel = Channel::query()
//                ->where('code',$code)
//                ->orWhere('name','like',"%{$name}%")
//                ->get()
//                ->toArray();
//        }

        // 检查
        $channel = Channel::query()
            ->where('name','like',"%{$name}%")
            ->get()
            ->toArray();

        return response()->json($channel);

        //return response()->
    }


    public function add_channel(){
        $name = request()->name;
        $channel = new Channel([
            'code' => str_random(20),
            'name' => $name
        ]);
        $channel->save();
        return response()->json(['status' => true,'id' => $channel->id]);
    }
}
