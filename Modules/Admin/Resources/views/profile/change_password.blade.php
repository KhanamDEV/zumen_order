<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 10:25
 */
?>
@extends('user::layouts.layout_login')
@section('title') パスワードを変更する @endsection
@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">パスワードを変更する</p>
            <form action="" method="post" id="form-change-password">
                @csrf
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="パスワード">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="パスワード (確認用)">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">変更</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('validation')
    {!! JsValidator::formRequest('Modules\Admin\Http\Requests\ChangePasswordRequest', '#form-change-password') !!}
@endsection
