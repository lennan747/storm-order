<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2019/8/31
 * Time: 16:29
 */

namespace App\Traits;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

trait OrdersLogistics
{

    public function deliveredOrders()
    {
        // 获取正在发货的
        // 或者
        return Order::query()
            ->where('ship_status',Order::SHIP_STATUS_DELIVERED)
            ->whereNotNull('ship_data')
            ->get();

    }

    public function logisticsQuery()
    {
        $orders = $this->deliveredOrders();
        Log::info(json_encode($orders));
        foreach ($orders as $order)
        {
            // 判断是否有订单号，有的话就开始调用物流查询信息
            if($order->ship_data == null) {
                continue;
            }
            if($order->ship_data['LogisticCode'] == null) {
                continue;
            }
            // 没有的话就不调用
            $this->logistics($order);
        }
    }

    public function logistics(Order $order)
    {
        $orderSn = $order->no;
        $expressCode = $order->ship_data['ShipperCode'];
        $expressSn = $order->ship_data['LogisticCode'];
        $ship_data = \Jormin\KDNiao\KDNiao::queryExpressInfo($orderSn, $expressCode, $expressSn);

        Log::info(json_encode($ship_data));
        // 暂时无法查到信息
        // 更新物流信息，不更新物流状态
        if($ship_data['State'] == 0){
            $order->update(['ship_data' => $ship_data]);
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
    }
}
