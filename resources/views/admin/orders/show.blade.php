
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">订单基本信息</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <td width="120px">订单流水号</td>
                    <td>{{ $orderInfo->no }}</td>
                </tr>
                <tr>
                    <td width="120px">预付款</td>
                    <td>{{ $orderInfo->prepayments }}</td>
                </tr>
                <tr>
                    <td width="120px">总金额</td>
                    <td>{{ $orderInfo->total_amount }}</td>
                </tr>
                <tr>
                    <td width="120px">未付金额</td>
                    <td>{{ $orderInfo->total_amount - $orderInfo->prepayments}}</td>
                </tr>
                <tr>
                    <td width="120px">支付方式</td>
                    <td>{{ $orderInfo->paymentMethod }}</td>
                </tr>
                <tr>
                    <td width="120px">下单员</td>
                    <td>{{ $orderInfo->user->name }}</td>
                </tr>
                <tr>
                    <td width="120px">下单时间</td>
                    <td>{{ $orderInfo->created_at }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">客户基本信息</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <td width="120px">客户名称</td>
                    <td>{{ $orderInfo->name }}</td>
                </tr>
                <tr>
                    <td width="120px">进粉时间</td>
                    <td>{{ $orderInfo->datetime }}</td>
                </tr>
                <tr>
                    <td width="120px">进粉渠道</td>
                    <td>{{ $orderInfo->channel }}</td>
                </tr>
                <tr>
                    <td width="120px">客户电话</td>
                    <td>{{ $orderInfo->phone_number }}</td>
                </tr>
                <tr>
                    <td width="120px">客户地址</td>
                    <td>{{ $orderInfo->address['province'].$orderInfo->address['city'].$orderInfo->address['district'].$orderInfo->address['address'] }}</td>
                </tr>
                <tr>
                    <td width="120px">客户备注</td>
                    <td>
                        {{ $orderInfo->remark }}
                    </td>
                </tr>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">商品信息</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <td width="120px">数量</td>
                    <td>{{ $orderInfo->quantity }}</td>
                </tr>
                <tr>
                    <td width="120px">口味</td>
                    <td>{{ $orderInfo->taste }}</td>
                </tr>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
</div>
<!--
已发货，可查看物流状态
-->
@if(!empty($orderInfo->ship_data))
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">物流基本信息</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    @foreach($orderInfo->ship_data['Traces'] as $traces)
                        <tr>
                            <td width="200px">{{ $traces['AcceptTime'] }}</td>
                            <td>{{ $traces['AcceptStation'] }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
    </div>
@endif


