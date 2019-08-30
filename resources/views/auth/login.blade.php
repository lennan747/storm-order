<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录-订单跟踪系统</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/tooplate.css') }}" rel="stylesheet">
</head>

<body class="bg03">
<div class="container">
    <div class="row tm-mt-big">
        <div class="col-12 mx-auto tm-login-col">
            <div class="bg-white tm-block">
                <div class="row">
                    <div class="col-12 text-center">
                        <i class="fas fa-3x fa-tachometer-alt tm-site-icon text-center"></i>
                        <h2 class="tm-block-title mt-3">登录</h2>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <form action="{{ route('login') }}" method="POST" class="tm-login-form">
                            @csrf
                            <div class="input-group">
                                <label for="name" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">用户名</label>
                                <input name="name" type="text" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" id="username" value="杨武东" required>
                            </div>
                            <div class="input-group mt-3">
                                <label for="password" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">密码</label>
                                <input name="password" type="password" class="form-control validate" id="password" value="1234" required>
                            </div>
                            <div class="input-group mt-3">
                                <button type="submit" class="btn btn-primary d-inline-block mx-auto">登录</button>
                            </div>
                            <div class="input-group mt-3">
                                <p><em>回音文化-订单跟踪系统.</em></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
