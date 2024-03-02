@extends('layouts.app')

@section('title', 'Hodimlar')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hodimlar</h1>
        <a href="{{route('employees.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Ortga</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Hodimni tahrirlash</h6>
        </div>
        <form method="POST" action="{{route('employees.update', ['employee' => $employee->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">


                    <div class="col-sm-4 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span><label>Ismi</label>
                        <input
                            type="text"
                            class="form-control form-control-employee @error('first_name') is-invalid @enderror"
                            id="exampleFirstName"
                            placeholder="Ismi"
                            name="first_name"
                            value="{{ old('first_name') ?  old('first_name') : $employee->first_name}}">

                        @error('first_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-4 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span><label>Familiya</label>
                        <input
                            type="text"
                            class="form-control form-control-employee @error('last_name') is-invalid @enderror"
                            id="exampleLastName"
                            placeholder="Familiya"
                            name="last_name"
                            value="{{ old('last_name') ? old('last_name') : $employee->last_name }}">

                        @error('last_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-4 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span><label>Otasini ismi</label>
                        <input
                            type="text"
                            class="form-control form-control-employee @error('middle_name') is-invalid @enderror"
                            id="exampleMiddleName"
                            placeholder="Otasini ismi"
                            name="middle_name"
                            value="{{ old('middle_name') ? old('middle_name') : $employee->middle_name }}">

                        @error('middle_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tabel --}}
                    <div class="col-sm-4 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span><label>Kodi (ID)</label>
                        <input
                            type="text"
                            class="form-control form-control-employee @error('tabel') is-invalid @enderror"
                            id="exampleTabel"
                            placeholder="Kodi (ID raqami)"
                            name="tabel"
                            maxlength="4"
                            value="{{ old('tabel') ? old('tabel') : $employee->tabel }}">

                        @error('tabel')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Mobile Number --}}
                    <div class="col-sm-4 mb-3 mt-3 mb-sm-0">
                        <label>Telefon raqami</label>
                        <input
                            type="text"
                            class="form-control form-control-employee @error('mobile_number') is-invalid @enderror"
                            id="exampleMobile"
                            placeholder="Telefon raqami"
                            name="mobile_number"
                            value="{{ old('mobile_number') ? old('mobile_number') : $employee->mobile_number }}">

                        @error('mobile_number')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- PNFL --}}
                    <div class="col-sm-4 mb-3 mt-3 mb-sm-0">
                        <label>JSHSHIR</label>
                        <input
                            type="text"
                            class="form-control form-control-employee @error('pnfl') is-invalid @enderror"
                            id="exampleMobile"
                            placeholder="(STIR) Jismoniy shaxning shaxsiy id raqami"
                            name="pnfl"
                            value="{{ old('pnfl') ? old('pnfl') : $employee->pnfl }}">

                        @error('pnfl')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Department --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span><label>Bo'limi</label>
                        <select class="form-control form-control-employee @error('department_id') is-invalid @enderror" name="department_id">
                            <option selected disabled>Bo'limni tanlang</option>
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}"
                                    {{old('department_id') ? ((old('department_id') == $department->id) ? 'selected' : '') : (($employee->department_id == $department->id) ? 'selected' : '')}}>
                                    {{$department->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Position --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span><label>Lavozimi</label>
                        <select class="form-control form-control-employee @error('position_id') is-invalid @enderror" name="position_id">
                            <option selected disabled>Lavozimni tanlang</option>
                            @foreach ($positions as $position)
                                <option value="{{$position->id}}"
                                    {{old('position_id') ? ((old('position_id') == $position->id) ? 'selected' : '') : (($employee->position_id == $position->id) ? 'selected' : '')}}>
                                    {{$position->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-employee float-right mb-3">O'zgartirish</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('employees.index') }}">Bekor qilish</a>
            </div>
        </form>
    </div>

</div>


@endsection
