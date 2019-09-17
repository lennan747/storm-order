<?php

namespace App\Admin\Actions\Order;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OrdersImport;

class ImportOrder extends Action
{
    public $name = '导入圆通订单面单列表';

    protected $selector = '.import-post';

    public function handle(Request $request)
    {
        // 下面的代码获取到上传的文件，然后使用`maatwebsite/excel`等包来处理上传你的文件，保存到数据库
        $file  = $request->file('order_excel');

        Excel::import(new OrdersImport, request()->file('order_excel'));

        return $this->response()->success('导入完成！')->refresh();
    }

    public function form()
    {
        $this->file('order_excel', '请选择订单Excel文件');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default import-post"><i class="fa fa-upload"></i>导入圆通订单面单列表</a>
HTML;
    }
}
