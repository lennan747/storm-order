@extends('layouts.app')

@section('title', '销售数据')

@section('styles')
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@stop

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
                            <a class="navbar-brand" href="#">{{ $salesData->id ? '修改': '新增' }}销售信息 </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </nav>
                    </div>
                    <div class="card-body">
                        @if($salesData->id)
                        <form action="{{ route('sales.update', ['sales' => $salesData->id]) }}" method="POST" accept-charset="UTF-8">
                            {{ method_field('PUT') }}
                        @else
                        <form action="{{ route('sales.store') }}" method="POST" accept-charset="UTF-8">
                        @endif
                            @csrf
                            <div class="form-group row">
                                <label for="channel" class="col-md-4 col-form-label text-md-right">进线渠道</label>
                                <div class="col-md-6">
                                    <input
                                            type="text"
                                            class="form-control col-md-12"
                                            name="channel"
                                            value="{{ old('channel', $salesData->channel) }}"
                                            required
                                   >
                                    @error('channel')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sales_time" class="col-md-4 col-form-label text-md-right">销售日期</label>
                                <div class="col-md-6">
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="sales_time"
                                            @if(!$salesData->id) id="datetimepicker" @endif
                                            autocomplete="off"
                                            value="{{ old('sales_time',$salesData ->id ? $salesData->sales_time: '') }}"
                                            required
                                            @if($salesData->id) readonly @endif
                                    >
                                    @error('sales_time')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="enter_number" class="col-md-4 col-form-label text-md-right">进线人数</label>
                                <div class="col-md-6">
                                    <input
                                            type="number"
                                            class="form-control"
                                            name="enter_number"
                                            value="{{ old('enter_number' ,$salesData->enter_number) }}"
                                            required
                                    >

                                    @error('enter_number')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="repay_number" class="col-md-4 col-form-label text-md-right">回复人数</label>
                                <div class="col-md-6">
                                    <input
                                            type="number"
                                            class="form-control"
                                            name="repay_number"
                                            value="{{ old('repay_number' ,$salesData->repay_number) }}"
                                            required
                                    >
                                    @error('repay_number')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="delete_number" class="col-md-4 col-form-label text-md-right">删粉人数</label>
                                <div class="col-md-6">
                                    <input
                                            type="number"
                                            class="form-control"
                                            name="delete_number"
                                            value="{{ old('delete_number' ,$salesData->delete_number) }}"
                                            required
                                    >
                                    @error('delete_number')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="transaction_amount" class="col-md-4 col-form-label text-md-right">当日订单金额</label>
                                <div class="col-md-6">
                                    <input
                                            type="number"
                                            class="form-control"
                                            name="transaction_amount"
                                            value="{{ old('transaction_amount', $salesData->transaction_amount) }}"
                                            required
                                    >

                                    @error('transaction_amount')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="transaction_number" class="col-md-4 col-form-label text-md-right">当日订单笔数</label>
                                <div class="col-md-6">
                                    <input
                                            type="number"
                                            class="form-control"
                                            name="transaction_number"
                                            value="{{ old('transaction_number', $salesData->transaction_number) }}"
                                            required
                                    >

                                    @error('transaction_number')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $salesData->id ? '修改数据' : '添加销售数据' }}
                                    </button>
                                </div>
                            </div>

                        </form>

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
        $('#datetimepicker').datetimepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            minView: 2,
            todayBtn:true,
            autoclose:true
        });
    </script>
@stop
