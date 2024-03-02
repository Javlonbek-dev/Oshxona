@extends('layouts.app')

@section('title', 'Smenalar')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">MealSchedule</h1>
            <a href="{{route('mealschedule.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Ortga</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">MealSchedule qo'shish</h6>
            </div>
            <form method="POST" action="{{route('mealschedule.store')}}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12 col-lg-6">
                            <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                                <input class="mb-3" type="date" name="date"
                                       value="{{ $selectedDate }}"> <br>

                                <span style="color:red;">*</span><label>1-taom nomi</label><br>
                                <select name="meals[]" type="dropdown" id="meals"
                                        style="width: 100px; margin-left: 10px; margin-bottom:20px ">
                                    @foreach($meals as $meal)
                                        <option value="{{ $meal->id }}">{{ $meal->name }}</option>
                                    @endforeach
                                </select><br>

                                <span style="color:red;">*</span><label>2-taom nomi</label><br>
                                <select name="meals[]" type="dropdown" id="meals"
                                        style="width: 100px; margin-left: 10px">
                                    @foreach($meals as $meal)
                                        <option value="{{ $meal->id }}">{{ $meal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Saqlash</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('mealschedule.index') }}">Bekor
                        qilish</a>
                </div>
            </form>
        </div>

    </div>

@endsection
