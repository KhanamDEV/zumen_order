<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 10:34
 */
?>
@extends('admin::layouts.master')
@section('content')
    <section class="content-header">
        <h1>
            アカウント情報
        </h1>
        <ol class="breadcrumb">
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile text-center">
                        <img class="profile-user-img img-responsive d-block img-circle" src="{{!empty(@$data['admin']->avatar) ? \App\Helpers\Helpers::getUrlUploadFile($data['admin']->avatar) : asset('static/images/user2-160x160.jpg')}} " alt="User profile picture">

                        <a href="{{route('admin.change_password')}}" class="btn btn-info mt-5">
                            パスワード変更
                        </a>

                        <h3 class="profile-username text-center"></h3>

                        <p class="text-muted text-center">

                        </p>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">アカウント情報変更</a></li>
                    </ul>

                    <div class="active tab-pane" id="settings">
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="form-update">
                            @csrf
                            <div class="form-group">
                                <label for="avatar" class="col-sm-2 control-label">写真</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="avatar" name="avatar">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">姓<b style="color: red;">*</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="" value="{{@$data['admin']->first_name}}" name="first_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">名 <b style="color: red;">*</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" placeholder="" value="{{@$data['admin']->last_name}}" name="last_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">ユーザー名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id=""  value="{{@$data['admin']->email}}" name="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">電話番号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" placeholder="" name="phone_number" value="{{@$data['admin']->phone_number}}">
                                </div>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="" class="col-sm-2 control-label">パスワード</label>--}}
{{--                                <div class="col-sm-10">--}}
{{--                                    <input type="text" class="form-control" id="" placeholder="" name="password" value="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> 保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </section>

@endsection
@section('validation')
    {!! JsValidator::formRequest('Modules\Admin\Http\Requests\UpdateProfileRequest', '#form-update') !!}
@endsection
@section('extra-css')
    <style>
        .profile-user-img{height: 200px; object-fit: cover; width: 200px}
    </style>
@endsection
