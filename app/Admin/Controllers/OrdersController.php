<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Order\ElectronicFaceOrder;
use App\Admin\Actions\Order\ImportOrder;
use App\Admin\Extensions\OrdersExporter;
use App\Models\Order;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        // 查询过滤器
        $grid->filter(function ($filter){
            $filter->disableIdFilter();
            $filter->like('name', '客户姓名');
            $filter->like('phone_number', '客户电话');
            $filter->like('transaction_datetime', '成交时间');
            $filter->where(function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });
            }, '下单员');
            $filter->equal('ship_status','物流状态')->select(Order::$shipStatusMap);
        });

        // 排序方式
        $grid->model()->orderBy('id', 'desc');

        $grid->id('ID');
        $grid->no('订单流水号');
        $grid->fans_name('客户姓名');
        $grid->column('wechat.code','进线微信编号');
        $grid->column('channels', '进线渠道')->display(function (){
            if($this->transaction_datetime && $this->wechat_id){
                $channel_id = \DB::table('wechat_to_channels')->where([
                    ['datetime', '=', $this->transaction_datetime],
                    ['wechat_id', '=', $this->wechat_id],
                ])->value('channel_id');
//                if($channel_id !== null){
//                    return \DB::table('channels')->where('id',$channel_id)->value('code');
//                }
                return \DB::table('channels')->where('id',$channel_id)->value('name');
                //return $channel_id;
            }
            return '';
        });
        $grid->prepayments('预付款')->sortable();
        $grid->total_amount('订单金额')->sortable();
        $grid->column('unpaid_amount','未付金额')->display(function (){
             return $this['total_amount']-$this['prepayments'];
        });
        $grid->ship_status('物流状态')->display(function ($shipStatus){
            if($shipStatus == 'delivered'){
                return '<span style="color: #880000;">'.Order::$shipStatusMap[$shipStatus].'</span>';
            }elseif ($shipStatus == 'received'){
                return '<span style="color: red;">'.Order::$shipStatusMap[$shipStatus].'</span>';
            }else{
                return Order::$shipStatusMap[$shipStatus];
            }
        });
        $grid->closed('订单状态')->display(function ($closed){
            return $closed ? '已关闭' : '<span style="color: #0000FF;">进行中</span>';
        });
        $grid->datetime('客户进粉时间')->sortable();
        $grid->transaction_datetime('成交时间')->sortable();
        $grid->created_at('下单时间')->sortable();
        $grid->user_id('下单员')->display(function ($userId){
            return User::find($userId)->name;
        });
        $grid->actions(function ($actions){
            $actions->disableDelete();
            //$actions->disableEdit();
        });

        // 工具
        $grid->tools(function (Grid\Tools $tools) {
            // 导入电子面单订单
            $tools->append(new ImportOrder());
            // 导出电子面单订单
            $tools->append(new ElectronicFaceOrder());
        });

        // 自定义导出订单
        $grid->exporter(new OrdersExporter());

        $grid->disableColumnSelector();
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
        $order = Order::findOrFail($id);
        $express = [
            'YD'  => '韵达快递',
            'YTO' => '圆通速递',
            'SF'  => '顺丰快递'
        ];
        return view('admin.orders.show2',['order' => $order,'express' => $express]);
    }

//    public function show($id, Content $content)
//    {
//        return $content->header('订单详情')->body($this->detailNew($id));
//    }


    public function detailNew($id)
    {
        $orderInfo = Order::findOrFail($id);
        $express = [
            'YD'  => '韵达快递',
            'YTO' => '圆通速递',
            'SF'  => '顺丰快递'
        ];
        return view('admin.orders.show',['orderInfo' => $orderInfo,'express' => $express]);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);
        //$form->textarea('address', '寄件地址');
        //$form->switch('closed', '订单状态');
        //$form->switch('reviewed', __('Reviewed'));
        $form->embeds('ship_data', '物流信息', function ($form) {
            //...
            $form->text('LogisticCode','物流单号');
            $form->select('ShipperCode','物流公司')->options([
                'YD'  => '韵达快递',
                'YTO' => '圆通速递',
                'SF'  => '顺丰快递'
            ]);
            $form->textarea('Traces','物流信息')->readonly();
            $form->text('Reason','失败理由')->readonly();
        });

        $form->text('no', '订单流水号');
        $form->select('ship_status', '物流状态')->options(Order::$shipStatusMap);
        $form->text('user.name', '下单员')->readonly();
        $form->text('fans_name', '客户')->readonly();
        $form->date('datetime', '下单时间')->default(date('Y-m-d'))->readonly();
        $form->text('payment_method', '支付方式')->readonly();
        $form->text('phone_number', '客户电话')->readonly();
        $form->currency('prepayments', '预付金额')->symbol('￥')->readonly();
        $form->currency('total_amount','总金额')->symbol('￥')->readonly();
        $form->textarea('remark', '备注')->readonly();
        return $form;
    }
}
