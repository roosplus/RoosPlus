@extends('admin.layout.default')
@section('content')
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-12">
            <h5 class="pages-title fs-2">{{ trans('labels.share') }}</h5>
            @include('admin.layout.breadcrumb')
        </div>
    </div>

    <div class="col-12 mt-3 mb-7">
        <div class="card border-0 box-shadow">
            <div class="card-body">
                <div class="card-block text-center">
                    @php
                        $isMob = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile'));
                    @endphp
                    <img src="https://qrcode.tec-it.com/API/QRCode?data={{ URL::to('/') }}/{{ $user->slug }}&choe=UTF-8"
                        width="240px" />
                    <div class="card-block mt-2">
                        <a href="https://qrcode.tec-it.com/API/QRCode?data={{ URL::to('/') }}/{{ $user->slug }}&choe=UTF-8"
                            target="_blank" class="btn btn-secondary mb-4">{{ trans('labels.download') }}
                            <i class="fa-solid fa-arrow-down-to-line ms-2"></i></a>
                    </div>
                    <div class="d-block d-md-flex mb-2">
                        <div class="w-100 mb-2 mb-md-0">
                            @if ($isMob == '1')
                                <a href="whatsapp://send/send?text={{ URL::to('/') }}/{{ $user->slug }}" target="_blank"
                                    class="btn btn-social whatsappcolor w-100">
                                    <i class="fa-brands fa-whatsapp text-wa-color"></i>
                                    {{ trans('labels.whatsapp') }}</a>
                            @else
                                <a href="https://web.whatsapp.com/send?text={{ URL::to('/') }}/{{ $user->slug }}"
                                    target="_blank" class="btn btn-social whatsappcolor w-100">
                                    <i class="fa-brands fa-whatsapp text-wa-color"></i>
                                    {{ trans('labels.whatsapp') }}</a>
                            @endif
                        </div>
                        <div class="w-100">
                            <a href="https://www.facebook.com/sharer.php?u={{ URL::to('/') }}/{{ $user->slug }}"
                                target="_blank" class="btn btn-social mx-0 mx-md-2  w-100 facebookcolor w-100">
                                <i class="fa-brands fa-facebook text-fb-color"></i>
                                {{ trans('labels.facebook') }}
                            </a>
                        </div>
                    </div>
                    <div class="d-block d-md-flex">
                        <div class="w-100 mb-2 mb-md-0">
                            <a href="http://twitter.com/share?text={{ $user->name }}&url={{ URL::to('/') }}/{{ $user->slug }}&hashtags=restaurant,whatsapporder,onlineorder"
                                target="_blank" class="btn btn-social twittercolor w-100">
                                <i class="fa-brands fa-twitter text-tw-color"></i>
                                {{ trans('labels.twitter') }}
                            </a>
                        </div>
                        <div class="w-100 mb-2 mb-md-0">
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ URL::to('/') }}/{{ $user->slug }}"
                                target="_blank" class="btn btn-social mx-0 mx-md-2 linkedincolor w-100">
                                <i class="fa-brands fa-linkedin text-ld-color"></i>
                                {{ trans('labels.linkedin') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
