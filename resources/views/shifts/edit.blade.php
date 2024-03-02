@extends('layouts.app')

@section('title', 'Smenalar')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Smenalar</h1>
            <a href="{{route('shifts.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Ortga</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Smenani tahrirlash</h6>
            </div>
            <form method="POST" action="{{route('shifts.update', ['shift' => $shift->id])}}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row ">
                        <div class="col-md-12 col-lg-6">
                            <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span><label>Nomi</label>
                                <input
                                    type="text"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="exampleCode"
                                    placeholder="Nomi"
                                    name="name"
                                    value="{{ old('name') ?  old('name') : $shift->name}}">

                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span><label>Boshlanish vaqti</label>
                                <input
                                    type="time"
                                    class="form-control form-control-user @error('begin_date') is-invalid @enderror"
                                    id="exampleCode"
                                    placeholder="Boshlanish vaqti"
                                    name="begin_date"
                                    value="{{ old('begin_date') ?  old('begin_date') : $shift->begin_date}}">

                                @error('begin_date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span><label>Yakunlanish vaqti</label>
                                <input
                                    type="time"
                                    class="form-control form-control-user @error('end_date') is-invalid @enderror"
                                    id="exampleCode"
                                    placeholder="Yakunlanish vaqti"
                                    name="end_date"
                                    value="{{ old('end_date') ?  old('end_date') : $shift->end_date}}">

                                @error('end_date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">O'zgartirish</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('shifts.index') }}">Bekor qilish</a>
                </div>
            </form>
        </div>

    </div>

@endsection
