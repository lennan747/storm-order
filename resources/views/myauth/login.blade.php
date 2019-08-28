<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>订单跟踪系统-登录</title>
    <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
    <meta name="author" content="Vincent Garreau" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="{{ asset('css/login.css') }}">
</head>
<body>
<!-- particles.js container -->
<div id="particles-js" style="display: flex;align-items: center;justify-content: center">
</div>
<div class="login-page">
    <form id="form" method="POST" action="{{ route('login') }}">
        @csrf
    <div class="login-content">
        <div class="login-tit">订单跟踪系统 <span style="margin-left: 10em; ">登录</span></div>
        <div class="login-input">
            <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="用户名/手机号">
        </div>
        <div class="login-input">
            <input type="password" name="password" required autocomplete="current-password" placeholder="密码">
        </div>
        <div class="login-btn">
            <div class="login-btn-left">
                <span onclick="fn()">登录</span>
            </div>
            <!--
            <div class="login-btn-right" onClick="changeImg()">
                <img src="{{ asset('images/check.png') }}" alt="" id="picture"> 记住密码
            </div>
            -->
        </div>
    </div>
    </form>
</div>


<!-- scripts -->
<script src="{{ asset('js/particles.js') }}"></script>
<script src="{{ asset('js/login.js') }}"></script>
<script>
    function changeImg(){
        let pic = document.getElementById('picture');
        console.log(pic.src);
        if(pic.getAttribute("src", 2) === "{{ asset('images/check.png') }}"){
            pic.src ="{{ asset('images/checked.png') }}"
        }else{
            pic.src ="{{ asset('images/check.png') }}"
        }
    }
    function fn(){
        document.getElementById('form').submit();
    }
</script>
</body>
</html>
