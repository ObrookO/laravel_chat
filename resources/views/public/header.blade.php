<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>S、L 聊天系统| 主页</title>
    <link rel="icon" href="/chat.ico" type="image/x-icon">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <style>
        #news .modal-header {
            padding-top: 10px;
            padding-bottom: 10px;
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
                <li class="active">
                    <a href="/"><i class="fa fa-user"></i> <span class="nav-label">好友</span></a>
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
                            @if(!empty($unread))
                                <span class="label label-primary news-num">{{ $unread }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-alerts news-list">
                            @if(count($news) > 0)
                                @foreach($news as $K=>$item)
                                    <li class="@if($item->status) active @endif">
                                        <a href="javascript:;" onclick="readNews(this)" data-id="{{ $item->id }}" data-status="{{ $item->status }}"
                                           data-type="{{ $item->news_type }}">
                                            <p class="news-content" style="display: none;">{{ $item->content }}</p>
                                            <div>
                                                <i class="fa fa-envelope fa-fw"></i> {{ $item->title }}
                                                <span class="pull-right text-muted small">{{ $item->created_at }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <a href="javascript:;">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> 暂无消息
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li>
                        <a href="/logout">
                            <i class="fa fa-sign-out"></i> 退出
                        </a>
                    </li>
                </ul>
            </nav>
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

<!--系统消息的模态框-->
<div class="modal inmodal fade" id="news" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <p class="modal-title">系统消息</p>
            </div>
            <div class="modal-body text-center">
                <h3 class="news-content"></h3>
                <div class="form-group friend-request-buttons" style="display: none;">
                    <button class="btn btn-primary" onclick="passRequest()">同意</button>
                    <button class="btn btn-danger" onclick="refuseRequest()">拒绝</button>
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
        var ws_url = "{{ env('SOCKET_URL') . ':' . env('SOCKET_PORT') .'/'.session('userInfo')->username }}";
        ws = new WebSocket('ws://' + ws_url);

        ws.onopen = function (event) {
            console.log('服务器连接成功');
        };

        ws.onmessage = function (event) {
            console.log(event.data);
            try {
                var data = JSON.parse(event.data);
                if (data.news_type == 10100001) {
                    $('#news .news-content').html(data.content);
                    $('.friend-request-buttons').show();
                    $('#news').modal();
                }
            } catch (e) {
                console.log('An error occured');
            }
        };

        ws.onerror = function (event) {
            alert('服务器连接失败');
            window.location.reload();
        };
    });

    function readNews(node) {
        var obj = $(node);
        if (obj.attr('data-status') == 0) {
            //  判断是否是好友申请
            if (obj.attr('data-type') == 10100001) {
                $('#news .modal-body .news-content').html(obj.children('.news-content').text());
                $('#news .friend-request-buttons').show();
                $('#news').modal();
            } else {
                $.ajax({
                    url: '/api/news/read/' + obj.attr('data-id'),
                    method: 'get',
                    dataType: 'json',
                    success: function (res) {
                        window.location.reload();
                    },
                    error: function (xhr, textStatus, e) {

                    }
                });
            }
        } else {
            window.location.reload();
        }
    }

    /**
     * 用户查找功能
     */
    function searchUser() {
        var username = $('#username').val();
        if (username) {
            $.ajax({
                url: '/api/friends/' + username,
                method: 'get',
                dataType: 'json',
                success: function (res) {
                    if (res.code == 200) {
                        res.data.avatar ? $('.user-avatar').attr('src', res.data.avatart) : '';
                        res.data.motto ? $('.user-motto').text(res.data.motto) : '';
                        if ("{{ session('userInfo')->username }}" == res.data.username) {
                            $('.make-friend-button').hide();
                        } else {
                            $('.make-friend-button').show();
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
        $.post('/api/news',
            {
                _token: '{{ csrf_token() }}',
                send_to: $('.search-result-username').attr('data-id'),
                news_type: 10100001
            }, function (res) {
                if (res.code == 200) {
                    ws.send(JSON.stringify({send_to: $('.search-result-username').text(), content: res.data, news_type: 10100001}));
                    $('.search-result-block').hide();
                    $('.notice').text('');
                    $('.success-info').text('您的好友请求已发送').show();
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert(res.message);
                    window.location.reload();
                }
            }, 'json');
    }

    /**
     *  同意好友请求
     */
    function passRequest() {
        $.post('/api/news/process', {
            _token: '{{ csrf_token() }}',
            send_by: $('#news .modal-body .request-from').attr('data-id'),
            news_type: 10100002
        }, function (res) {
            if (res.code == 200) {
                window.location.reload();
            } else {
                alert(res.message);
            }
        }, 'json');
    }

    /**
     * 拒绝好友请求
     */
    function refuseRequest() {
        $.post('/api/news/process', {
            _token: '{{ csrf_token() }}',
            send_by: $('#news .modal-body .request-from').attr('data-id'),
            news_type: 10100003
        }, function (res) {
            if (res.code == 200) {
                window.location.reload();
            } else {
                alert(res.message);
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