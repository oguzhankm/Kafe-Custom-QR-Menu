@extends('_layout.menu.default')

@section('headtags')
    <style>
        .tabActive {
            border-color: #ff7629;
            background-color: #ff7629;
            box-shadow: 0 0 0 0 rgba(19, 19, 19, 0.06);
            color: #fff;
        }
    </style>
@endsection

@section('foottags')
    <script>
        $(document).ready(function () {
            $('.categoryTab').on('click', function () {
                $('.categoryTab').removeClass('tabActive')
                $(this).addClass('tabActive')
                $('.tabBody').hide();
                $('.tabBody[data-cid="' + $(this).attr('href') + '"]').show();
            })
        })
    </script>
@endsection

@section('content')
    <div
        style="-webkit-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(0, 40px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0)"
        class="inner-container main center-element">
        <div class="card main mg-bottom-64px">
            <div class="section hero-default wf-section">
                <div class="container-default w-container">
                    <div class="inner-container _500px-mbl center-element">
                        <div class="inner-container _710px center-element">
                            <div class="mg-bottom-56px">
                                <div class="inner-container _625px center-element">
                                    <div class="mg-bottom-48px">
                                        <div class="inner-container _530px center-element">
                                            <div class="text-center">
                                                <h1 class="mg-bottom-16px">Menülerimize Göz At</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-dyn-list">
                                        <div role="list" class="grid-4-columns gap-18px categories w-dyn-items">
                                            @foreach($categories as $key => $category)
                                                <div role="listitem"
                                                     class="flex-horizontal flex-vertical-mbl w-dyn-item">
                                                    <a
                                                        href="#{{$category->slug}}"
                                                        class="badge-secondary category w-button categoryTab @if($key === 0) tabActive @endif">{{ $category->name }}</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-dyn-list">

                                @foreach($categories as $key => $category)
                                    <div
                                        style="{{ $key !== 0 ? "display: none" : "" }}"
                                        role="list"
                                        data-cid="#{{$category->slug}}"
                                        class="tabBody grid-1-column gap-row-24px gap-row-80px-mbl w-dyn-items"
                                    >
                                        @foreach($category->products as $product)
                                            <div role="listitem" class="w-dyn-item">
                                                <a href="{{ route('cafe.product',['cafe'=>$cafe->slug,'productSlug'=>$product->slug]) }}"
                                                   class="link-content menu w-inline-block">
                                                    <div class="flex-horizontal align-center flex-vertical-mbl">
                                                        <div class="mg-right-35px mg-right-0px-mbl mg-bottom-44px-mbl">
                                                            <div class="inner-container _240px max-w-100-mbl">
                                                                <div class="image-wrapper border-radius-16px"><img
                                                                        src="{{ \Illuminate\Support\Facades\Storage::url($product->photo) }}"
                                                                        loading="eager" alt="{{ $product->name }}"
                                                                        class="image cover"/></div>
                                                            </div>
                                                        </div>
                                                        <div class="inner-container _430px max-w-100-mbl">
                                                            <div class="mg-bottom-11px">
                                                                <div
                                                                    class="flex-horizontal space-between align-center children-wrap">
                                                                    <div class="mg-right-16px"><h2
                                                                            class="heading-h3-size mg-bottom-0">{{ $product->name }}</h2>
                                                                    </div>
                                                                    <div class="heading-h5-size">
                                                                        {{ $product->price }}₺
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mg-bottom-32px mg-bottom-18px-mbl">{{ $product->description }}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                                <a href="{{ \Illuminate\Support\Facades\URL::previous()  }}">
                                    <div class="inner-container _330px center-element mg-top-56px">
                                        <div class="link-wrapper color-primary text-200 extra-bold">
                                            <div style="transform: rotate(180deg)"
                                                 class="line-rounded-icon link-icon-right">
                                            </div>
                                            <div class="link-text">Anasayfaya geri dön</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
