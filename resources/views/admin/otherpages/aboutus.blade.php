@extends('admin.layout.default')
@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
@endphp
@section('content')
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-12">
            <h5 class="pages-title fs-2">{{ trans('labels.about_us') }}</h5>
            @include('admin.layout.breadcrumb')
        </div>
    </div>
    <div class="col-12 mb-7 mt-3">
        <div class="card border-0 box-shadow">
            <div class="card-body">
                <div id="about-us-three" class="about-us">
                    <form action="{{ URL::to('admin/aboutus/update') }}" method="post">
                        @csrf
                        <textarea class="form-control" id="ckeditor" name="aboutus">{{ @$getaboutus->about_content }}</textarea>
                        @error('aboutus')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror
                        <div class="form-group m-0 mt-2 d-flex gap-2 justify-content-end">
                            <button
                                class="btn btn-secondary px-4 rounded-start-5 rounded-end-5 {{ Auth::user()->type == 4 ? (helper::check_access('role_cms_pages', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}"
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('ckeditor');
    </script>
@endsection
