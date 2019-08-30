<?php
/**
 * 订单列表导出
 * 用于圆通电子面单批量生成
 * Created by PhpStorm.
 * User: leo
 * Date: 2019/8/26
 * Time: 17:09
 */

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Facades\Excel;

class OrdersExporter extends ExcelExporter
{
    protected $fileName = '订单列表.xls';

    protected $headingsYw = [
        '用户名',
        '进线日期',
        '成交日期',
        '进线渠道',
        '详细地址',
        '联系方式',
        '盒数',
        '定金',
        '口味',
        '尾款',
        '发货日期',
        '收货日期',
        '总价'
    ];

    public function export()
    {
//        parent::export(); // TODO: Change the autogenerated stub

        $rows = [];
        $rows[] = $this->headingsYw;

        $data = $this->getData();

        if (count($data)) {
            foreach ($data as $v) {
                $row = [];
                $row['name'] = $v['fans_name'];
                $row['datetime'] = $v['datetime'];
                $row['updated_at'] = $v['updated_at'];
                $row['channel'] = $v['channel'];
                $row['addr'] = $v['address']['province'].$v['address']['city'].$v['address']['district'].$v['address']['address'];
                $row['quantity'] = $v['quantity'];
                $row['prepayments'] = $v['prepayments'];
                $row['taste'] = $v['taste'];
                $row['tail'] = $v['total_amount'] - $v['prepayments'];
                $row['tail'] = $v['total_amount'] - $v['prepayments'];
                $row['total_amount'] = $v['total_amount'];
                $rows[] = $row;
            }
        }
        //dd($rows);
        // 数据格式化
        $export = new InvoicesExport($rows);

        // 导出
        return Excel::download($export, $this->fileName, \Maatwebsite\Excel\Excel::XLS)->send();
    }
}
