<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '回音') - 订单跟踪系统</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- https://fontawesome.com/ -->
    <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet">
    <!-- https://getbootstrap.com/ -->
    <link href="{{ asset('css/tooplate.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body id="reportsPage">
<div id="home" class="{{ route_class() }}-page">
    <div class="container">
        @include('layouts._header')
        @yield('content')
        @include('layouts._footer')
    </div>
</div>
<!-- JS 脚本 -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
