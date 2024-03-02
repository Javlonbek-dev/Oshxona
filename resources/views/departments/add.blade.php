@extends('layouts.app')

@section('title', 'Bo\'limlar')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bo'limlar</h1>
        <a href="{{route('departments.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Ortga</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bo'lim qo'shish</h6>
        </div>
        <form method="POST" action="{{route('departments.store')}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">


                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kodi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('code') is-invalid @enderror"
                            id="exampleCode"
                            placeholder="Kodi"
                            name="code"
                            value="{{ old('first_name') }}">

                        @error('first_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>


                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nomi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('name') is-invalid @enderror"
                            id="exampleName"
                            placeholder="Nomi"
                            name="name"
                            value="{{ old('name') }}">

                        @error('last_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Saqlash</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('departments.index') }}">Bekor qilish</a>
            </div>
        </form>
    </div>

</div>


@endsection
