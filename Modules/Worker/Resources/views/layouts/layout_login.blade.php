<?php
/**
 * Created by PhpStorm
 * worker: Kha Nam
 * Date: 21/05/2022
 * Time: 10:11
 */
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    @include('worker::elements.meta')
   @include('worker::elements.style')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    @yield('content')
    @include('worker::elements.script')
    @yield('validation')
</body>
</html>

