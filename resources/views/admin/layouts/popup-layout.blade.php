<!DOCTYPE html>
<html lang="ko">
<head>
    @include('admin.layouts.components.baseHead')
</head>
<body>
<div id="popup-wrap">
    <div style="padding: 35px;">
        @yield('contents')
    </div>
</div>

@include('admin.layouts.components.spinner')

{{--addScript--}}
@yield('addScript')
</body>
</html>
