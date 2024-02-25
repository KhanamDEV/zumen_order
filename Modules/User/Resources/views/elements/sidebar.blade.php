<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 10:43
 */
?>
<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('static/images/logo.png')}}" alt="AdminLTELogo" height="60" width="60">
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle"　 href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                <i class="fas fa-th-large"></i>
            </a>

            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('user.profile.edit')}}">
                    <i class="fas fa-info fa-sm fa-fw mr-2 text-gray-400"></i>
                    アカウント情報
                </a>
                <a class="dropdown-item" href="{{route('user.change_password')}}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    パスワード変更
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('user.logout')}}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    ログアウト
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #283d60">
    <!-- Brand Logo -->
    <a href="{{route('user.project.index_no_merge')}}" class="brand-link">
        <img src="{{asset('static/images/logo.jpeg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">発注図面</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img style="height: 2.1rem; object-fit: cover" src="{{!empty(auth('users')->user()->avatar) ? \App\Helpers\Helpers::getUrlUploadFile(auth('users')->user()->avatar) : asset('static/images/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info" >
                <a href="#" class="d-block">{{auth('users')->user()->first_name}} {{auth('users')->user()->last_name}}</a>
                <span style="color: #c2c7d0; font-size: 14px; ">発注者</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item @if(\Request::routeIs('user.project.index*')) menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            <span class="menu-click">マイ図面</span>
                            <!-- <span class="right badge badge-danger">New</span>-->
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: @if(\Request::routeIs('user.project.index*')) block @else none  @endif ;">
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{route('user.project.index')}}" class="nav-link @if(\Request::routeIs('user.project.index')) active @endif">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>図面毎</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="nav-item">
                            <a href="{{route('user.project.index_no_merge')}}" class="nav-link @if(\Request::routeIs('user.project.index_no_merge')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ALL</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.project.index_mark')}}" class="nav-link @if(\Request::routeIs('user.project.index_mark')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>トレース</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.project.all')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            発注図面一覧
                            <!-- <span class="right badge badge-danger">New</span>-->
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                <li class="nav-item">
                    <a href="{{route('user.profile.edit')}}" class="nav-link">
                        <i class="nav-icon fas fa-users mr-2"></i>
                        <p>
                            アカウント情報

                        </p>
                    </a>
                    <!-- <span class="badge badge-info right">6</span>-->
                </li>
                <li class="nav-item">
                    <a href="{{route('user.logout')}}" class="nav-link">
                        <i class="fas fa-sign-out-alt  nav-icon mr-2 "></i>
                        <p>
                            ログアウト
                        </p>
                    </a>
                    <!-- <span class="badge badge-info right">6</span>-->
                </li>
            </ul>
        </nav>
    </div>
</aside>
