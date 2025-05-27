@extends('admin.layout.default')
@section('content')
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-12 col-md-4">
            <h5 class="pages-title fs-2">{{ trans('labels.edit') }}</h5>
            <div class="d-flex">
                @include('admin.layout.breadcrumb')
            </div>
        </div>

    </div>
    <div class="row mt-3">
        @php
            if (Auth::user()->type == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
        @endphp
        <div class="col-12 mb-7">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/tax/update-' . $edittax->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="name" value="{{ $edittax->name }}"
                                    placeholder="{{ trans('labels.name') }}" required>

                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.type') }}<span class="text-danger"> *
                                    </span></label>
                                <select name="type" class="form-select" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    <option value="1" {{ $edittax->type == 1 ? 'selected' : '' }}>
                                        {{ trans('labels.fixed') }} ({{ helper::appdata($vendor_id)->currency }})</option>
                                    <option value="2" {{ $edittax->type == 2 ? 'selected' : '' }}>
                                        {{ trans('labels.percentage') }} (%)</option>

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.tax') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control numbers_only" name="tax"
                                    value="{{ $edittax->tax }}" placeholder="{{ trans('labels.tax') }}" required>

                            </div>
                            <div class="form-group m-0 mt-2 d-flex gap-2 justify-content-end">
                                <a href="{{ URL::to('admin/tax') }}"
                                    class="btn btn-danger px-4 rounded-start-5 rounded-end-5">{{ trans('labels.cancel') }}</a>
                                <button
                                    class="btn btn-secondary px-4 rounded-start-5 rounded-end-5 {{ Auth::user()->type == 4 ? (helper::check_access('role_tax', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
