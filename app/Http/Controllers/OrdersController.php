<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //
    public function index(OrderRequest $request)
    {
        $query = $request->user()->orders()->withOrder($request->order);

        $where = [];
        // 0未发货,1已发货,2已收货
        if (isset($request->ship_status)) {
            $where[] = ['ship_status', '=', $request->ship_status];
        }

        // 0未完成，1完成
        if (isset($request->closed)) {
            $where[] = ['closed', '=', $request->closed];
        }

        // 微信号或客户名称
        if (isset($request->fans_name) && !empty($request->fans_name)) {
            $where[] = ['fans_name', 'like', '%' . $request->fans_name . '%'];
        }

        $query->where($where);

        // 订单时间搜索
        if (isset($request->create_at) && !empty($request->create_at)) {
            $query->whereDate('created_at', $request->create_at);
        }


        $orders = $query->paginate(10);

        $total = $orders->pluck('total_amount')->sum();
        return view('orders.index', ['orders' => $orders,'total' => $total]);
    }

    public function create(Order $order)
    {
        $payment_method = Payment::all();
        return view('orders.create_and_edit',compact('order','payment_method'));
    }

    public function store(OrderRequest $request)
    {
        $user = $request->user();
        $province       = $request->input('province');
        $city           = $request->input('city');
        $district       = $request->input('district');
        $address        = $request->input('address');

        $order = new Order([
            'fans_name'       => $request->input('fans_name'),
            'datetime'        => $request->input('datetime'),
            'prepayments'     => $request->input('prepayments'),
            'total_amount'    => $request->input('total_amount'),
            'payment_method'  => $request->input('payment_method'),
            'address'         => ['province' => $province, 'city'     => $city, 'district' => $district, 'address'  => $address],
            'phone_number'    => $request->input('phone_number'),
            'remark'          => $request->input('remark'),
            'quantity'        => $request->input('quantity'),
            'channel'         => $request->input('channel'),
            'taste'           => $request->input('taste'),
        ]);
        $order->user()->associate($user);
        $order->save();
        return redirect()->route('orders.index');
    }

    public function edit(Order $order)
    {
        // laravel会用Carbon对象把data格式自动转化未dataTime格式
        // dd($order->datetime->toDateString());
        $payment_method = Payment::all();
        return view('orders.create_and_edit',compact('order','payment_method'));
    }

    public function show(Order $order)
    {
        //$order->payment_method = Payment::find($order->payment_method)->name;
        return view('orders.show', compact('order'));
    }

    public function update(OrderRequest $request, Order $order)
    {
        $province       = $request->input('province');
        $city           = $request->input('city');
        $district       = $request->input('district');
        $address        = $request->input('address');
        $order->user()->associate($request->user());
        $order->update([
            'fans_name'       => $request->input('fans_name'),
            'datetime'        => $request->input('datetime'),
            'prepayments'     => $request->input('prepayments'),
            'total_amount'    => $request->input('total_amount'),
            'payment_method'  => $request->input('payment_method'),
            'address'         => ['province' => $province, 'city'     => $city, 'district' => $district, 'address'  => $address],
            'phone_number'    => $request->input('phone_number'),
            'remark'          => $request->input('remark'),
            'quantity'        => $request->input('quantity'),
            'channel'         => $request->input('channel'),
            'taste'           => $request->input('taste'),
        ]);

        return redirect()->route('orders.edit',['order' => $order->id])->with('status', '更新订单成功');
    }

    public function logistics(Request $request,Order $order)
    {
        $orderSn = $order->no;
        $expressCode = $order->ship_data['ShipperCode'];
        $expressSn = $order->ship_data['LogisticCode'];
        $ship_data = \Jormin\KDNiao\KDNiao::queryExpressInfo($orderSn, $expressCode, $expressSn);
        $order->user()->associate($request->user());
        // 暂时无法查到信息
        if($ship_data['State'] == 0){
            $order->update(['ship_data' => $ship_data]);
            return redirect()->route('orders.show',['order' => $order->id])->with('status', $ship_data['Reason']);
        }

        // 已发货在途中
        if($ship_data['State'] == 2){
            $order->update([
                'ship_status' => Order::SHIP_STATUS_DELIVERED,
                'ship_data' => $ship_data
            ]);
        }
        // 已收货
        if($ship_data['State'] == 3){
            $order->update([
                'ship_status' => Order::SHIP_STATUS_RECEIVED,
                'ship_data' => $ship_data
            ]);
        }

        return redirect()->route('orders.show',['order' => $order->id])->with('status', '物流查询成功');
    }
}
