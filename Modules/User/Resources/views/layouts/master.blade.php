<!DOCTYPE html>
<html lang="en">
<head>
    @include('user::elements.meta')
    @include('user::elements.style')
    @yield('extra-css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('user::elements.sidebar')
    <div class="content-wrapper">
       @yield('content')
    </div>
</div>
@include('user::elements.footer')
<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>
@include('user::elements.script')
@yield('scripts')
@yield('validation')
</body>
</html>
