@extends('layouts.app')

@section('title', '1c Hodimlar bo\'yicha hisobot')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">1c Hodimlar bo'yicha hisobot</h1>

            <div class="form-inline">
                {{ $from }} <br> {{ $to }}
                <button class="ml-2 form-control btn-primary" data-toggle="modal" data-target="#exampleModal"><i
                        class="fa fa-calendar"></i></button>
            </div>

            <div>
                <a class="form-control btn-success"
                   href='{{ route('attendances.exportEmployeesReport'.`, ['from' => $from, 'to' => $to, 'rows' => 10000000]) `}}'>
                    Excel
                </a>
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
                            <option selected value="">Barchasi</option>
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

            {{--            {{ json_encode($records->toArray()) }}--}}

            <div class="card-body">
                <div class="d-flex mb-2 justify-content-end">
                    <div class="mr-3 mt-2">
                        Jami: {{ $employees->total() }}
                    </div>

                    <div class="mx-1">
                        <select id="pagination" class="form-control">
                            <option value="25" @if($rows == 25) selected @endif >25</option>
                            <option value="50" @if($rows == 50) selected @endif >50</option>
                            <option value="100" @if($rows == 100) selected @endif >100</option>
                        </select>
                    </div>

                    <div class="mx-1">
                        {{ $employees->appends(request()->input())->links() }}
                    </div>
                </div>
                <div class="table-responsive">
                    @include('attendances.employeesReportTable')
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('attendances.employeesReport') }}" method="GET">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hisobot davrini tanlang {{$departmentId}} {{$search}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mx-sm-3 mb-2 form-inline">
                            <input type="date" required name="from" value="{{ $from }}" class="form-control">
                            <span class="mx-3"> - </span>
                            <input type="date" required name="to" value="{{ $to }}" class="form-control">
                            {{--                            send search and department id invisible --}}
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="department_id" value="{{ $departmentId }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tanlang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-responsive {
            overflow: auto;
            height: 100vh;
        }

        .table-responsive thead {
            position: sticky;
            top: 0;
        }

    </style>

    <script>
        let departmentId = document.getElementById('department').value ?? '';
        let search = document.getElementById('search').value ?? '';

        $(document).ready(function () {
            // select period
            $('.form-control-date').on('change', function () {
                let url = '{{ route("attendances.employeesReport", ["date=:date"]) }}';
                let date = this.value;
                url = url.replace(':date', date);
                // make url with date, department id, search
                window.location.href = url + `&department_id=${departmentId}&search=${search}`;
            });

            //department
            $('#department').on('change', function () {
                window.location.href = `{!! $employees->url(1) !!}&search=${search}&department_id=${this.value}`;
            });

            //search
            $('#search').on('change', function () {
                window.location.href = `{!! $employees->url(1) !!}&search=${this.value}&department_id=${departmentId}`;
            });

            //clear
            $('#clear').on('click', function () {
                window.location.href = this.value;
            });
        });
    </script>
@endsection
