@extends('layouts.app')

@section('title', 'Kunlik hisobotlar')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('attendances.store') }}" method="POST">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Kunlik hisobot</h1>
                <div class="row">
                    <div class="col-md-12">
                        {{--                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">--}}
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
                        {{--                    </div>--}}
                    </div>
                </div>

            </div>

            {{-- Alert Messages --}}
            @include('common.alert')

            <!-- DataTales Example -->
            <div class="card shadow mb-4">

                <div class="card-body">
                    <div class="table-responsive">
                        @csrf
                        @if(count($employees) > 0)
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>F.I.Sh.</th>
                                    <th>Bo'lim nomi</th>
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
                                            {{ $employee->fullName }}
                                            @php
                                                $shiftIds = [];
                                                $absenceTypeId = null;
                                                $absenceTypeName = '';
                                                foreach($employee->attendances as $attendance)
                                                {
                                                    $shiftIds[] = $attendance->shift_id;
                                                    $absenceTypeId = $attendance->absence_type_id;
                                                    $absenceTypeName = $attendance?->absenceType?->name;
                                                }
                                            @endphp

                                        </td>
                                        <td>
                                            {{$employee->department?->name}}
                                        </td>
                                        @foreach($shifts as $shKey => $shift)
                                            <td class="text-center">
                                                @php
                                                    $checked = '';
                                                    if (!$absenceTypeId && in_array($shift->id, $shiftIds))
                                                        $checked = 'checked';

                                                @endphp

                                                @if($checked)
                                                    <i class="fa fa-check"></i>
                                                @endif

                                                {{--                                            <div class="form-check form-check-inline">--}}
                                                {{--                                                <input--}}
                                                {{--                                                    class="{{$employee->id}} form-check-input absence-type-employee-{{$employee->id}}"--}}
                                                {{--                                                    type="checkbox"--}}
                                                {{--                                                    {{ $checked }}--}}
                                                {{--                                                    disabled--}}
                                                {{--                                                    id="checkbox_{{$shift->id}}"--}}
                                                {{--                                                    name="attendanceData[{{ $employee->id }}][shifts][{{ $shift->id }}]}}">--}}
                                                {{--                                            </div>--}}
                                            </td>
                                        @endforeach
                                        <td>
                                            {{ $absenceTypeName }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <h5 class="text-center p-3">Tanlangan kun uchun ma'lumot kiritilmagan...</h5>
                        @endif
                        {{--                        <button type="submit" class="btn btn-success btn-user float-right">--}}
                        {{--                            Save--}}
                        {{--                        </button>--}}
                    </div>
                </div>
            </div>
        </form>

    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.form-control-date').on('change', function () {
                let url = '{{ route("attendances.report", ["date=:date"]) }}';
                let date = this.value;
                url = url.replace(':date', date);
                window.location.href = url;
            });

            $('.form-control-absence-type').on('change', function () {
                let className = "absence-type-employee-" + this.classList[0];
                let objects = document.getElementsByClassName(className);

                if (this.value > 0) {
                    for (let obj of objects) {
                        obj.checked = false;
                    }
                }
            });

            $('.form-check-input').on('change', function () {
                let id = "form-control-absence-type-" + this.classList[0];

                if (this.checked === true) {
                    document.getElementById(id).value = "";
                }
            });
        });
    </script>
@endsection
