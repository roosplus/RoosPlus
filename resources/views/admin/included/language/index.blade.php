@extends('admin.layout.default')
@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
@endphp
@section('content')
    @if (Auth::user()->type == 1)
        <div class="alert alert-warning" role="alert">
            <p>Don't use double quote (") and back slash (\) in the language fields.</p>
        </div>
    @endif

    <div class="row settings">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="">
                <h5 class="pages-title fs-2">{{ trans('labels.language-settings') }}</h5>
                @include('admin.layout.breadcrumb')
            </div>
            @if (Auth::user()->type == 1)
                @if (App\Models\SystemAddons::where('unique_identifier', 'language')->first() != null &&
                        App\Models\SystemAddons::where('unique_identifier', 'language')->first()->activated == 1)
                    <div class="col-sm-auto col-12">
                        <a href="{{ URL::to('/admin/language-settings/add') }}"
                            class="btn w-100 d-flex gap-1 justify-content-center btn-secondary px-4 rounded-start-5 rounded-end-5">
                            <i class="fa-regular fa-plus"></i>
                            {{ trans('labels.add') }}
                        </a>
                    </div>
                @endif
            @endif
        </div>
        @if (Auth::user()->type == 1)
            <div class="col-12 mb-7">
                <div class="row">
                    <div class="col-xl-3 mb-3">
                        <div class="card card-sticky-top rounded-5 bg-transparent border-0">
                            <ul class="list-group list-options">
                                @foreach ($getlanguages as $data)
                                    <a href="{{ URL::to('admin/language-settings/' . $data->code) }}"
                                        class="list-group-item basicinfo p-3 rounded-5 list-item-primary @if ($currantLang->code == $data->code) active @endif"
                                        aria-current="true">
                                        <div class="d-flex justify-content-between align-item-center">
                                            {{ $data->name }}
                                            <div class="d-flex align-item-center">
                                                <i class="fa-regular fa-angle-right ps-2"></i>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="d-flex gap-2 flex-wrap justify-content-between align-items-center">
                            <div
                                class="dropdown {{ Auth::user()->type == 4 ? (helper::check_access('role_language_settings', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
                                <div class="d-flex gap-2">
                                    <a class="btn btn-info btn-size" tooltip="{{ trans('labels.edit') }}"
                                        href="{{ URL::to('/admin/language-settings/language/edit-' . $currantLang->id) }}"><i
                                            class="fa-regular fa-pen-to-square"></i></a>
                                    @if (Strtolower($currantLang->name) != 'english')
                                        <a class="btn btn-sm btn-danger btn-size " tooltip="{{ trans('labels.delete') }}"
                                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/language-settings/layout/delete-' . $currantLang->id . '/1') }}')" @endif>
                                            <i class="fa-regular fa-trash"></i> </a>
                                    @endif
                                    @if ($currantLang->is_available == '1')
                                        @if (helper::available_language('')->count() > 1)
                                            <a tooltip="{{ trans('labels.active') }}"
                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/language-settings/status-' . $currantLang->id . '/2') }}')" @endif
                                                class="btn btn-sm btn-success btn-size "><i class="fas fa-check"></i></a>
                                        @endif
                                    @else
                                        <a tooltip="{{ trans('labels.inactive') }}"
                                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/language-settings/status-' . $currantLang->id . '/1') }}')" @endif
                                            class="btn btn-sm btn-danger btn-size "><i class="fas fa-close"></i></a>
                                    @endif
                                </div>
                            </div>

                            @if (helper::available_language('')->count() > 1)
                                <div class="d-flex gap-2 align-items-center">
                                    <label for="language_default"
                                        class="form-label col-auto m-0">{{ trans('labels.default_language') }}</label>
                                    <select name="language_default" class="form-select" id="language_default"
                                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onchange="location =  $('option:selected',this).data('value');" @endif>
                                        <option value="" data-value="{{ URL::to('admin/language-settings?lang=') }}">
                                            {{ trans('labels.select') }}</option>
                                        @foreach (helper::available_language('') as $item)
                                            <option value="item"
                                                {{ $item->code == helper::appdata('')->default_language ? 'selected' : '' }}
                                                @if (Request()->code != null && Request()->code != '') data-value="{{ URL::to('admin/language-settings/' . Request()->code . '?lang=' . $item->code) }}" @else data-value="{{ URL::to('admin/language-settings/?lang=' . $item->code) }}" @endif>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="labels-tab" data-bs-toggle="tab"
                                    data-bs-target="#labels" type="button" role="tab" aria-controls="labels"
                                    aria-selected="true">Labels</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="message-tab" data-bs-toggle="tab" data-bs-target="#message"
                                    type="button" role="tab" aria-controls="message"
                                    aria-selected="false">Messages</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="landing-tab" data-bs-toggle="tab" data-bs-target="#landing"
                                    type="button" role="tab" aria-controls="landing"
                                    aria-selected="false">Landing</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="labels" role="tabpanel"
                                aria-labelledby="labels-tab">
                                <div class="card border-0 box-shadow">
                                    <div class="card-body">
                                        <form method="post" action="{{ URL::to('admin/language-settings/update') }}">
                                            @csrf
                                            <input type="hidden" class="form-control" name="currantLang"
                                                value="{{ $currantLang->code }}">
                                            <input type="hidden" class="form-control" name="file" value="label">
                                            <div class="row">
                                                @foreach ($arrLabel as $label => $value)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="example3cols1Input">{{ $label }}
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="label[{{ $label }}]"
                                                                id="label{{ $label }}"
                                                                onkeyup="validation($(this).val(),this.getAttribute('id'))"
                                                                value="{{ $value }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <div class="d-flex justify-content-end">
                                                            @if (env('Environment') == 'sendbox')
                                                                <button type="button"
                                                                    class="btn btn-secondary px-4 rounded-start-5 rounded-end-5"
                                                                    onclick="myFunction()"><i
                                                                        class="fa fa-check-square-o"></i>
                                                                    {{ trans('labels.save') }} </button>
                                                            @else
                                                                <button type="submit"
                                                                    class="btn btn-secondary px-4 rounded-start-5 rounded-end-5"><i
                                                                        class="fa fa-check-square-o"></i>
                                                                    {{ trans('labels.save') }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="message" role="tabpanel" aria-labelledby="message-tab">
                                <div class="card border-0 box-shadow">
                                    <div class="card-body">
                                        <form method="post" action="{{ URL::to('admin/language-settings/update') }}">
                                            @csrf
                                            <input type="hidden" class="form-control" name="currantLang"
                                                value="{{ $currantLang->code }}">
                                            <input type="hidden" class="form-control" name="file" value="message">
                                            <div class="row">
                                                @foreach ($arrMessage as $label => $value)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="example3cols1Input">{{ $label }}
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="message[{{ $label }}]"
                                                                id="message{{ $label }}"
                                                                onkeyup="validation($(this).val(),this.getAttribute('id'))"
                                                                value="{{ $value }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <div class="d-flex justify-content-end">
                                                            @if (env('Environment') == 'sendbox')
                                                                <button type="button"
                                                                    class="btn btn-secondary px-4 rounded-start-5 rounded-end-5"
                                                                    onclick="myFunction()"><i
                                                                        class="fa fa-check-square-o"></i>
                                                                    {{ trans('labels.save') }} </button>
                                                            @else
                                                                <button type="submit"
                                                                    class="btn btn-secondary px-4 rounded-start-5 rounded-end-5"><i
                                                                        class="fa fa-check-square-o"></i>
                                                                    {{ trans('labels.save') }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="landing" role="tabpanel" aria-labelledby="landing-tab">
                                <div class="card border-0 box-shadow">
                                    <div class="card-body">
                                        <form method="post" action="{{ URL::to('admin/language-settings/update') }}">
                                            @csrf
                                            <input type="hidden" class="form-control" name="currantLang"
                                                value="{{ $currantLang->code }}">
                                            <input type="hidden" class="form-control" name="file" value="landing">
                                            <div class="row">
                                                @foreach ($arrLanding as $label => $value)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="example3cols1Input">{{ $label }}
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="landing[{{ $label }}]"
                                                                id="landing{{ $label }}"
                                                                onkeyup="validation($(this).val(),this.getAttribute('id'))"
                                                                value="{{ $value }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <div class="d-flex justify-content-end">
                                                            @if (env('Environment') == 'sendbox')
                                                                <button type="button"
                                                                    class="btn btn-secondary px-4 rounded-start-5 rounded-end-5"
                                                                    onclick="myFunction()"><i
                                                                        class="fa fa-check-square-o"></i>
                                                                    {{ trans('labels.save') }} </button>
                                                            @else
                                                                <button type="submit"
                                                                    class="btn btn-secondary px-4 rounded-start-5 rounded-end-5"><i
                                                                        class="fa fa-check-square-o"></i>
                                                                    {{ trans('labels.save') }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->type == 2 || Auth::user()->type == 4)
            <div class="col-12 mb-7">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                                <thead>
                                    <tr class="text-capitalize fs-15 fw-500">
                                        <td>{{ trans('labels.srno') }}</td>
                                        <td>{{ trans('labels.language') }}</td>
                                        <td>{{ trans('labels.status') }}</td>
                                        <td>{{ trans('labels.is_default') }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach (helper::listoflanguage() as $language)
                                        <tr class="fs-7" data-id="{{ $language->id }}">
                                            <td>@php echo $i++ @endphp</td>
                                            <td>{{ $language->name }}</td>
                                            <td>
                                                @if (in_array($language->code, explode('|', helper::appdata($vendor_id)->languages)))
                                                    <a tooltip="{{ trans('labels.active') }}"
                                                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/language-settings/languagestatus-' . $language->code . '/2') }}')" @endif
                                                        class="btn btn-sm btn-success btn-size {{ Auth::user()->type == 4 ? (helper::check_access('role_language_settings', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                        <i class="fas fa-check"></i></a>
                                                @else
                                                    <a tooltip="{{ trans('labels.inactive') }}"
                                                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/language-settings/languagestatus-' . $language->code . '/1') }}')" @endif
                                                        class="btn btn-sm btn-danger btn-size {{ Auth::user()->type == 4 ? (helper::check_access('role_language_settings', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                        <i class="fas fa-close mx-1"></i></a>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @if (helper::appdata($vendor_id)->default_language == $language->code)
                                                        <a tooltip="{{ trans('labels.active') }}"
                                                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/language-settings/setdefault-' . $language->code . '/2') }}')" @endif
                                                            class="btn btn-sm btn-success btn-size {{ Auth::user()->type == 4 ? (helper::check_access('role_language_settings', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                            <i class="fas fa-check"></i></a>
                                                    @else
                                                        <a tooltip="{{ trans('labels.inactive') }}"
                                                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/language-settings/setdefault-' . $language->code . '/1') }}')" @endif
                                                            class="btn btn-sm btn-danger btn-size {{ Auth::user()->type == 4 ? (helper::check_access('role_language_settings', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                            <i class="fas fa-close mx-1"></i></a>
                                                    @endif
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
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function validation(value, id) {
            if (value.includes('"')) {
                newval = value.replaceAll('"', '');
                $('#' + id).val(newval);
            }
            if (value.includes('\\')) {
                newval = value.replaceAll('\\', '');
                $('#' + id).val(newval);
            }
        }
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/settings.js') }}"></script>
@endsection
