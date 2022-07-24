<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 10:25
 */
?>
@extends('user::layouts.layout_login')
@section('title') ログイン @endsection
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <b>ログイン</b>
        </div>
        <div class="card-body pt-0">
            <p class="login-box-msg pb-0 mb-4" style="border-bottom: 1px solid #ccc">
                <img class="w-100" src="{{asset('static/images/order_login.png')}}" alt="">
            </p>

            <form action="" method="post" id="form-login">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <input type="email" value="{{old('email')}}" name="email" class="form-control" placeholder="ユーザー名">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input type="password"  name="password" class="form-control" placeholder="パスワード">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                </div>
                @if($errors->has('authenticate'))
                <div class="alert alert-danger" role="alert">
                    {{$errors->first('authenticate')}}
                </div>
                @endif
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">
                                ログインしたままにする
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">ログイン</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('validation')
    {!! JsValidator::formRequest('Modules\User\Http\Requests\UserLoginRequest', '#form-login') !!}
@endsection
