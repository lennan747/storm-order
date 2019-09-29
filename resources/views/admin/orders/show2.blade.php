<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">基本信息</h3>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td width="120px">订单流水号</td>
                                <td>{{ $order->no }}</td>
                            </tr>
                            <tr>
                                <td width="120px">预付款</td>
                                <td>{{ $order->prepayments }}</td>
                            </tr>
                            <tr>
                                <td width="120px">总金额</td>
                                <td>{{ $order->total_amount }}</td>
                            </tr>
                            <tr>
                                <td width="120px">未付金额</td>
                                <td>{{ $order->total_amount - $order->prepayments}}</td>
                            </tr>
                            <tr>
                                <td width="120px">支付方式</td>
                                <td>{{ $order->payment_method }}</td>
                            </tr>
                            <tr>
                                <td width="120px">下单时间</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                            <tr>
                                <td width="120px">成交时间</td>
                                <td>{{ $order->transaction_datetime }}</td>
                            </tr>
                            <tr>
                                <td width="120px">数量</td>
                                <td>{{ $order->quantity }}</td>
                            </tr>
                            <tr>
                                <td width="120px">口味</td>
                                <td>{{ $order->taste }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">下单员信息</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td width="120px">下单员</td>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <td width="120px">微信编号</td>
                                <td>{{ $order->wechat->code }}</td>
                            </tr>
                            <tr>
                                <td width="120px">微信账号</td>
                                <td>{{ $order->wechat->account }}</td>
                            </tr>
                            <tr>
                                <td width="120px">微信二维码</td>
                                <td><img src="{{ $order->wechat->qrcode }}" style="max-width:50px;max-height:50px" class="img img-thumbnail"></td>
                            </tr>
                            <tr>
                                <td width="120px">微信手机号</td>
                                <td>{{ $order->wechat->phone }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">客户信息</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td width="120px">客户名称</td>
                                <td>{{ $order->fans_name }}</td>
                            </tr>
                            <tr>
                                <td width="120px">客户年纪</td>
                                <td>{{ $order->age }}</td>
                            </tr>
                            <tr>
                                <td width="120px">进粉时间</td>
                                <td>{{ $order->datetime }}</td>
                            </tr>
                            <tr>
                                <td width="120px">进粉渠道</td>
                                <td>{{ $order->channel }}</td>
                            </tr>
                            <tr>
                                <td width="120px">客户电话</td>
                                <td>{{ $order->phone_number }}</td>
                            </tr>
                            <tr>
                                <td width="120px">客户地址</td>
                                <td>{{ $order->address['province'].$order->address['city'].$order->address['district'].$order->address['address'] }}</td>
                            </tr>
                            <tr>
                                <td width="120px">客户备注</td>
                                <td>
                                    {{ $order->remark }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">物流信息</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <ul class="timeline">
                        <li class="time-label">
                            <span class="bg-red">{{ $express[$order->ship_data['ShipperCode']] }}</span>
                        </li>

                        @if(isset($order->ship_data['Traces']) && $order->ship_data['Traces'] != null && !empty($order->ship_data['Traces']))
                            @foreach($order->ship_data['Traces'] as $traces)
                                <li class="time-label">
                                    <!-- timeline icon -->
                                    <i class="fa fa-taxi bg-blue"></i>
                                    <div class="timeline-item">
                                       <h3 class="timeline-header no-border">
                                           <a href="#">{{ $traces['AcceptTime'] }}</a>
                                           {{ $traces['AcceptStation'] }}
                                       </h3>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
