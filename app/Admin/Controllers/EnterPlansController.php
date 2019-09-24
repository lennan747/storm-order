<?php

namespace App\Admin\Controllers;

use App\Models\ChannelAssgin;
use App\Models\EnterPlan;
use App\Models\Wechat;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Arr;

class EnterPlansController extends AdminController
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
        $grid = new Grid(new EnterPlan);
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            //$filter->like('enter_time', '进线时间');
            $filter->where(function ($query) {
                $query->where('enter_time', 'like', "%{$this->input}%")
                    ->orWhere('id', 1);
            }, '进线时间');
        });

        $grid->column('datetime', '进线时间');
        $wechats = Wechat::query()->orderBy('code','asc')->get()->toArray();
        //dd($wechats);
        foreach ($wechats as $v){
            $grid->column($v['code'], $v['code'])->display(function () use ($v){
                return '<a href="channel-assgins/17/edit" target="_blank">'.$this->{$v['code']}.'</a>';
            });
        }
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

        //$show->field('id', __('Id'));
        $show->field('enter_time', __('进线时间'));
        $show->field('a1', __('1'));
        $show->field('a2', __('1A'));
        $show->field('a3', __('2'));
        $show->field('a4', __('2A'));
        $show->field('a5', __('3'));
        $show->field('a6', __('5'));
        $show->field('a7', __('10'));
        $show->field('a8', __('11'));
        $show->field('a9', __('11A'));
        //$show->field('a10', __('12'));
        $show->field('a11', __('12'));
        $show->field('a12', __('13'));
        $show->field('a13', __('15'));
        $show->field('a14', __('16'));
        $show->field('a15', __('16A'));
        $show->field('a16', __('17'));
        $show->field('a17', __('18'));
        $show->field('a18', __('19'));
//        $show->field('a19', __('A19'));
//        $show->field('a20', __('A20'));
//        $show->field('a21', __('A21'));
//        $show->field('a22', __('A22'));
//        $show->field('a23', __('A23'));
//        $show->field('a24', __('A24'));
//        $show->field('a25', __('A25'));
//        $show->field('a26', __('A26'));
//        $show->field('a27', __('A27'));
//        $show->field('a28', __('A28'));
//        $show->field('a29', __('A29'));
//        $show->field('a30', __('A30'));
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
        $form = new Form(new EnterPlan);

        $form->date('enter_time', __('进线时间'))->default(date('Y-m-d'));
        $form->text('a1', __('1'));
        $form->text('a2', __('1A'));
        $form->text('a3', __('2'));
        $form->text('a4', __('2A'));
        $form->text('a5', __('3'));
        $form->text('a6', __('5'));
        $form->text('a7', __('10'));
        $form->text('a8', __('11'));
        $form->text('a9', __('11A'));
        $form->text('a10', __('12'));
        $form->text('a11', __('13'));
        $form->text('a12', __('15'));
        $form->text('a13', __('16'));
        $form->text('a14', __('16A'));
        $form->text('a15', __('17'));
        $form->text('a16', __('18'));
        $form->text('a17', __('19'));
//        $form->text('a18', __('A18'));
//        $form->text('a19', __('A19'));
//        $form->text('a20', __('A20'));
//        $form->text('a21', __('A21'));
//        $form->text('a22', __('A22'));
//        $form->text('a23', __('A23'));
//        $form->text('a24', __('A24'));
//        $form->text('a25', __('A25'));
//        $form->text('a26', __('A26'));
//        $form->text('a27', __('A27'));
//        $form->text('a28', __('A28'));
//        $form->text('a29', __('A29'));
//        $form->text('a30', __('A30'));

        return $form;
    }


    public function enter_data()
    {
        $wechats = Wechat::query()->get();
        $chnnel_assgins = ChannelAssgin::query()->orderBy('datetime', 'desc')->get();
        $res = [];
        $i = 0;
        $tag = [];
        foreach ($chnnel_assgins as $key => $v) {
            $datetime = $v['datetime']->toDateString();

            if (empty($tag) || !isset($tag[$datetime])) {
                $res[$i]['datetime'] = $datetime;
                $res[$i]['info'] = $v;
                $tag[$datetime] = $i;
                $i = $i + 1;
            }else{
                $temp = $res[$tag[$datetime]]['info']['wechat'];
                $temp = array_values(array_unique(array_merge($temp,$v['wechat'])));
                $res[$tag[$datetime]]['info']['wechat'] = $temp;
            }
        }

        foreach ($res as $k => $v) {
            foreach ($wechats as $wechat) {
                if (in_array($wechat['id'], $res[$k]['info']['wechat']) && $res[$k]['info']['mark']) {
                    $res[$k][$wechat['code']] = $res[$k]['info']['mark'];
                }else{
                    $res[$k][$wechat['code']] = "";
                }
            }
            unset($res[$k]['info']);
        }

        return response()->json($res);
    }
}
