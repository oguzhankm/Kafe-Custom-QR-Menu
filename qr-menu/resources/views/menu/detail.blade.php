@extends('_layout.menu.default')

@section('content')
    <div class="inner-container main center-element">
        <div class="card main mg-bottom-64px">
            <div class="image-wrapper position-relative">
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::url($product->photo) }}"
                    loading="eager"
                    sizes="(max-width: 767px) 100vw, (max-width: 991px) 93vw, 838px"
                    class="image cover"
                />
                <div class="position-absolute bottom">
                    <div class="container-default w-container">
                        <div class="mg-bottom-64px">
                            <div class="inner-container _500px-mbl center-element">
                                <div class="inner-container _710px center-element">
                                    <div class="badge-secondary large">
                                        <div class="text-300 extra-bold color-neutral-800">{{ $product->price }} ₺</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section pd-top-64px wf-section">
                <div class="container-default w-container">
                    <div class="inner-container _500px-mbl center-element">
                        <div class="inner-container _710px center-element">
                            <div class="flex-horizontal space-between align-center flex-vertical-mbl">
                                <div class="mg-bottom-35px-mbl"><h1 class="heading-h2-size">{{ $product->name }}</h1>
                                    <div class="display-block-mbl">
                                        <div class="inner-container _358px">
                                            <p class="mg-bottom-28px">{{ $product->description }}</p>
                                        </div>
                                        <a href="{{ \Illuminate\Support\Facades\URL::previous()  }}">
                                            <div class="inner-container _330px center-element">
                                                <div class="link-wrapper color-primary text-200 extra-bold">
                                                    <div style="transform: rotate(180deg)" class="line-rounded-icon link-icon-right"></div>
                                                    <div class="link-text">Menüye geri dön</div>
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
        </div>
    </div>

@endsection
