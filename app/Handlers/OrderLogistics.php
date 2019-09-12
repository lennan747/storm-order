<?php
namespace App\Handlers;

use App\Models\Order;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2019/9/2
 * Time: 14:33
 */
class OrderLogistics
{
    public function logistics(Order $order)
    {
        $orderSn = $order->no;
        $expressCode = $order->ship_data['ShipperCode'];
        $expressSn = $order->ship_data['LogisticCode'];
        $ship_data = \Jormin\KDNiao\KDNiao::queryExpressInfo($orderSn, $expressCode, $expressSn);
        return $ship_data;
    }
}
