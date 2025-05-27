@extends('front.theme.default')
@section('content')
    <section class="breadcrumb-sec">
        <div class="container">
            <nav class="px-3">
                <ol class="breadcrumb d-flex m-0 text-capitalize">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to(@$storeinfo->slug) }}" class="text-dark">{{ trans('labels.home') }}</a>
                    </li>
                    <li
                        class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}">
                        {{ trans('labels.faqs') }}
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    @if (count($allfaqs) > 0)
        <section class="theme-1-margin-top faq">
            <div class="container">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="accordion" id="accordionExample">
                            @foreach ($allfaqs as $key => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button
                                            class="accordion-button fw-500 fs-15 m-0 {{ session()->get('direction') == 2 ? 'rtl' : '' }} {{ $key == 0 ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $key }}" aria-expanded="true"
                                            aria-controls="collapse-{{ $key }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $key }}"
                                        class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body fs-7">
                                            {{ $faq->answer }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="image1 rounded overflow-hidden h-100">
                            <img src="{{ @helper::image_path(helper::appdata(@$vdata)->faq_image) }}" alt="faq image"
                                class="object">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        @include('front.nodata')
    @endif

    @include('front.sum_qusction')
@endsection
