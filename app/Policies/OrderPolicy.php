<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy extends Policy
{

    public function update(User $user, Order $order)
    {
        // return $topic->user_id == $user->id;
        return $order->user_id ==$user->id;
    }

    public function destroy(User $user, Order $order)
    {
        return $order->user_id ==$user->id;
    }

    public function show(User $user, Order $order)
    {
        return $order->user_id ==$user->id;
    }

    public function edit(User $user, Order $order)
    {
        //
        return $order->user_id == $user->id and $order->ship_status === Order::SHIP_STATUS_PENDING;
    }

    public function logistics(User $user, Order $order)
    {
        //
        return $order->user_id == $user->id;
    }
}
