@extends('layouts.app')

@section('title', '1c uchun hisobotlar')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hodim va mehmonlarning korxona oshxonasiga kirib tushlik qilganlik xisoboti (Bo'limlar bo'yicha)</h1>

            {{--            {{ json_encode($departments) }}--}}

            <div class="row">
                <div class="col-md-8">
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
                <div class="col-md-4">
                    <a class="form-control btn-success" href='{{ route('attendances.export1cReport', ['date' => $date]) }}'>
                        Excel
                    </a>
                </div>
            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive" style="height: 68vh">
                    @include('attendances.report1cTable')
                </div>
            </div>
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
        $(document).ready(function () {
            $('.form-control-date').on('change', function () {
                let url = '{{ route("attendances.report1c", ["date=:date"]) }}';
                let date = this.value;
                url = url.replace(':date', date);
                window.location.href = url;
            });
        });
    </script>
@endsection
