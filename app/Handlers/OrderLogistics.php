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
        // 顺丰快递要手机号后4位
        if($expressCode == 'SF'){
            $customerName = 8422;
        }else{
            $customerName = null;
        }
        $ship_data = \Jormin\KDNiao\KDNiao::queryExpressInfo($orderSn, $expressCode, $expressSn,$customerName);
        return $ship_data;
    }
}
