<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ url('/') }}">
            订单跟踪系统
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('orders.create') }}">添加</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">列表</a></li>

                <li class="nav-item"><a class="nav-link" href="{{ route('sales.create') }}">销售数据添加</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('sales.index') }}">销售数据列表</a></li>
            <!--
                <li class="nav-item"><a class="nav-link" href="">列表</a></li>
                <li class="nav-item"><a class="nav-link" href="">统计</a></li>
-->
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- 登录注册链接开始 -->
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
                <!--
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
                    -->
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" id="logout" href="#"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                退出登录
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endguest
               <!-- 登录注册链接结束 -->
            </ul>
        </div>
    </div>
</nav>
