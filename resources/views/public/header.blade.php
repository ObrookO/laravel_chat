<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>S、L 聊天系统</title>
    <link rel="icon" href="/chat.ico" type="image/x-icon">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <style>
        .alert {
            margin-top: 20px;
        }

        .system-news-alert .label {
            margin-right: 5px;
            font-size: 14px;
            cursor: pointer;
        }

    </style>
    @section('style')
    @show
</head>

<body>

<div id="wrapper">
    <!--左侧的菜单-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="profile-element">
                        <span>
                            <img alt="image" class="img-rounded" width="100" src="/img/photo2.png" style="position: relative;left: 20px;">
                        </span>
                        <h4 class="clear text-white">
                            <span class="block m-t-xs text-center">欢迎来到 S、L 聊天系统</span>
                        </h4>
                        <h4 class="clear text-white">
                            <span class="block m-t-xs text-center"> Hello, {{ session('userInfo')->username }} </span>
                        </h4>
                    </div>
                    <div class="logo-element">Chat</div>
                </li>
                <li>
                    <a href="{{ route('index') }}"><i class="fa fa-home"></i><span class="nav-label">首页</span></a>
                </li>
                <li>
                    <a href="{{ route('friends.index') }}"><i class="fa fa-user"></i> <span class="nav-label">好友</span></a>
                </li>
                <li>
                    <a href=""><i class="fa fa-users"></i> <span class="nav-label">群组</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="">test</a></li>
                        <li><a href="">test</a></li>
                        <li><a href="">test</a></li>
                        <li><a href="">test</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <!--顶部的菜单-->
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="label label-primary news-num"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts news-list">
                        </ul>
                    </li>
                    <li>
                        <img class="img-circle" width="40" src="/img/a3.jpg" alt="">
                    </li>
                    <li>
                        <a href="/logout">
                            <i class="fa fa-sign-out"></i> 退出
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        {{--错误信息的提示框--}}
        <div class="alert alert-danger alert-dismissable hide" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong></strong>
        </div>

        {{--系统消息的提示框--}}
        <div class="alert alert-info alert-dismissable system-news-alert hide" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong class="news-content">想把您加为好友</strong>
            <span class="label label-danger pull-right refuse" onclick="refuseRequest(this)">拒绝</span>
            <span class="label label-primary pull-right agree" onclick="passRequest(this)">同意</span>
        </div>

        {{--聊天消息的提示框--}}
        <div class="alert alert-success alert-dismissable chat-news-alert hide" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <a href="javascript:;" class="alert-link pull-right">查看</a>

            <h4></h4>
            <strong></strong>
        </div>

        @section('body')
        @show
    </div>
</div>

<!--添加好友的模态框-->
<div class="modal inmodal" id="search-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" onclick="hideModal()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">添加好友</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="username" placeholder="请输入用户名">
                <p class="text-danger text-center notice" style="margin-top:5px ;"></p>

                <div class="row search-result-block" style="display: none;">
                    <div class="col-lg-12">
                        <button class="btn btn-white pull-right make-friend-button" onclick="sendFriendRequest()">加为好友</button>
                        <div class="contact-box">
                            <a href="javascript:;">
                                <div class="col-sm-4">
                                    <div class="text-center">
                                        <img alt="image" class="user-avatar img-circle m-t-xs img-responsive" src="/img/a3.jpg">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <h4 class="search-result-username" data-id="" style="line-height: 22px;"></h4>
                                    <p class="user-motto">天王盖地虎，小鸡炖蘑菇</p>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <h3 class="text-center success-info" style="display: none;"></h3>

                <div class="modal-footer" style="border: 0;">
                    <button type="button" class="btn btn-white" onclick="hideModal()">取消</button>
                    <button type="button" class="btn btn-primary" onclick="searchUser()">确定</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/js/jquery-2.1.1.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.metisMenu.js"></script>
<script src="/js/jquery.slimscroll.min.js"></script>

