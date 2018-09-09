@extends('public.header')

@section('style')
    <style>
        .preview-container {
            display: none;
        }

        .preview-container .img-preview {
            border: 5px solid #e8e8e8;
            border-radius: 5px;
        }

        #avatar_file {
            display: none;
        }
    </style>
@endsection

@section('body')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>个人信息</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-2">
                                <img src="{{ session('userInfo')->avatar ? session('userInfo')->avatar :'/img/a3.jpg' }}" width="120" alt="" class="img-rounded">
                            </div>
                            <div class="col-lg-2 preview-container">
                                <img src="" alt="" height="150" class="img-preview">
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-info" onclick="$('#avatar_file').click()"><i class="fa fa-upload"></i> 上传头像</button>
                                <input type="file" name="" id="avatar_file" accept="image/jpeg,image/png,image/gif" onchange="uploadImg(this)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-8">
                                <form id="show-form" action="{{ route('users.update',['id'=>session('userInfo')->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="avatar_url" id="avatar_url">
                                    <div class="form-group">
                                        <label for="username" class="control-label">用户名</label>
                                        <input type="text" class="form-control" name="username" value="{{ $user['username'] }}" placeholder="请输入用户名">
                                    </div>
                                    <div class="form-group">
                                        <label for="motto" class="control-label">座右铭</label>
                                        <textarea name="motto" id="" cols="30" rows="5" class="form-control" style="resize: none;" placeholder="说点什么吧。。。">{{ $user['motto'] }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <p class="text-danger error-msg"></p>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-info" onclick="submitForm()">提交</button>
                                    </div>
                                </form>
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
        function uploadImg(node) {
            if (node.files.length) {
                var fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fd.append('avatar', node.files[0]);

                $.ajax({
                    url: "{{ route('users.avatar') }}",
                    method: 'post',
                    dataType: 'json',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        if (res.code == 200) {
                            $('#avatar_url').val(res.data);
                            $('.preview-container .img-preview').attr('src', res.data);
                            $('.preview-container').show();
                        } else {
                            alert(res.message);
                        }
                    }
                });
            }
        }

        function submitForm() {
            $.ajax({
                url: $('#show-form').attr('action'),
                method: 'post',
                dataType: 'json',
                data: $('#show-form').serialize(),
                success: function (res) {
                    if (res.code == 200) {
                        window.location.reload();
                    } else {
                        $('.error-msg').text(res.message);
                    }
                },
                error: function (xhr, textStatus, exception) {
                    if (xhr.status == 422) {
                        var error = xhr.responseJSON.errors.username[0];
                        $('.error-msg').text(error);
                    }
                }
            });
        }
    </script>
@endsection