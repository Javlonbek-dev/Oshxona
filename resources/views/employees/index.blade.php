@extends('layouts.app')

@section('title', 'Hodimlar')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hodimlar</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Qo'shish
                    </a>
                </div>
                {{--                <div class="col-md-6">--}}
                {{--                    <a href="{{ route('employees.export') }}" class="btn btn-sm btn-success">--}}
                {{--                        <i class="fas fa-check"></i> Export To Excel--}}
                {{--                    </a>--}}
                {{--                </div>--}}
            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <label>Qidirish</label>
                        <input id="search"
                               placeholder="Xodim F.I.Sh, kodi(ID) yoki telefon raqami ..."
                               class="form-control form-control-sm" name="search" value="{{ $search ?? ''}}">
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label>Bo'limlar</label>
                        <select id="department" class="form-control form-control-sm">
                            <option selected value="">tanlang ...</option>
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}"
                                    {{old('department_id') ? ((old('department_id') == $department->id) ? 'selected' : '') :
                                        (( $departmentId == $department->id) ? 'selected' : '')}}>
                                    {{$department->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-2">
                        <label> &nbsp; </label>
                        <button id="clear" value="{{ $employees->url(1) }}"
                                class="form-control form-control-sm btn-outline-secondary">Tozalash
                        </button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <select id="pagination" class="form-control">
                                    <option value="25" @if($rows == 25) selected @endif >25</option>
                                    <option value="50" @if($rows == 50) selected @endif >50</option>
                                    <option value="100" @if($rows == 100) selected @endif >100</option>
                                </select>
                            </div>

                            <div class="col-6 mt-2">
                                Jami: {{ $employees->total() }}
                            </div>
                        </div>

                        {{ $employees->appends(request()->input())->links() }}


                    </div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th width="5%">Kodi (ID)</th>
                            <th width="44%">F.I.Sh.</th>
                            <th width="30%">Bo'limi / Lavozimi</th>
                            <th width="15%">Telefon raqam / ️JSHSHIR</th>
                            <th width="10%"><i class="fa fa-sliders"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($employees as $eKey => $employee)
                            <tr>
                                <td>{{ ($employees->currentPage() - 1) * $employees->perPage() + $eKey + 1 }}</td>
                                <td>{{ $employee->tabel }}</td>
                                <td>{{ $employee->fullName }}</td>
                                <td>{{ $employee->department?->name }} <br> {{ $employee->position?->name }}</td>
                                <td>{{ $employee->mobile_number ?? '-' }} <br> {{ $employee->pnfl ?? '-'}}</td>
                                <td style="display: flex;">
                                    <a href="{{ route('employees.edit', ['employee' => $employee->id]) }}"
                                       class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger delete-model m-2" href="#"
                                       onclick="loadDeleteModal({{ $employee->id }})">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @include('employees.delete-modal')

@endsection

@section('scripts')
    <script>
        function loadDeleteModal(id) {
            var route = '{{ route("employees.destroy", ":employee") }}';
            route = route.replace(':employee', id);
            $('#employee-delete-form').attr('action', route);
            $('#deleteModal').modal('show');
        }

        let departmentId = document.getElementById('department').value ?? '';
        let search = document.getElementById('search').value ?? '';

        //page count select
        $(document).ready(function () {
            $('#pagination').on('change', function () {
                window.location.href = `{!! $employees->url(1) !!}&rows=${this.value}&search=${search}&department_id=${departmentId}`;
            });

            //search
            $('#search').on('change', function () {
                window.location.href = `{!! $employees->url(1) !!}&search=${this.value}&department_id=${departmentId}`;
            });

            //department
            $('#department').on('change', function () {
                window.location.href = `{!! $employees->url(1) !!}&search=${search}&department_id=${this.value}`;
            });

            //clear
            $('#clear').on('click', function () {
                window.location.href = this.value;
            });
        });

    </script>

@endsection