<script src="/js/inspinia.js"></script>
<script>
    var ws;

    $(function () {
        var ws_url = "{{ config('app.socket_url') . ':' . config('app.socket_port') .'/'.session('userInfo')->username }}";
        ws = new WebSocket('ws://' + ws_url);

        ws.onopen = function (event) {
            console.log('服务器连接成功');
        };

        ws.onmessage = function (event) {
            try {
                var data = JSON.parse(event.data);
                switch (data.news_type) {
                    //  好友请求
                    case 10100001:
                        $('.system-news-alert .news-content').text(data.content);
                        $('.system-news-alert .refuse,.system-news-alert .agree').attr('data', data.send_by_id);
                        $('.system-news-alert').removeClass('hide').addClass('in');
                        setTimeout(function () {
                            $('.system-news-alert').removeClass('in').addClass('hide');
                        }, 10000);
                        break;
                    //    收到新的聊天信息
                    case 10100004:
                        if (window.location.pathname != '/chat/' + data.send_by_id) {
                            $('.chat-news-alert h4').html(data.send_by_username + ': ');
                            $('.chat-news-alert strong').html(data.content);
                            $('.chat-news-alert .alert-link').attr('href', '/chat/' + data.send_by_id);
                            $('.chat-news-alert').removeClass('hide').addClass('in');
                        } else {
                            var html = '<div class="chat-message left">' +
                                '<img class="message-avatar" src="/img/a4.jpg" alt="">' +
                                '<div class="message">' +
                                '<span class="message-content">' + data.content + '</span>' +
                                '</div>' +
                                '</div>';
                            $('.chat-discussion').append(html);
                            $('.chat-discussion').scrollTop($('.chat-discussion')[0].scrollHeight);
                        }
                        break;
                }

            } catch (e) {
                console.log('An error occured');
            }
        };

        ws.onerror = function (event) {
            $('.alert-danger strong').text('聊天服务器连接失败');
            $('.alert-danger').removeClass('hide').addClass('in');
        };
        getNews();
    });

    /**
     * 高亮侧边栏
     */
    function highlightMenu(url) {
        $('#side-menu').find('a[href="http://' + window.location.host + url + '"]').parent().addClass('active').siblings().removeClass('active');
    }

    /**
     * 获取消息列表
     */
    function getNews() {
        $.get("{{ route('news.index') }}", function (res) {
            if (res.code == 200) {
                if (res.data.list.length > 0) {
                    var html = '';
                    for (var i = 0; i < res.data.list.length; i++) {
                        html += (res.data.list[i].status == 1 ? '<li class="active">' : '<li>') +
                            '<a href="javascript:;" data-status="' + res.data.list[i].status + '" data-type="' + res.data.list[i].news_type + '" data="' + res.data.list[i].send_by + '" onclick="readNews(this)">' +
                            '<div><i class="fa fa-envelope fa-fw"></i> <span class="news-content">' + res.data.list[i].content +
                            '</span><span class="pull-right text-muted small">' + res.data.list[i].created_at + '</span>' +
                            '</div>' +
                            '</a></li>';
                    }
                } else {
                    var html = '<li>' +
                        '<a href="javascript:;">' +
                        '<div><i class="fa fa-envelope fa-fw"></i> 暂无消息</div' +
                        '></a>' +
                        '</li>';
                }
                if (res.data.unread) {
                    $('.news-num').text(res.data.unread);
                } else {
                    $('.news-num').text('');
                }
                $('.news-list').html(html);
            }
        }, 'json');
    }

    /**
     * 读消息
     */
    function readNews(node) {
        var obj = $(node);
        if (obj.attr('data-status') == 0) {
            //  判断是否是好友申请
            if (obj.attr('data-type') == 10100001) {
                $('.system-news-alert .news-content').text(obj.find('.news-content').text());
                $('.system-news-alert .refuse,.system-news-alert .agree').attr('data', obj.attr('data'));
                $('.system-news-alert').removeClass('hide').addClass('in');
            }
        }
    }

    /**
     * 用户查找功能
     */
    function searchUser() {
        var username = $('#username').val();
        if (username) {
            $.ajax({
                url: '/api/users/' + username,
                method: 'get',
                dataType: 'json',
                success: function (res) {
                    if (res.code == 200) {
                        res.data.avatar ? $('.user-avatar').attr('src', res.data.avatart) : '';
                        res.data.motto ? $('.user-motto').text(res.data.motto) : '';

                        if (res.data.can) {
                            $('.make-friend-button').show();
                        } else {
                            $('.make-friend-button').hide();
                        }

                        $('.search-result-username').text(res.data.username).attr('data-id', res.data.id);
                        $('.search-result-block').show();
                    } else {
                        $('#search-user .notice').text(res.message);
                    }
                }
            });
        }
    }

    /**
     * 发送好友请求
     */
    function sendFriendRequest() {
        $.post("{{ route('news.store') }}",
            {
                _token: '{{ csrf_token() }}',
                send_to_id: $('.search-result-username').attr('data-id'),
                news_type: 10100001
            }, function (res) {
                if (res.code == 200) {
                    ws.send(JSON.stringify({
                        send_by_id: res.data.send_by_id,
                        send_by_username: res.data.send_by_username,
                        send_to_id: res.data.send_to_id,
                        send_to_username: res.data.send_to_username,
                        content: res.data.content,
                        news_type: 10100001
                    }));
                    $('.search-result-block').hide();
                    $('.notice').text('');
                    $('.success-info').text('您的好友请求已发送').show();
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    $('.alert-danger strong').text(res.message);
                    $('.alert-danger').removeClass('hide').addClass('in');
                }
            }, 'json');
    }

    /**
     *  同意好友请求
     */
    function passRequest(node) {
        $.post("{{ route('news.process_request') }}", {
            _token: '{{ csrf_token() }}',
            send_by_id: $(node).attr('data'),
            news_type: 10100002
        }, function (res) {
            if (res.code == 200) {
                window.location.reload();
            } else {
                $('.alert-danger strong').text(res.message);
                $('.alert-danger').removeClass('hide').addClass('in');
            }
        }, 'json');
    }

    /**
     * 拒绝好友请求
     */
    function refuseRequest(node) {
        $.post("{{ route('news.process_request') }}", {
            _token: '{{ csrf_token() }}',
            send_by_id: $(node).attr('data'),
            news_type: 10100003
        }, function (res) {
            if (res.code == 200) {
                window.location.reload();
            } else {
                $('.alert-danger strong').text(res.message);
                $('.alert-danger').removeClass('hide').addClass('in');
            }
        }, 'json');
    }

    function hideModal() {
        $('#username').val('');
        $('.notice').text('');
        $('.search-result-block').hide();
        $('#search-user').modal('hide');
    }
</script>
@section('script')
@show

</body>

</html>