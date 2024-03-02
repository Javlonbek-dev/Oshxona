@extends('layouts.app')

@section('title', 'Bo\'limlar bo\'yicha saralangan hisobot')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center d-inline">
                <a class="btn btn-outline-secondary" href="{{ URL::previous() }}">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <p class="mt-2 ml-2 h3 text-gray-800">
                    Bo'limlar bo'yicha saralangan hisobot
                </p>
            </div>
            {{--            {{ json_encode($departments) }}--}}

            <div class="row">
                <div class="col-md-8">
                    <input readonly disabled
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
                <div class="col-md-4">
                    <a class="form-control btn-success"
                       href='{{ route('attendances.exportDepartmentFilterReport', ['date' => $date, 'shift_id' => $shift?->id, 'absence_type_id' => $absenceType?->id ]) }}'>
                        Excel
                    </a>
                </div>

            </div>

        </div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                @if($shift)
                    <p class="mb-0 text-gray-800"><b>Smena bo'yicha:</b> ({{$shift->name}})</p>
                @endif
                @if($absenceType)
                    <p class="mb-0 text-gray-800"><b>Ishga kelmaganlar:</b> ({{$absenceType->name}})</p>
                @endif
                <p class="mb-0 text-gray-800"><b>Mehmonlar soni:</b>
                    @if(count($guests) == 0)
                        0
                    @endif
                    @foreach($guests as $key => $guest)
                        {{$guest->name}}: ({{$guest->guests_sum_quantity}})@if($key+1 != count($guests))
                            ,
                        @endif
                    @endforeach
                </p>
            </div>
        </div>


        {{-- Alert Messages --}}
        @include('common.alert')
        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table-responsive" style="height: 68vh">
                    @include('attendances.departmentReportFilterTable')
                </div>
            </div>
        </div>

    </div>

@endsection
