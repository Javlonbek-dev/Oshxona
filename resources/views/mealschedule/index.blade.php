@extends('layouts.app')

@section('title', 'Haftalik menyu')
@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Haftalik menyu</h1>
            <div class="row">
                <div class="col-md-12">
                    <input class="mb-3" type="date" id="selectDate" name="date"
                           value="{{ $selectedDate->format('Y-m-d') }}"> <br>
                </div>
            </div>

        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr class="text-center">
                            @foreach ($days as $day)
                                <th>
                                    {{ \Carbon\Carbon::parse($day['date'])->format('l') }}<br>
                                    {{ $day['date'] }}
                                    <a href="{{ route('mealschedule.create', ['selectedDate' => $day['date']]) }}"
                                       class="btn btn-primary m-2" style="font-size: 10px; top: 20px ">
                                        @if(count($day['meals']))
                                            <i class="fa fa-pen"></i>
                                        @else
                                            <i class="fa fa-plus"></i>
                                        @endif
                                    </a>
                                </th>

                            @endforeach
                        </tr>
                        </thead>
                        <tr>
                            @foreach ($days as $day)
                                <td class="text-center">
                                    @if (isset($day['meals']))
                                        @foreach ($day['meals'] as $key => $meal)
                                            <img src="{{ asset('storage/meals/photos/' . $meal['meal']['photo'] )}}"
                                                 width="100"
                                                 alt="" style="margin: 10px "><br>
                                            <strong
                                                    style="display: flex;justify-content: center">{{ $meal['meal']['name'] }}</strong>
                                            <br>
                                            @if($key != count($day['meals'])-1 )
                                                <hr style="margin: 15px 0;">
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            $('#selectDate').on('change', function () {
                let url = '{{ route("mealschedule.index", ["selectedDate=:selectedDate"]) }}';
                let selectedDate = this.value;
                url = url.replace(':selectedDate', selectedDate);
                window.location.href = url;
            });
        });
    </script>
@endsection
