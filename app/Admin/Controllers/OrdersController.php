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
        $grid->datetime('客户进粉时间')->sortable();
        $grid->prepayments('预付款')->sortable();
        $grid->total_amount('订单金额')->sortable();
        $grid->column('unpaid_amount','未付金额')->display(function (){
             return $this['total_amount']-$this['prepayments'];
        });
        $grid->ship_status('物流状态')->display(function ($shipStatus){
            return Order::$shipStatusMap[$shipStatus];
        });
        $grid->closed('订单状态')->display(function ($closed){
            return $closed ? '已关闭' : '进行中';
        });

        $grid->created_at('下单时间')->sortable();
        $grid->user_id('下单员')->display(function ($userId){
            return User::find($userId)->name;
        });
        $grid->actions(function ($actions){
            $actions->disableDelete();
            $actions->disableEdit();
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
        $show = new Show(Order::findOrFail($id));

        $show->id('ID');
        $show->no('订单流水号');
        $show->prepayments('预付款');
        $show->total_amount('订单金额');
        $show->divider();

        $show->closed('订单状态');
        $show->created_at('下单时间');
        $show->updated_at('更新时间');

        $show->divider();
        $show->ship_status('物流状态')->using(Order::$shipStatusMap);
        $show->ship_data('物流数据');

        $show->divider();
        $show->name('客户姓名');
        $show->datetime('客户进粉时间');
        $show->phone_number('客户电话号码');
        $show->remark('客户备注');
        $show->reviewed('客户反馈');
        $show->address('收货地址')->as(function ($address) {
            $html = "";
            foreach ($address as $value){
                $html = $html.$value;
            }
            return $html;
        });

        $show->user('下单员',function($user){
            $user->setResource('/admin/users');
            $user->name('账户名');
        });

        $show->paymentMethod('支付',function ($paymentMethod){
            $paymentMethod->setResource('/admin/payment');
            $paymentMethod->name('支付方式');
        });
        return $show;
    }

    public function show($id, Content $content)
    {
        return $content->header('订单详情')->body($this->detailNew($id));
    }


    public function detailNew($id)
    {
        $orderInfo = Order::findOrFail($id);
        return view('admin.orders.show',['orderInfo' => $orderInfo]);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        $form->number('user_id', __('User id'));
        $form->text('fans_name', __('Fans name'));
        $form->date('datetime', __('Datetime'))->default(date('Y-m-d'));
        $form->text('payment_method', __('Payment method'));
        $form->text('phone_number', __('Phone number'));
        $form->text('no', __('No'));
        $form->decimal('prepayments', __('Prepayments'));
        $form->decimal('total_amount', __('Total amount'));
        $form->textarea('address', __('Address'));
        $form->text('ship_status', __('Ship status'))->default('pending');
        $form->textarea('ship_data', __('Ship data'));
        $form->switch('closed', __('Closed'));
        $form->switch('reviewed', __('Reviewed'));
        $form->textarea('remark', __('Remark'));

        return $form;
    }
}
