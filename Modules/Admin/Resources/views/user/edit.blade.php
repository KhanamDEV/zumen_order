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
                        <img class="profile-user-img img-responsive img-circle" src="{{!empty(@$data['user']->avatar) ? \App\Helpers\Helpers::getUrlUploadFile($data['user']->avatar) : asset('static/images/user2-160x160.jpg')}} " alt="User profile picture">

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
                                    <input type="text" class="form-control" id="inputName" placeholder="" value="{{@$data['user']->first_name}}" name="first_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">名 <b style="color: red;">*</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" placeholder="" value="{{@$data['user']->last_name}}" name="last_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">ユーザー名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id=""  value="{{@$data['user']->email}}" name="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">電話番号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" placeholder="" name="phone_number" value="{{@$data['user']->phone_number}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" placeholder="" name="password" >
                                </div>
                            </div>
                            <div class="group-button-end justify-content-start" >
                                <button type="submit" class="btn btn-primary button-width"><i class="fa fa-save"></i> 保存</button>
                                <a href="{{route('admin.user.delete', ['id' => $data['user']->id])}}"  class="btn btn-danger button-width"> 削除</a>
                                <a href="{{route('admin.user.index')}}"  class="btn button-width btn-secondary"> 戻る</a>
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
    {!! JsValidator::formRequest('Modules\Admin\Http\Requests\UpdateUserRequest', '#form-update') !!}
@endsection
@section('extra-css')
    <style>
        .profile-user-img{height: 200px; object-fit: cover; width: 200px}
    </style>
@endsection
