@extends('public.header')

@section('style')
    <style>
        #plus {
            position: fixed;
            right: 10px;
            bottom: 10px;
            cursor: pointer;
        }
    </style>

@endsection

@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            @if(count($my_friends) > 0)
                @foreach($my_friends as $k=>$friend)
                    <div class="col-lg-4">
                        <div class="contact-box">
                            <a href="/chat/{{ $friend->id }}">
                                <div class="col-sm-4">
                                    <div class="text-center">
                                        <img alt="image" class="img-circle m-t-xs img-responsive" src="{{ !empty($friend->avatar) ? $friend->avatar: '/img/a3.jpg'}}">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <h3><strong>{{ $friend->username }}</strong></h3>
                                    <p>{{ !empty($friend->motto) ? $friend->motto : '天王盖地虎，小鸡炖蘑菇' }}</p>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <h3>
                    还没有好友？马上去 <a href="javascript:;" onclick="document.getElementById('plus').click()">添加</a>
                </h3>
            @endif
        </div>
    </div>
    <img class="img-circle" id="plus" src="/img/small_plus.png" alt="plus" data-toggle="modal" data-target="#search-user">

@endsection
