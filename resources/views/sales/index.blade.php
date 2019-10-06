@extends('layouts.app')

@section('title', '销售列表')

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
                            <a class="navbar-brand" href="#">销售数据列表</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </nav>
                    </div>
                    @if($salesDatas)
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">日期</th>
                                <th scope="col">渠道号</th>
                                <th scope="col">进线微信号</th>
                                <th scope="col">进线人数</th>
                                <th scope="col">回复人数</th>
                                <th scope="col">删粉人数</th>
                                <th scope="col">当天成交金额</th>
                                <th scope="col">当天成交笔数</th>
                                <th scope="col">删粉率</th>
                                <th scope="col">回复率</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($salesDatas as $salesData)
                                <tr>
                                    <th scope="row">{{ $salesData->sales_time }}</th>
                                    <td>{{ $salesData->channel }}</td>
                                    <td>@foreach($weachts as $wechat)
                                         @if($wechat->id == $salesData->wechat_id)
                                                {{ $wechat->account }}
                                         @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $salesData->enter_number }}</td>
                                    <td>{{ $salesData->repay_number }}</td>
                                    <td>{{ $salesData->delete_number }}</td>
                                    <td>{{ $salesData->transaction_amount }}</td>
                                    <td>{{ $salesData->transaction_number }}</td>
                                    <td>{{ $salesData->enter_number == 0 ? 0 : number_format($salesData->delete_number/$salesData->enter_number,4)*100 }}%</td>
                                    <td>{{ $salesData->enter_number == 0 ? 0 : number_format($salesData->repay_number/$salesData->enter_number,4)*100 }}%</td>
                                    <td>
                                        <a href="{{ route('sales.edit', ['sale' => $salesData->id]) }}" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">修改</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                @if($salesDatas->count() > 0)
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
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
