@extends('public.header')

@section('style')
    <style>
        #message {
            resize: none;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            border: 1px solid lightblue;
        }

        .submit {
            position: relative;
            top: -35px;
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
                                <div class="chat-discussion" style="height: 450px;">
                                    @forelse($records as $k=>$v)
                                        @if($v->news_from == $user_id)
                                            <div class="chat-message left">
                                                <img class="message-avatar" src="/img/a4.jpg" alt="">
                                                <div class="message">
                                                    <span class="message-content">{{ $v->message }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="chat-message right">
                                                <img class="message-avatar" src="/img/a1.jpg" alt="">
                                                <div class="message" style="text-align: left;">
                                                    <span class="message-content">{{ $v->message }}</span>
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
                                        <textarea class="form-control message-input" id="message" autofocus></textarea>
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
    <script>
        $(function () {
            $('.chat-discussion').scrollTop($('.chat-discussion')[0].scrollHeight);
            $('#message').keyup(function (event) {
                if (event.keyCode == 13) {
                    sendNews();
                }
            });
        });

        function sendNews() {
            var message = $('#message').val();

            $('#message').val('');
            $.post('/chat/save', {
                _token: '{{ csrf_token() }}',
                send_to_id: '{{ $user_id }}',
                data: message,
                news_type: 10100004
            }, function (res) {
                if (res.code == 200) {
                    ws.send(JSON.stringify({
                        send_to_id: res.data.send_to_id,
                        send_to_username: res.data.send_to_username,
                        send_by_id: res.data.send_by_id,
                        send_by_username: res.data.send_by_username,
                        content: message,
                        news_type: 10100004
                    }));
                    var html = '<div class="chat-message right">' +
                        '<img class="message-avatar" src="/img/a1.jpg" alt="">' +
                        '<div class="message" style="text-align: left;">' +
                        '<span class="message-content">' + message + '</span>' +
                        '</div>' +
                        '</div>';
                    $('.chat-discussion').append(html);
                    $('.chat-discussion').scrollTop($('.chat-discussion')[0].scrollHeight);
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