@extends('layouts.app')

@section('title', 'Menyular')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Menyular</h1>
            <a href="{{route('shifts.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Ortga</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Menyuni tahrirlash</h6>
            </div>
            <form method="POST" action="{{ route('meals.update', $meal->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12 col-lg-6">
                            <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span><label>Nomi</label>
                                <input type="text"
                                       class="form-control form-control-user @error('name') is-invalid @enderror"
                                       placeholder="Nomi"
                                       name="name" id="name" value="{{ old('name', $meal->name) }}">

                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                            </div>
                            <div class="col-sm-12 mb-3 mt-3 mb-sm-0">

                                <label for="description">Tavsif:</label>
                                <textarea name="description" id="description" class="form-control">
                                    {{ old('description', $meal->description) }}
                                </textarea>

                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                                <label for="photo">Rasm:</label>
                                <input type="file" name="photo" id="photo" class="form-control-file">
                                @error('photo')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <img src="{{ asset('storage/meals/photos/' . $meal->photo) }}" alt="Current Photo" style="max-width: 100px; margin-top: 10px;">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Saqlash</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('meals.index') }}">Bekor qilish</a>
                </div>
            </form>

        </div>

    </div>

@endsection
