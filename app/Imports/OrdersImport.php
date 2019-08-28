<?php

namespace App\Imports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class OrdersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        //dd($rows);
        $rows->shift();
        foreach ($rows as $row){
            //dd($row);
            // TODO 这是个大坑
            Order::where([
                ['no', $row[0]],
                ['ship_status', Order::SHIP_STATUS_PENDING]
            ])->update([
                'ship_data' => json_encode(['LogisticCode' => $row[1], 'ShipperCode' => 'YTO']),
                'ship_status' => Order::SHIP_STATUS_DELIVERED
            ]);
        }
    }
}
