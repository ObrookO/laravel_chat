<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S、L 聊天系统 | 登录</title>
    <link rel="icon" href="/chat.ico" type="image/x-icon">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <img src="/img/logo.png" alt="" width="200">
        </div>
        <h3 style="position: relative;top: -110px;">S、L 聊天系统</h3>
        <form class="m-t" role="form" id="login-form" action="" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="用户名">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码">
            </div>
            <p class="text-danger notice"></p>
            <button type="button" class="btn btn-primary block full-width m-b" onclick="checkLogin()">登录</button>
            <a href="/register" class="btn btn-white block full-width m-b">注册</a>
        </form>
        <p class="m-t">
            <small>lx1577644822@gmail.com &copy; 2018</small>
        </p>
    </div>
</div>
<!-- Mainly scripts -->
<script src="/js/jquery-2.1.1.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    function checkLogin() {
        var username = $('input[name=username]');
        var password = $('input[name=password]');
        if (!username.val()) {
            alert('请输入用户名！');
        } else if (!password.val()) {
            alert('请输入密码！');
        } else {
            $.ajax({
                url: '/login',
                method: 'post',
                data: $('#login-form').serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.code == 200) {
                        $('.notice').text('');
                        window.location.href = '/';
                    } else {
                        $('.notice').text(res.message);
                    }
                }
            });
        }
    }

</script>
</body>
</html>
