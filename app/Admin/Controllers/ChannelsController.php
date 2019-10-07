<?php

namespace App\Admin\Controllers;

use App\Http\Requests\Request;
use App\Models\Channel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
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
        $grid->column('id', __('渠道编号'));
        $grid->column('name', __('渠道公司名称'));
//        $grid->column('order','渠道成交金额')->display(function (){
//            // 获取当前渠道所有订单并且计算金额
//            \DB::table();
//        });
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

        $show->field('id', '渠道编号');
        $show->field('name', '渠道公司名称');

        return $show;
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_channel()
    {
        $name = request()->name;
        // 检查
        $name_array = $this->str2arr_utf8($name,'utf8');
        $query = '';
        foreach ($name_array as $k => $v){
            $query .= ' name like "%'.$v.'%" or';
        }
        $query .= ' code like "%'.$name.'%"';

        $channel = Channel::query()
            ->whereRaw($query)
            ->get()
            ->toArray();
        return response()->json($channel);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Channel);

        //$form->text('code', __('渠道编号'));
        $form->text('name', __('渠道公司名称'));

        return $form;
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_channel(){
        $name = request()->name;
        // 重复名称不添加
        if(Channel::query()->where('name', $name)->exists()){
            return response()->json(['status' => false]);
        }

        $channel = new Channel([
            'code' => str_random(20),
            'name' => $name
        ]);
        $channel->save();
        return response()->json(['status' => true,'id' => $channel->id]);
    }

    /**
     * @param $str
     * @return array
     */
    public function str2arr_utf8($str)
    {
        $len = mb_strlen($str, 'utf-8');
        $arr = [];
        for ($i=0; $i<$len; $i++)
            $arr[] = mb_substr($str, $i, 1, 'utf-8');
        return $arr;
    }
}
