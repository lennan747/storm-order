@extends('layouts.app')

@section('title', '订单详情')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('status'))
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="navbar-brand" href="#">订单详情</a>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">进粉时间：{{ $order->datetime->toDateString() }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">订单创建时间：{{ $order->created_at }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">订单上次更新时间：{{ $order->created_at }}</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="card-body">

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">订单流水号：{{ $order->no }}</li>
                            <li class="list-group-item">支付方式：{{ $order->payment_method }}</li>
                            <li class="list-group-item">预付款：{{ $order->prepayments }}</li>
                            <li class="list-group-item">未付款：{{ $order->total_amount -$order->prepayments }}</li>
                            <li class="list-group-item">订单金额：{{ $order->total_amount }}</li>
                        </ul>

                        <ul class="list-group" style="margin-top: 1em">
                            <li class="list-group-item list-group-item-success">收件人姓名：{{ $order->fans_name }}</li>
                            <li class="list-group-item list-group-item-success">收件人电话：{{ $order->phone_number }}</li>
                            <li class="list-group-item list-group-item-success">
                                收货地址：{{ $order->address['province'].$order->address['city'].$order->address['district'].$order->address['address'] }}
                            </li>
                            <li class="list-group-item list-group-item-success">备注：{{ $order->remark }}</li>
                        </ul>

                        <ul class="list-group" style="margin-top: 1em">
                            <li class="list-group-item">口味：{{ $order->taste }}</li>
                            <li class="list-group-item">数量：{{ $order->quantity }}</li>
                        </ul>

                        <ul class="list-group" style="margin-top: 1em">
                            <li class="list-group-item">进线时间：{{ $order->datetime }}</li>
                            <li class="list-group-item">进线渠道：{{ $order->channel }}</li>
                        </ul>

                    </div>
                    <div class="card-footer">
                        @if($order->ship_status === \App\Models\Order::SHIP_STATUS_DELIVERED)
                            <form class="form-inline" action="{{ route('orders.logistics',['order' => $order->id]) }}" method="GET" accept-charset="UTF-8">
                                @csrf
                                <button type="submit" class="btn btn-primary my-1">更新物流</button>
                            </form>
                        @endif

                        <!-- 物流信息不为空显示 -->
                            @if(isset($order->ship_data['Traces']))
                                <ul class="list-group">
                                    @foreach($order->ship_data['Traces'] as $traces)
                                        <li class="list-group-item list-group-item-secondary">{{ $traces['AcceptTime'].':'.$traces['AcceptStation'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

