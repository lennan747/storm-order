@extends('layouts.app')

@section('title', '下单')

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
                            <a class="navbar-brand" href="#">{{ $order->id ? '修改': '新增' }}订单 {{ $order->id ? '-'.$order->no : '' }}</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </nav>
                    </div>
                    <div class="card-body">
                        <addresses-create-and-edit inline-template>
                        @if($order->id)
                        <form action="{{ route('orders.update', ['order' => $order->id]) }}" method="POST" accept-charset="UTF-8">
                            {{ method_field('PUT') }}
                        @else
                        <form action="{{ route('orders.store') }}" method="POST" accept-charset="UTF-8">
                        @endif
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">客户姓名</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control col-md-12" name="fans_name" value="{{ old('fans_name', $order->fans_name) }}" required>
                                    @error('fans_name')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="age" class="col-md-4 col-form-label text-md-right">客户年纪</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control col-md-12" name="age" value="{{ old('age', $order->age) }}" required>
                                    @error('age')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="datetime" class="col-md-4 col-form-label text-md-right">进线时间</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="datetime" id="datetimepicker" autocomplete="off" value="{{ old('datetime',$order ->id ? $order->datetime->toDateString(): '') }}" required>
                                    @error('datetime')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="transaction_datetime" class="col-md-4 col-form-label text-md-right">成交时间</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="transaction_datetime" id="datetimepicker2" autocomplete="off" value="{{ old('datetime',$order ->id ? $order->transaction_datetime->toDateString(): '') }}" required>
                                    @error('transaction_datetime')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="region" class="col-md-4 col-form-label text-md-right">省.市.区</label>
                                <div class="col-md-6">
                                        <select-district :init-value="{{ json_encode([old('province', $order->address['province']),old('city', $order->address['city']),old('district', $order->address['district'])]) }}"
                                                @change="onDistrictChanged" inline-template>
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <select class="form-control" v-model="provinceId">
                                                        <option value="">选择省</option>
                                                        <option v-for="(name, id) in provinces" :value="id">@{{ name }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select class="form-control" v-model="cityId">
                                                        <option value="">选择市</option>
                                                        <option v-for="(name, id) in cities" :value="id">@{{ name }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select class="form-control" v-model="districtId">
                                                        <option value="">选择区</option>
                                                        <option v-for="(name, id) in districts" :value="id">@{{ name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </select-district>
                                        <input type="hidden" name="province" v-model="province">
                                        <input type="hidden" name="city" v-model="city">
                                        <input type="hidden" name="district" v-model="district">
                                    @error('province')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    @error('city')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    @error('district')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">收货地址</label>
                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control" name="address" value="{{ old('address' ,$order->address['address']) }}" required>
                                    @error('address')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone_number" class="col-md-4 col-form-label text-md-right">收货电话</label>
                                <div class="col-md-6">
                                    <input id="phone_number" type="tel" class="form-control" name="phone_number" value="{{ old('phone_number' ,$order->phone_number) }}" required>
                                    @error('phone_number')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remark" class="col-md-4 col-form-label text-md-right">订单备注</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="remark">{{ old('remark', $order->remark) }}</textarea>
                                    @error('remark')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="prepayments" class="col-md-4 col-form-label text-md-right">预付定金</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="prepayments" value="{{ old('prepayments', $order->prepayments) }}" required>
                                    @error('prepayments')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="total_amount" class="col-md-4 col-form-label text-md-right">订单总金额</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}" required>
                                    @error('name')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="prepayments" class="col-md-4 col-form-label text-md-right">付款方式</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="payment_method" required>
                                        @foreach ($payment_method as $value)
                                            <option value="{{ $value->char }}" {{ $order->payment_method == $value->char ? 'selected' : ''}} >{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="express" class="col-md-4 col-form-label text-md-right">邮寄方式</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="express" required>
                                        <option value="YTO" {{ $order->ship_data['ShipperCode'] == 'YTO'? 'selected' : '' }}>圆通速递</option>
                                        <option value="SF" {{ $order->ship_data['ShipperCode'] == 'SF'? 'selected' : '' }}>顺丰快递</option>
                                        <option value="YD" {{ $order->ship_data['ShipperCode'] == 'YD'? 'selected' : '' }}>韵达快递</option>
                                    </select>
                                    @error('express')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="channel" class="col-md-4 col-form-label text-md-right">进线渠道</label>
                                <div class="col-md-6">
                                    <input id="channel" type="text" class="form-control" name="channel" value="{{ old('channel' ,$order->channel) }}" required>
                                    @error('channel')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="wechat_id" class="col-md-4 col-form-label text-md-right">成交微信号</label>
                                <div class="col-md-6">
                                    <select name="wechat_id" class="form-control" id="wechat_id">
                                        @foreach(Auth::user()->wechat as $wechat)
                                            <option
                                                    value="{{ $wechat->id }}"
                                                    {{ $order->wechat_id == $wechat->id ? 'selected' :'' }}
                                            >{{ $wechat->account }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="taste" class="col-md-4 col-form-label text-md-right">口味</label>
                                <div class="col-md-6">
                                    <input id="taste" type="text" class="form-control" name="taste" value="{{ old('taste' ,$order->taste) }}" required>
                                    @error('taste')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label text-md-right">数量</label>
                                <div class="col-md-6">
                                    <input id="quantity" type="number" class="form-control" name="quantity" value="{{ old('quantity' ,$order->quantity) }}" required>
                                    @error('quantity')
                                    <div class="mb-3 bg-danger text-white">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $order->id ? '修改订单' : '申请发货' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        </addresses-create-and-edit>
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

        $('#datetimepicker2').datetimepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            minView: 2,
            todayBtn:true,
            autoclose:true
        });
    </script>
@stop
