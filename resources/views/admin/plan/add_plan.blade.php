@extends('admin.layout.default')
@section('content')
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-12">
            <h5 class="pages-title fs-2">{{ trans('labels.add_new') }}</h5>
            @include('admin.layout.breadcrumb')
        </div>
    </div>
    <div class="col-12 mb-7">
        <div class="card border-0 box-shadow">
            <div class="card-body">
                <form action="{{ URL::to('admin/plan/save_plan') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label class="form-label">{{ trans('labels.name') }}<span class="text-danger">
                                    *</span></label>
                            <input type="text" class="form-control" name="plan_name" value="{{ old('plan_name') }}"
                                placeholder="{{ trans('labels.name') }}" required>
                            @error('plan_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label">{{ trans('labels.amount') }}<span class="text-danger">
                                    *</span></label>
                            <input type="text" class="form-control numbers_only" name="plan_price"
                                value="{{ old('plan_price') }}" placeholder="{{ trans('labels.amount') }}" required>
                            @error('plan_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.duration_type') }}</label>
                                <select class="form-select type" name="type">
                                    <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>
                                        {{ trans('labels.fixed') }}</option>
                                    <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>
                                        {{ trans('labels.custom') }}</option>
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group 1 selecttype">
                                <label class="form-label">{{ trans('labels.duration') }}<span class="text-danger"> *
                                    </span></label>
                                <select class="form-select" name="plan_duration">
                                    <option value="1">{{ trans('labels.one_month') }}</option>
                                    <option value="2">{{ trans('labels.three_month') }}</option>
                                    <option value="3">{{ trans('labels.six_month') }}</option>
                                    <option value="4">{{ trans('labels.one_year') }}</option>
                                    <option value="5">{{ trans('labels.lifetime') }}</option>
                                </select>
                                @error('plan_duration')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group 2 selecttype">
                                <label class="form-label">{{ trans('labels.days') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control numbers_only" name="plan_days" value=""
                                    placeholder="{{ trans('labels.days') }}">
                                @error('plan_days')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.service_limit') }}</label>
                                <select class="form-select service_limit_type" name="service_limit_type">
                                    <option value="1" {{ old('service_limit_type') == '1' ? 'selected' : '' }}>
                                        {{ trans('labels.limited') }}</option>
                                    <option value="2" {{ old('service_limit_type') == '2' ? 'selected' : '' }}>
                                        {{ trans('labels.unlimited') }}</option>
                                </select>
                                @error('service_limit_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group 1 service-limit">
                                <label class="form-label">{{ trans('labels.max_business') }}<span class="text-danger">
                                        *</span></label>
                                <input type="text" class="form-control numbers_only" name="plan_max_business"
                                    value="{{ old('plan_max_business') }}"
                                    placeholder="{{ trans('labels.max_business') }}">
                                @error('plan_max_business')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label mt-2">{{ trans('labels.booking_limit') }}</label>
                                <select class="form-select booking_limit_type" name="booking_limit_type">
                                    <option value="1" {{ old('booking_limit_type') == '1' ? 'selected' : '' }}>
                                        {{ trans('labels.limited') }}</option>
                                    <option value="2" {{ old('booking_limit_type') == '2' ? 'selected' : '' }}>
                                        {{ trans('labels.unlimited') }}</option>
                                </select>
                                @error('booking_limit_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group 1 booking-limit">
                                <label class="form-label">{{ trans('labels.orders_limit') }}<span class="text-danger">
                                        *
                                    </span></label>
                                <input type="text" class="form-control numbers_only" name="plan_appoinment_limit"
                                    value="{{ old('plan_appoinment_limit') }}"
                                    placeholder="{{ trans('labels.orders_limit') }}">
                                @error('plan_appoinment_limit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.description') }}<span class="text-danger">
                                        *</span></label>
                                <textarea class="form-control" rows="3" name="plan_description" placeholder="{{ trans('labels.description') }}"
                                    required>{{ old('plan_description') }}</textarea>
                                @error('plan_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group add-extra-class {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                                <label class="form-label">{{ trans('labels.tax') }}</label>
                                <select name="plan_tax[]" class="form-control selectpicker" multiple
                                    data-live-search="true">
                                    @if (!empty($gettaxlist))
                                        @foreach ($gettaxlist as $tax)
                                            <option value="{{ $tax->id }}"> {{ $tax->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.features') }}<span class="text-danger"> *
                                    </span></label>
                                <div id="repeater">
                                    <div class="d-flex gap-2 mb-3">
                                        <input type="text" class="form-control" name="plan_features[]"
                                            value="{{ old('plan_features[]') }}"
                                            placeholder="{{ trans('labels.features') }}" required>
                                        <button type="button" class="btn btn-dark hov btn-sm rounded-5" id="addfeature">
                                            <i class="fa-regular fa-plus clickadd"></i>
                                        </button>
                                    </div>
                                    @error('plan_features')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row">

                                @if (App\Models\SystemAddons::where('unique_identifier', 'coupon')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'coupon')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="coupons"
                                                id="coupons">
                                            <label class="form-check-label"
                                                for="coupons">{{ trans('labels.coupons') }}</label>
                                        </div>
                                        @error('coupons')
                                            <span class="text-danger" id="coupon">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                @if (App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first()->activated == 1)
                                    <div class="col-sm-6  mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="custom_domain"
                                                id="custom_domain">
                                            <label class="form-check-label"
                                                for="custom_domain">{{ trans('labels.custom_domain_available') }}</label>
                                        </div>
                                        @error('custom_domain')
                                            <span class="text-danger" id="custom_domain">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                @if (App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="google_analytics"
                                                id="google_analytics">
                                            <label class="form-check-label"
                                                for="google_analytics">{{ trans('labels.google_analytics_available') }}</label>
                                        </div>
                                        @error('google_analytics')
                                            <span class="text-danger" id="google_analytic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="blogs"
                                                id="blogs">
                                            <label class="form-check-label"
                                                for="blogs">{{ trans('labels.blogs') }}</label>
                                        </div>
                                        @error('blogs')
                                            <span class="text-danger" id="blog">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                @if (App\Models\SystemAddons::where('unique_identifier', 'google_login')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'google_login')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="google_login"
                                                id="google_login">
                                            <label class="form-check-label"
                                                for="google_login">{{ trans('labels.google_login') }}</label>
                                        </div>
                                        @error('google_login')
                                            <span class="text-danger" id="google_login">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                                @if (App\Models\SystemAddons::where('unique_identifier', 'facebook_login')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'facebook_login')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="facebook_login"
                                                id="facebook_login">
                                            <label class="form-check-label"
                                                for="facebook_login">{{ trans('labels.facebook_login') }}</label>
                                        </div>
                                        @error('facebook_login')
                                            <span class="text-danger" id="facebook_login">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                                @if (App\Models\SystemAddons::where('unique_identifier', 'pwa')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'pwa')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="pwa"
                                                id="pwa">
                                            <label class="form-check-label"
                                                for="pwa">{{ trans('labels.pwa') }}</label>
                                        </div>
                                        @error('pwa')
                                            <span class="text-danger" id="pwa">{{ $message }}</span>
                                        @enderror

                                    </div>
                                @endif
                                @if (App\Models\SystemAddons::where('unique_identifier', 'notification')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'notification')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="sound_notification"
                                                id="sound_notification">
                                            <label class="form-check-label"
                                                for="sound_notification">{{ trans('labels.sound_notification') }}</label>
                                        </div>
                                    </div>
                                @endif
                                @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="whatsapp_message"
                                                id="whatsapp_message">
                                            <label class="form-check-label"
                                                for="whatsapp_message">{{ trans('labels.whatsapp_message') }}</label>
                                        </div>
                                    </div>
                                @endif
                                @if (App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="telegram_message"
                                                id="telegram_message">
                                            <label class="form-check-label"
                                                for="telegram_message">{{ trans('labels.telegram_message') }}</label>
                                        </div>
                                    </div>
                                @endif

                                @if (App\Models\SystemAddons::where('unique_identifier', 'pos')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'pos')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="pos"
                                                id="pos">
                                            <label class="form-check-label"
                                                for="pos">{{ trans('labels.pos') }}</label>
                                        </div>
                                    </div>
                                @endif

                                @if (App\Models\SystemAddons::where('unique_identifier', 'tableqr')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'tableqr')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="tableqr"
                                                id="tableqr">
                                            <label class="form-check-label"
                                                for="tableqr">{{ trans('labels.tableqr') }}</label>
                                        </div>
                                    </div>
                                @endif
                                @if (App\Models\SystemAddons::where('unique_identifier', 'employee')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'employee')->first()->activated == 1)
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="employee"
                                                id="employee">
                                            <label class="form-check-label"
                                                for="employee">{{ trans('labels.role_management') }}</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group add-extra-class {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <label class="form-label">{{ trans('labels.users') }}</label>
                            <select class="form-control selectpicker" name="vendors[]" multiple data-live-search="true">
                                @if (!empty($vendors))
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ old('vendor') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label mt-2 mb-0">{{ trans('labels.themes') }}
                                    <span class="text-danger"> * </span> </label>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                @endif
                                @php
                                    $checktheme = App\Models\SystemAddons::where(
                                        'unique_identifier',
                                        'LIKE',
                                        '%' . 'theme_' . '%',
                                    )
                                        ->where('activated', '1')
                                        ->get();
                                    $themes = [];
                                    foreach ($checktheme as $ttlthemes) {
                                        array_push($themes, str_replace('theme_', '', $ttlthemes->unique_identifier));
                                    }
                                @endphp

                            </div>
                        </div>



                        <div class="col-md-12 selectimg">
                            <div class="form-group">
                                <div class="row g-3">
                                    @foreach ($themes as $key => $item)
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3">
                                            <label for="template{{ $item }}"
                                                class="radio-card position-relative">
                                                <input type="checkbox" name="themecheckbox[]"
                                                    id="template{{ $item }}" value="{{ $item }}"
                                                    {{ $key == 0 ? 'checked' : '' }} class="d-none">
                                                <div class="card-content-wrapper border rounded-2">
                                                    <span class="check-icon position-absolute"></span>
                                                    <div class="selecimg">
                                                        <img src="{{ helper::image_path('theme-' . $item . '.png') }}"
                                                            class="rounded">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-0 mt-2 d-flex gap-2 justify-content-end">
                            <a href="{{ URL::to('admin/plan') }}"
                                class="btn btn-danger px-4 rounded-start-5 rounded-end-5">{{ trans('labels.cancel') }}</a>
                            <button class="btn btn-secondary px-4 rounded-start-5 rounded-end-5"
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETSPATHURL') . '/admin-assets/js/plan.js') }}"></script>
@endsection
