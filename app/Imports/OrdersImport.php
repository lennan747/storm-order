<?php

namespace App\Imports;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class OrdersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // 未发货订单 导入订单物流号信息
        // 更新物流状态到发货状态
        $rows->shift();
        foreach ($rows as $row){
            //dd($row);
            // TODO 这是个大坑
            Order::where([
                ['no', $row[0]],
                ['ship_status', Order::SHIP_STATUS_PENDING]
            ])->update([
                'ship_data'   => json_encode(['LogisticCode' => $row[1], 'ShipperCode' => 'YTO']),
                'ship_status' => Order::SHIP_STATUS_DELIVERED,
                'ship_date'   => Carbon::now()
            ]);
        }
    }
}
