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
    <img class="animation__shake" src="{{asset('static/images/logo.jpeg')}}" alt="AdminLTELogo" height="60" width="60">
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
                <a class="dropdown-item" href="{{route('admin.profile.edit')}}">
                    <i class="fas fa-info fa-sm fa-fw mr-2 text-gray-400"></i>
                    アカウント情報
                </a>
                <a class="dropdown-item" href="{{route('admin.change_password')}}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    パスワード変更
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.logout')}}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    ログアウト
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.project.index')}}" class="brand-link">
        <img src="{{asset('static/images/logo.jpeg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">発注図面</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img style="height: 2.1rem; object-fit: cover" src="{{!empty(auth('admins')->user()->avatar) ? \App\Helpers\Helpers::getUrlUploadFile(auth('admins')->user()->avatar) : asset('static/images/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info" >
                <a href="#" class="d-block">{{auth('admins')->user()->first_name}} {{auth('admins')->user()->last_name}}</a>
                <span style="color: #c2c7d0; font-size: 14px; ">管理者</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{route('admin.project.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            図面管理
                            <!-- <span class="right badge badge-danger">New</span>-->
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.worker.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            作業者管理
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.user.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            発注者管理
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.profile.edit')}}" class="nav-link">
                        <i class="nav-icon fas fa-users mr-2"></i>
                        <p>
                            アカウント情報
                        </p>
                    </a>
                    <!-- <span class="badge badge-info right">6</span>-->
                </li>
            </ul>
        </nav>
</aside>
