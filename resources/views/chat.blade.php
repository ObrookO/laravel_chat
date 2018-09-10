@extends('public.header')

@section('style')
    <style>
        #message {
            height: 140px !important;
            overflow: auto;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            border: 1px solid lightblue;
        }

        .submit {
            position: relative;
            top: -35px;
        }

        .emoticons {
            width: 525px;
        }

        .emoticons .publisher a {
            font-size: 20px;
            font-weight: bold;
            color: #666;
        }

        .emoticons .result img {
            vertical-align: middle;
        }

        .widget-layer {
            position: relative;
            width: 410px;
            margin-top: 8px;
            background: #fff;
            border: 1px solid #dbdbdb;
            border-radius: 2px;
        }

        .widget-layer:before {
            position: absolute;
            bottom: -16px;
            display: block;
            content: '';
            width: 0;
            height: 0;
            border: 8px solid transparent;
            border-top-color: #dbdbdb;
        }

        .widget-layer:after {
            position: absolute;
            bottom: -15px;
            display: block;
            content: '';
            width: 0;
            height: 0;
            border: 8px solid transparent;
            border-top-color: #f0f0f0;
        }

        .widget-layer .widget-tool {
            height: 28px;
            background: #f0f0f0;
        }

        .widget-layer .widget-close {
            float: right;
            width: 28px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            font-family: Arial;
        }

        .widget-layer ul {
            width: 372px;
            margin: 0 auto;
            padding: 15px 5px 20px;
            overflow: hidden;
        }

        .widget-layer li {
            position: relative;
            z-index: 8;
            float: left;
            width: 30px;
            height: 30px;
            padding: 4px;
            margin-left: -1px;
            margin-top: -1px;
            border: 1px solid #e8e8e8;
            cursor: pointer;
            list-style: none;
        }

        .widget-layer li:hover {
            z-index: 9;
            border-color: #eb7350;
        }

    </style>
@endsection
@section('body')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>正在和 <strong>{{ $username }}</strong> 聊天</h2>
        </div>
    </div>

    <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chat-discussion" style="height: 420px;">
                                    @forelse($records as $k=>$v)
                                        @if($v->news_from == $user_id)
                                            <div class="chat-message left">
                                                <img class="message-avatar" src="{{ $avatar ? $avatar : '/img/a3.jpg' }}" alt="">
                                                <div class="message">
                                                    <span class="message-content">{!! $v->message  !!}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="chat-message right">
                                                <img class="message-avatar" src="{{ session('userInfo')->avatar ? session('userInfo')->avatar : '/img/a1.jpg' }}" alt="">
                                                <div class="message" style="text-align: left;">
                                                    <span class="message-content">{!! $v->message  !!}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="chat-message-form">
                                    <div class="form-group">
                                        <div class="emoticons">
                                            <div class="publisher">
                                                <a href="javascript:;">
                                                    <i class="fa fa-smile-o trigger"></i>
                                                </a>
                                                <a href="javascript:;" onclick="$('#image').click()">
                                                    <i class="fa fa-image"></i>
                                                </a>
                                                <input type="file" name="" id="image" onchange="uploadImg(this)" accept="image/jpeg,image/png,image/gif" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="form-control message-input" id="message" contenteditable></div>
                                        <button class="btn btn-info pull-right submit" onclick="sendNews()">发送</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/jquery.emoticons.js?v={{ time() }}"></script>
    <script>
        $(function () {
            highlightMenu('/friends');
            //  表情控制
            $.emoticons({
                'activeCls': 'trigger-active',
                'path': '/emoij/',
            }, function (api) {
                $('.widget-panel').on('click', 'li', function () {
                    $('#message').insertText("<img src='" + $(this).children('img').attr('src') + "'>");
                    $('.widget-close').click();
                });
            });
            //  滚动条停留在最底端
            $('.chat-discussion').scrollTop($('.chat-discussion')[0].scrollHeight);
            //  回车发送消息
            $('#message').keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    sendNews();
                }
            });

            //  在光标位置插入内容
            $.fn.insertText = function (text) {
                var obj = $(this)[0];
                var range, node;
                if (!obj.hasfocus) {
                    obj.focus();
                }

                if (document.selection && document.selection.createRange) {
                    this.focus();
                    document.selection.createRange().pasteHTML(text);
                    this.focus();
                } else if (window.getSelection && window.getSelection().getRangeAt) {
                    range = window.getSelection().getRangeAt(0);
                    range.collapse(false);
                    node = range.createContextualFragment(text);
                    var c = node.lastChild;
                    range.insertNode(node);
                    if (c) {
                        range.setEndAfter(c);
                        range.setStartAfter(c)
                    }
                    var j = window.getSelection();
                    j.removeAllRanges();
                    j.addRange(range);
                    this.focus();
                }
            }
        });

        /**
         * 上传聊天图片
         */
        function uploadImg(node) {
            if (node.files.length) {
                var fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fd.append('image', node.files[0]);
                $.ajax({
                    url: "{{ route('chat.upload') }}",
                    method: 'post',
                    dataType: 'json',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        if (res.code == 200) {
                            $('#message').insertText('<img height="80" src="' + res.data + '">');
                        } else {
                            $('#image').val('');
                            $('.alert-danger strong').text(res.message);
                            $('.alert-danger').removeClass('hide').addClass('in');
                            setTimeout(function () {
                                $('.alert-danger').removeClass('in').addClass('hide');
                            }, 2000);
                        }
                    }
                });
            }
        }

        /**
         * 发送消息
         */
        function sendNews() {
            var message = $('#message').html();

            $.post('/chat/save', {
                _token: '{{ csrf_token() }}',
                send_to_id: '{{ $user_id }}',
                data: message,
                content_type: 'text',
                news_type: 10100004
            }, function (res) {
                if (res.code == 200) {
                    ws.send(JSON.stringify({
                        send_to_id: res.data.send_to_id,
                        send_to_username: res.data.send_to_username,
                        send_by_id: res.data.send_by_id,
                        send_by_username: res.data.send_by_username,
                        send_by_user_avatar: res.data.send_by_user_avatar,
                        content: message,
                        news_type: 10100004
                    }));
                    var html = '<div class="chat-message right">' +
                        '<img class="message-avatar" src="{{ session('userInfo')->avatar ? session('userInfo')->avatar : '/img/a3.jpg' }}" alt="">' +
                        '<div class="message" style="text-align: left;">' +
                        '<span class="message-content">' + message + '</span>' +
                        '</div>' +
                        '</div>';

                    $('.chat-discussion').append(html);
                    $('.chat-discussion').scrollTop($('.chat-discussion')[0].scrollHeight);
                    $('#message').html('');
                    $('#image').val('');
                } else {
                    $('.alert-danger strong').text(res.message);
                    $('.alert-danger').removeClass('hide').addClass('in');
                    setTimeout(function () {
                        $('.alert-danger').removeClass('in').addClass('hide');
                    }, 2000);
                }
            }, 'json');
        }
    </script>
@endsection