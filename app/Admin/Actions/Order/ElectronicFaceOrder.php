<?php

namespace App\Admin\Actions\Order;

use App\Admin\Extensions\InvoicesExport;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ElectronicFaceOrder extends BatchAction
{
    protected $fileName = 'ELECTRONICFACEORDER.xls';

    protected $selector = '.electronic-face-order';

    protected $headingsYw = [
        '物流订单号(选填，若不填则系统自动生成；若填则不允许重复)',
        '商品名称(选填)',
        '数量（选填）',
        '收件人姓名（必填）',
        '收件人地址（必填，必须包含省市区）',
        '收件人手机号（必填）',
        '发件人姓名（必填）',
        '发件人电话（选填）',
        '发件人地址（必填，必须包含省市区）',
        '发件人邮编（选填）',
        '代收货款（选填）',
        '备注（选填）',
        '收件人邮编（选填）',
        '收件人固话（选填）',
        '保价金额（选填）'
    ];

    public function handle(Collection $collection)
    {
        $rows = [];
        $rows[] = $this->headingsYw;
        foreach ($collection as $item)
        {
            $row['no'] = $item->no;
            $row['goods_name'] = '';
            $row['goods_number'] = '';
            $row['fans_name'] = $item->fans_name;
            $row['address'] = $item->address['province'].$item->address['city'].$item->address['district'].$item->address['address'];
            $row['phone_number'] = $item->phone_number;
            $row['send_name'] = '杨小星';
            $row['send_phone'] = '13677344771';
            $row['send_address'] = '湖南省长沙市岳麓区新长海中心';
            $row['send_postcode'] = '';
            $row['collection'] = $item->total_amount - $item->prepayments;
            $row['remark'] = '口味:'.$item->taste.'数量:'.$item->quantity.'其他：'.$item->remark;
            $row['postcode'] = '';
            $row['tel'] = '';
            $row['insurance_price'] = '';
            $rows[] = $row;
        }
        $export = new InvoicesExport($rows);
        $filePath = 'public/'.$this->fileName;
        Excel::store($export, $filePath,'',\Maatwebsite\Excel\Excel::XLS);
        return $this->response()->success('导出成功！')->download('../storage/'.$this->fileName);
    }


    public function name()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default electronic-face-order"><i class="fa fa-download"></i>导出订单面单列表</a>
HTML;
    }

}
