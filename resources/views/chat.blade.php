@extends('public.header')

@section('body')
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chat-discussion" style="height: 530px;">
                                    <div class="chat-message left">
                                        <img class="message-avatar" src="/img/a1.jpg" alt="">
                                        <div class="message">
                                            <a class="message-author" href="#"> Michael Smith </a>
                                            <span class="message-date"> Mon Jan 26 2015 - 18:39:23 </span>
                                            <span class="message-content">
    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
    </span>
                                        </div>
                                    </div>
                                    <div class="chat-message right">
                                        <img class="message-avatar" src="/img/a4.jpg" alt="">
                                        <div class="message">
                                            <a class="message-author" href="#"> Karl Jordan </a>
                                            <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
    Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover.
    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="chat-message-form">
                                    <div class="form-group">
    <textarea class="form-control message-input" id="message"
              style="resize: none;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;border:1px solid lightblue ;"></textarea>
                                        <button class="btn btn-info pull-right submit" style="position:relative;top: -35px;">发送</button>
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
