<!DOCTYPE html>
<html lang="en">
<head>
    @include('worker::elements.meta')
    @include('worker::elements.style')
    @yield('extra-css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('worker::elements.sidebar')
    <div class="content-wrapper">
       @yield('content')
    </div>
</div>
@include('worker::elements.footer')
<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>
@include('worker::elements.script')
@yield('scripts')
@yield('validation')
</body>
</html>
