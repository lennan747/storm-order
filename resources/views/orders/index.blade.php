@extends('layouts.app')

@section('title', '订单列表')

@section('styles')
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="navbar-brand" href="#">订单列表</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            订单状态
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('orders.index') }}?ship_status={{ \App\Models\Order::SHIP_STATUS_PENDING }}">未发货</a>
                                            <a class="dropdown-item" href="{{ route('orders.index') }}?ship_status={{ \App\Models\Order::SHIP_STATUS_DELIVERED }}">已发货</a>
                                            <a class="dropdown-item" href="{{ route('orders.index') }}?ship_status={{ \App\Models\Order::SHIP_STATUS_RECEIVED }}">已收货</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('orders.index') }}?closed=0">未完成订单</a>
                                            <a class="dropdown-item" href="{{ route('orders.index') }}?closed=1">已完成订单</a>
                                        </div>
                                    </li>
                                </ul>
                                <form class="form-inline my-2 my-lg-0" action="{{ route('orders.index') }}" method="GET">
                                    <input class="form-control mr-sm-2" type="search" name="fans_name" placeholder="客户姓名/微信号" aria-label="Search">
                                    <input type="search" class="form-control mr-sm-2" name="create_at" autocomplete="off" id="datetimepicker"  placeholder="下单时间" aria-label="Search" >
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜索</button>
                                </form>
                            </div>
                        </nav>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">客户姓名/微信号</th>
                                <th scope="col">订单号</th>
                                <th scope="col">进粉时间</th>
                                <th scope="col">订单金额</th>
                                <th scope="col">预付款</th>
                                <th scope="col">未付款</th>
                                <th scope="col">订单状态</th>
                                <th scope="col">下单时间</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{ $order->fans_name }}</th>
                                    <td>{{ $order->no }}</td>
                                    <td>{{ $order->datetime->toDateString() }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->prepayments }}</td>
                                    <td>{{ $order->total_amount - $order->prepayments }}</td>
                                    <td>
                                        @if($order->closed)
                                            订单完成
                                        @else
                                            {{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>
                                        @if($order->ship_status === \App\Models\Order::SHIP_STATUS_PENDING)
                                            <a href="{{ route('orders.edit', ['order' => $order->id]) }}" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">修改</a>
                                        @endif
                                        <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">详情</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                {!! $orders->appends(Request::except('page'))->render() !!}
                            </div>
                            <div class="col-md-2 text-center"><span class="badge badge-info" style="line-height: 3;">{{ Auth::user()->name }}-销售订单</span></div>
                            <div class="col-md-2 text-center"><span class="badge badge-info" style="line-height: 3;">订单总数({{ $order->count() }})￥</span></div>
                            <div class="col-md-2 text-center"><span class="badge badge-info" style="line-height: 3;">订单总额({{ $total }})￥</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script>

        // 时间插件
        $('#datetimepicker').datetimepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            minView: 2,
            todayBtn:true,
            autoclose:true
        });
    </script>
@endsection
