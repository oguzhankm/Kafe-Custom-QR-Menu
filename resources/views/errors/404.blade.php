<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <title>Not Found</title>
    <link href="{{ asset('assets/menu/style.css') }}"
          rel="stylesheet" type="text/css"/>
</head>
<body class="page-wrapper bg-neutral-200 bg-neutral-100-mbl">
<div data-w-id="6983c076-5c5c-5215-6399-203b5a3864a0" data-animation="default" data-collapse="medium"
     data-duration="400" data-easing="ease" data-easing2="ease" role="banner" class="header-wrapper w-nav">
    <div class="container-default w-container">
        <div class="header-content-wrapper">
            <div class="header-middle"><a href="{{ route('index') }}" class="header-logo-link w-nav-brand"><img
                        src="https://assets.website-files.com/61e0a7ab0e57e953835f3aeb/61e0c64d181c617da143ab49_logo-qrcode-template.svg"
                        loading="eager" alt="Burgers Logo - QRCode X Webflow template" class="header-logo"/></a></div>
        </div>
    </div>
</div>
<div class="utility-page-wrap">
    <div data-w-id="bc75cc10-6d6a-d111-5352-e6a343aa630b"
         style="-webkit-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);"
         class="inner-container main center-element">
        <div class="card main">
            <div class="section wf-section">
                <div class="container-default w-container">
                    <div class="inner-container _500px-mbl center-element">
                        <div class="inner-container _710px center-element">
                            <div class="utility-page-content w-form">
                                <div class="_404-not-found">404</div>
                                <h1 class="heading-h2-size mg-bottom-16px">Sayfa bulunamadı!</h1>
                                <div class="buttons-row center"><a href="{{ route('index') }}" class="btn-primary w-button">Ana Sayfa</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('_layout.menu.include.foot')
</body>
</html>
