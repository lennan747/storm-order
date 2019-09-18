<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2019/8/31
 * Time: 16:29
 */

namespace App\Traits;

use App\Models\Order;
use App\Jobs\UpdateLogistics;

trait OrdersLogistics
{

    public function deliveredOrders()
    {
        // 获取正在发货的订单
        // 或者
        return Order::query()
            ->where('ship_status',Order::SHIP_STATUS_DELIVERED)
            ->whereNotNull('ship_data')
            ->get();

    }

    public function logisticsQuery()
    {
        $orders = $this->deliveredOrders();
        foreach ($orders as $order)
        {
            // 判断是否有订单号，有的话就开始调用物流查询信息
            if($order->ship_data == null) {
                continue;
            }

            // 物流订单号为空不查询
            if($order->ship_data['LogisticCode'] == null || $order->ship_data['LogisticCode'] == '') {
                continue;
            }

            // 没有的话就不调用
            dispatch(new UpdateLogistics($order));
        }
    }
}
