@extends('layouts.app')

@section('title', 'Kunlik hisobotlar')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <span class="h4 mb-0 text-gray-800">
                    Kunlik hisobot |
                    <small class="text-secondary"> {{ auth()->user()->department->name }}</small>
                </span>

            @if($daysDiff < 1)
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn-primary btn-sm form-control" data-toggle="modal" data-target="#exampleModal">
                            Boshqa kundan ma'lumot ko'chirish <i class="fa fa-download"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <form action="{{ route('attendances.store') }}" method="POST">

            <div class="d-sm-flex align-items-center justify-content-end mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-control-plaintext" for="exampleCode">Hisobot kuni:</label>
                    </div>

                    <div class="col-md-7">
                        <input
                            type="date"
                            class="form-control form-control-date"
                            id="exampleCode"
                            placeholder="begin_date"
                            name="date"
                            value="{{ $date }}"
                        >

                        @error('begin_date')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- Alert Messages --}}
            @include('common.alert')
            {{--            {{ $employees }}--}}
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mehmonlar </h6>
                </div>
                <div class="card-body py-1">
                    <div class="form-group row">
                        @foreach($shifts as $shKey => $shift)
                            <div class="col-sm-4">
                                <label class="col-form-label-sm mb-0">{{ $shift->name }}</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
                                    id="exampleName"
                                    placeholder="Mehmon soni"
                                    name="attendanceData[guests][{{$shift->id}}]"
                                    value="{{ $shift->guests[0]?->quantity ?? ''}}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hodimlar</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @csrf

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>F.I.Sh.</th>
                                @foreach($shifts as $shift)
                                    <th>{{ $shift->name }}</th>
                                @endforeach
                                <th>Ishga kelmaganlik sababi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($employees as $eKey => $employee)
                                <tr>
                                    <td>
                                        {{ ++  $eKey }}
                                    </td>
                                    <td>
                                        {{ $employee->fullName }}
                                        @php
                                            $shiftIds = [];
                                            $absenceTypeId = null;
                                            foreach($employee->attendances as $attendance)
                                            {
                                                $shiftIds[] = $attendance->shift_id;
                                                $absenceTypeId = $attendance->absence_type_id;
                                            }
                                        @endphp
                                        <input name='attendanceData[{{ $employee->id }}][department_id]'
                                               value="{{ $employee->department_id }}" hidden>
                                        @if(!count($employee->attendances))
                                            <sup class="text-danger">kiritilmagan</sup>
                                        @endif

                                    </td>
                                    @php $required = ''; @endphp
                                    @foreach($shifts as $shKey => $shift)
                                        <td>
                                            @php
                                                $checked = '';
                                                if (!$absenceTypeId) {
                                                    if (in_array($shift->id, $shiftIds))
                                                        $checked = 'checked';
                                                    elseif (empty($shiftIds) && $shKey == 0)
                                                        $checked = 'checked';
                                                }
                                            @endphp
                                            <div class="form-check form-check-inline">
                                                <input
                                                    class="{{$employee->id}} form-check-input absence-type-employee-{{$employee->id}}"
                                                    type="checkbox"
                                                    {{ $checked }}
                                                    id="checkbox_{{$shift->id}}"
                                                    name="attendanceData[{{ $employee->id }}][shifts][{{ $shift->id }}]}}">
                                            </div>
                                        </td>
                                    @endforeach
                                    <td>
                                        <select
                                            class="{{$employee->id}} form-control form-control-absence-type @error('absence_type_id') is-invalid @enderror"
                                            name="attendanceData[{{ $employee->id }}][absence_type_id]"
                                            id="form-control-absence-type-{{ $employee->id }}">
                                            <option selected></option>
                                            @foreach ($absenceTypes as $absenceType)
                                                <option value="{{$absenceType->id}}"
                                                    {{ (($absenceTypeId == $absenceType->id) ? 'selected' : '') }}>
                                                    {{$absenceType->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($daysDiff < 1)
                            <button type="submit" class="btn btn-success btn-user float-right">
                                {{ ($upsert == 0) ? 'Qo\'shish' : 'O\'zgartirish' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('attendances.copyFromDate') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Boshqa kundan ma'lumot ko'chirish</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mx-sm-3 mb-2">
                            Kundan <input type="date" required name="copy_date" class="form-control">
                            {{--                            <label class="form-control-plaintext text-center"><i class="text-center fa fa-exchange"></i></label>--}}
                            <input hidden required name="date" value="{{ $date }}" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                        <button type="submit" class="btn btn-primary">Ko'chirish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.form-control-date').on('change', function () {
                let url = '{{ route("attendances.index", ["date=:date"]) }}';
                let date = this.value;
                url = url.replace(':date', date);
                window.location.href = url;
            });

            $('.form-control-absence-type').on('change', function () {
                let className = "absence-type-employee-" + this.classList[0];
                let dropdown = "form-control-absence-type-" + this.classList[0];
                let objects = document.getElementsByClassName(className);

                if (this.value > 0) {
                    for (let obj of objects) {
                        obj.checked = false;
                    }
                } else {
                    document.getElementById(dropdown).required = true;
                }

            });

            $('.form-check-input').on('change', function () {
                let id = "form-control-absence-type-" + this.classList[0];

                if (this.checked === true) {
                    document.getElementById(id).value = "";
                }

                let className = "absence-type-employee-" + this.classList[0];
                let objects = document.getElementsByClassName(className);

                let checkedCount = 0;

                for (let obj of objects) {
                    if (obj.checked === true)
                        checkedCount++;
                }

                document.getElementById(id).required = (checkedCount === 0);

            });
        });
    </script>
@endsection
