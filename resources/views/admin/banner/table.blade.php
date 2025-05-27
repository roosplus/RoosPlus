<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class="fw-500">
            <td></td>
            <td>{{ trans('labels.srno') }}</td>
            <td>{{ trans('labels.image') }}</td>
            <td>{{ trans('labels.created_date') }}</td>
            <td>{{ trans('labels.updated_date') }}</td>
            <td>{{ trans('labels.action') }}</td>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/banner/reorder_banner') }}">
        @php $i = 1; @endphp
        @foreach ($getbannerlist as $banner)
            <tr class="fs-7 align-middle row1" id="dataid{{ $banner->id }}" data-id="{{ $banner->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td><img src="{{ helper::image_path($banner->banner_image) }}"
                        class="img-fluid rounded hight-50 object-fit-cover" alt="">
                </td>
                <td>{{ helper::date_format($banner->created_at, $vendor_id) }}<br>
                    {{ helper::time_format($banner->created_at, $vendor_id) }}

                </td>
                <td>{{ helper::date_format($banner->updated_at, $vendor_id) }}<br>
                    {{ helper::time_format($banner->updated_at, $vendor_id) }}

                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ URL::to('admin/banner/edit-' . $banner->id) }}"
                            class="btn btn-sm btn-info btn-size {{ Auth::user()->type == 4 ? (helper::check_access('role_banner', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                            tooltip="{{ trans('labels.edit') }}">
                            <i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0)"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="deletedata('{{ URL::to('admin/banner/delete-' . $banner->id) }}')" @endif
                            class="btn btn-sm btn-danger btn-size {{ Auth::user()->type == 4 ? (helper::check_access('role_banner', Auth::user()->role_id, $vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}"
                            tooltip="{{ trans('labels.delete') }}">
                            <i class="fa-regular fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
