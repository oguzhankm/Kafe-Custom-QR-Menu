@extends('_layout.menu.default')
@section('pageTitle',$cafe->title)

@section('content')

    <div
        style="-webkit-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);"
        class="inner-container main center-element">
        <div class="card main">
            <div class="section pd-top-0px wf-section">
                <div class="image-wrapper small-cover"><img
                        src="{{ \Illuminate\Support\Facades\Storage::url($cafe->logo) }}"
                        loading="eager" sizes="(max-width: 767px) 100vw, (max-width: 991px) 93vw, 838px"
                        alt="Super Duper Burgers Hero - QRCode X Webflow template" class="image cover"/></div>
                <div class="container-default w-container">
                    <div class="mg-top--124px">
                        <div class="flex-horizontal justify-center mg-bottom-40px"><img
                                src="https://assets.website-files.com/61e0a7ab0e57e953835f3aeb/61e0d883c39341e91e57499b_icon-home-qrcode-template.svg"
                                loading="eager" width="70"
                                style="-webkit-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);"
                                id="w-node-_476490ff-8fc0-ac71-de36-3dabf02f3d0b-5c5f3aec"
                                data-w-id="476490ff-8fc0-ac71-de36-3dabf02f3d0b"
                                alt="Super Duper Burgers - QRCode X Webflow template"
                                class="avatar-circle _07 borders"/></div>
                        <div class="inner-container _710px center-element">
                            <div class="text-center "><h1>{{ $cafe->title }}</h1>
                                <p class="paragraph-large">
                                    {{ $cafe->description }}
                                </p>
                            </div>
                            <div class="buttons-row center mg-top-40px">
                                <div class="button-row-last">
                                    <a href="{{ route('cafe.menu',['cafe'=>$cafe->slug]) }}"
                                       class="btn-secondary w-button">Ürünler</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-default w-container">
                <div class="inner-container _710px center-element">
                    <div class="divider"></div>
                </div>
            </div>
            <div class="section wf-section">
                <div class="container-default w-container">
                    <div class="inner-container _710px center-element"><h2 class="text-center mg-bottom-32px">
                            Kategoriler</h2>
                        <div class="w-dyn-list">
                            <div role="list" class="grid-2-columns menu-categories w-dyn-items">
                                @foreach($categories as $category)
                                    <div role="listitem" class="w-dyn-item">
                                        <a href="{{ route('cafe.menu',['cafe'=>$cafe->slug]) }}"
                                           class="link-content menu-category w-inline-block">
                                            <div class="mg-bottom-24px">
                                                <div class="image-wrapper border-radius-26px"><img
                                                        src="{{ \Illuminate\Support\Facades\Storage::url($category->logo) }}"
                                                        loading="eager" alt="Breakfast" class="image cover"/></div>
                                            </div>
                                            <div class="inner-container _330px center-element">
                                                <div class="text-center"><h3
                                                        class="heading-h3-size">{{ $category->name }}</h3>
                                                    <div class="link-wrapper color-primary text-200 extra-bold">
                                                        <div class="link-text">Ürünlere göz at</div>
                                                        <div class="line-rounded-icon link-icon-right"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
