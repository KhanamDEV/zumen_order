<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin::elements.meta')
    @include('admin::elements.style')
    @yield('extra-css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin::elements.sidebar')
    <div class="content-wrapper">
       @yield('content')
    </div>
</div>
@include('admin::elements.footer')
<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>
@include('admin::elements.script')
@yield('scripts')
@yield('validation')
</body>
</html>
