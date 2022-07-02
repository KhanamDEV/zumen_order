<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 10:11
 */
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    @include('user::elements.meta')
   @include('user::elements.style')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    @yield('content')
    @include('user::elements.script')
    @yield('validation')
</body>
</html>

