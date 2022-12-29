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
            会社情報
        </h1>
        <ol class="breadcrumb">
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <!-- /.box -->
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
{{--                    <ul class="nav nav-tabs">--}}
{{--                        <li class="active"><a href="#settings" data-toggle="tab">アカウント情報変更</a></li>--}}
{{--                    </ul>--}}

                    <div class="active tab-pane" id="settings">
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="form-create">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">会社名<b style="color: red;">*</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="short_name" class="col-sm-2 control-label">略名<b style="color: red;">*</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="short_name" name="short_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label">住所<b style="color: red;">*</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" placeholder=""  name="address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone_number" class="col-sm-2 control-label">電話番号 <b style="color: red;">*</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" placeholder="" name="phone_number">
                                </div>
                            </div>
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
    {!! JsValidator::formRequest('Modules\Admin\Http\Requests\CreateCompanyRequest', '#form-create') !!}
@endsection
@section('extra-css')
    <style>
        .profile-user-img{height: 200px; object-fit: cover; width: 200px}
    </style>
@endsection
