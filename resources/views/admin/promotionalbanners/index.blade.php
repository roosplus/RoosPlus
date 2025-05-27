@extends('admin.layout.default')
@section('content')
    <div class="row justify-content-between align-items-center">
        <div class="col-12 col-md-4">
            <h5 class="pages-title fs-2">{{ trans('labels.promotional_banners') }}</h5>
            @include('admin.layout.breadcrumb')
        </div>
        <div class="col-12 col-md-8">
            <div class="d-flex justify-content-end">
                <a href="{{ URL::to('admin/promotionalbanners/add') }}"
                    class="btn btn-secondary px-4 rounded-start-5 rounded-end-5">
                    <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}
                </a>
            </div>
        </div>
    </div>
    <div class="col-12 mb-7 mt-3">
        <div class="card border-0 box-shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
                        <thead>
                            <tr class="fw-500">
                                <td></td>
                                <td>{{ trans('labels.srno') }}</td>
                                <td>{{ trans('labels.image') }}</td>
                                <td>{{ trans('labels.vendor_title') }}</td>
                                <td>{{ trans('labels.created_date') }}</td>
                                <td>{{ trans('labels.updated_date') }}</td>
                                <td>{{ trans('labels.action') }}</td>
                            </tr>
                        </thead>
                        <tbody id="tabledetails" data-url="{{ url('admin/promotionalbanners/reorder_promotionalbanner') }}">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($getbannerlist as $banner)
                                <tr class="fs-7 align-middle row1" id="dataid{{ $banner->id }}"
                                    data-id="{{ $banner->id }}">
                                    <td><a tooltip="{{ trans('labels.move') }}"><i
                                                class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                                    <td>@php
                                        echo $i++;
                                    @endphp</td>
                                    <td>
                                        <img src="{{ helper::image_path($banner->image) }}"
                                            class="hight-50 object-fit-cover rounded-3" alt="">
                                    </td>
                                    <td>{{ @$banner['vendor_info']->name }}</td>
                                    <td>{{ helper::date_format($banner->created_at, Auth::user()->id) }}<br>
                                        {{ helper::time_format($banner->created_at, Auth::user()->id) }}

                                    </td>
                                    <td>{{ helper::date_format($banner->updated_at, Auth::user()->id) }}<br>
                                        {{ helper::time_format($banner->updated_at, Auth::user()->id) }}

                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ URL::to('admin/promotionalbanners/edit-' . $banner->id) }}"
                                                class="btn btn-sm btn-info btn-size" tooltip="{{ trans('labels.edit') }}">
                                                <i class="fa-regular fa-pen-to-square"></i></a>

                                            <a href="javascript:void(0)"
                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/promotionalbanners/delete-' . $banner->id) }}')" @endif
                                                class="btn btn-sm btn-danger btn-size"
                                                tooltip="{{ trans('labels.delete') }}">
                                                <i class="fa-regular fa-trash"></i>
                                            </a>
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
