<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('pageTitle','Yönetim Paneli')</title>
    @include('_layout.back.include.head')
    @yield('headtags')
</head>
<body id="page-top">
<div id="wrapper">
    @include('_layout.back.include.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('_layout.back.include.topbar')
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        @include('_layout.back.include.footer')
    </div>
</div>
@include('_layout.back.include.foot')
@yield('foottags')
</body>
</html>
