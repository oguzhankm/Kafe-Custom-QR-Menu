<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8"/>
    <title>@yield('pageTitle','Anasayfa')</title>
    <link href="{{ asset('assets/menu/style.css') }}"
          rel="stylesheet" type="text/css"/>
    @yield('headtags')
</head>
<body class="bg-neutral-200 bg-neutral-100-mbl">
<div class="page-wrapper">
    @yield('content')
</div>
@include('_layout.menu.include.foot')
@yield('foottags')
</body>
</html>
