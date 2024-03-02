@extends('layouts.app')

@section('title', 'Foydalanuvchilar')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Foydalanuvchilar</h1>
            <a href="{{route('users.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Ortga</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tahrirlash</h6>
            </div>
            <form method="POST" action="{{route('users.update', ['user' => $user->id])}}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">

                        {{-- Email --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span><label>Email</label>
                            <input
                                type="email"
                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                id="exampleEmail"
                                placeholder="Email"
                                name="email"
                                value="{{ old('email') ? old('email') : $user->email }}">

                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span><label>Parol</label>
                            <input
                                type="password"
                                class="form-control form-control-password @error('password') is-invalid @enderror"
                                id="examplePassword"
                                placeholder="Parol"
                                name="password"
                                value="{{ old('password') }}">
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">O'zgartirish</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('users.index') }}">Bekor qilish</a>
                </div>
            </form>
        </div>

    </div>


@endsection
