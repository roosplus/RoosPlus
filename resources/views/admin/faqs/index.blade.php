@extends('admin.layout.default')
@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
@endphp
@section('content')
    <div class="row justify-content-between align-items-center">
        <div class="col-12 col-md-4">
            <h5 class="pages-title fs-2">{{ trans('labels.faqs') }}</h5>
            @include('admin.layout.breadcrumb')
        </div>
        <div class="col-12 col-md-8">
            <div class="d-flex justify-content-end">
                <a href="{{ URL::to('admin/faqs/add') }}"
                    class="btn btn-secondary px-4 rounded-start-5 rounded-end-5 {{ Auth::user()->type == 4 ? (helper::check_access('role_faqs', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
                    <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 mt-3 mb-7">
        <div class="card border-0 box-shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                        <thead>
                            <tr class="fw-500">
                                <td></td>
                                <td>{{ trans('labels.srno') }}</td>
                                <td>{{ trans('labels.question') }}</td>
                                <td>{{ trans('labels.answer') }}</td>
                                <td>{{ trans('labels.created_date') }}</td>
                                <td>{{ trans('labels.updated_date') }}</td>
                                <td>{{ trans('labels.action') }}</td>
                            </tr>
                        </thead>
                        <tbody id="tabledetails" data-url="{{ url('admin/faqs/reorder_faq') }}">
                            @php

                                $i = 1;

                            @endphp
                            @foreach ($faqs as $faq)
                                <tr class="fs-7 align-middle row1" id="dataid{{ $faq->id }}"
                                    data-id="{{ $faq->id }}">
                                    <td><a tooltip="{{ trans('labels.move') }}"><i
                                                class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                                    <td>@php

                                        echo $i++;

                                    @endphp</td>
                                    <td>{{ $faq->question }}</td>
                                    <td>{{ Str::limit($faq->answer, 150) }}</td>
                                    <td>{{ helper::date_format($faq->created_at, $vendor_id) }}<br>
                                        {{ helper::time_format($faq->created_at, $vendor_id) }}

                                    </td>
                                    <td>{{ helper::date_format($faq->updated_at, $vendor_id) }}<br>
                                        {{ helper::time_format($faq->updated_at, $vendor_id) }}

                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ URL::to('/admin/faqs/edit-' . $faq->id) }}"
                                                class="btn btn-sm btn-info btn-size {{ Auth::user()->type == 4 ? (helper::check_access('role_faqs', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                tooltip="{{ trans('labels.edit') }}">
                                                <i class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="javascript:void(0)"
                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/faqs/delete-' . $faq->id) }}')" @endif
                                                class="btn btn-sm btn-danger btn-size {{ Auth::user()->type == 4 ? (helper::check_access('role_faqs', Auth::user()->role_id, $vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}"
                                                tooltip="{{ trans('labels.delete') }}">
                                                <i class="fa-regular fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
