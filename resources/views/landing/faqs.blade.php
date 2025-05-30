@extends('landing.layout.default')
@section('content')
    <section class="my-5">
        <div class="container faq-container">
            <div class="sec-title mb-4">
                <h2 class="faq-title">{{ trans('landing.faq_section_title') }}</h2>
                <h5 class="faq-subtitle col-md-12 sub-title">
                    {{ trans('landing.faq_section_description') }}
                </h5>
            </div>
            <div>
                <div class="accordion" id="accordionExample">
                    @foreach ($allfaqs as $key => $faq)
                        <div class="accordion-item  border-0 {{ $key == 0 ? ' pt-0' : ' pt-4' }}">
                            <h2 class="accordion-header" id="heading-{{ $key }}">
                                <button
                                    class="{{ session()->get('direction') == 2 ? 'accordion-button-rtl' : 'accordion-button' }} border rounded-3 bg-black {{ $key == 0 ? '' : 'collapsed' }}  bg-white text-black"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}"
                                    aria-expanded="true" aria-controls="collapse-{{ $key }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $key }}"
                                class="accordion-collapse border border rounded-2 collapse mt-2 {{ $key == 0 ? 'show' : '' }}"
                                aria-labelledby="heading-{{ $key }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body rounded-1">
                                    <p class="faq-accordion-lorem-text pt-3">
                                        {{ $faq->answer }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endsection
