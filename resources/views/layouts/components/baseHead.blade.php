<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ getAppName() }}@yield('addTitle')</title>

@include('layouts.components.baseStyle')
@include('layouts.components.baseScript')
