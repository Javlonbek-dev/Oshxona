@extends('layouts.app')

@section('title', 'Foydalanuvchilar')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Foydalanuvchilar</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Qo'shish
                    </a>
                </div>
{{--                <div class="col-md-6">--}}
{{--                    <a href="{{ route('users.export') }}" class="btn btn-sm btn-success">--}}
{{--                        <i class="fas fa-check"></i> Export to excel--}}
{{--                    </a>--}}
{{--                </div>--}}

            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Barchasi</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th width="20%">Bo'limi</th>
                            <th width="20%">Foydalanuvchi ismi</th>
                            <th width="10%">Email</th>
                            <th width="14%">Telefon raqami</th>
                            <th width="5%"><i class="fa fa-sliders"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $uKey => $user)
                            <tr>
                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $uKey + 1 }}</td>
                                <td>{{ $user->department?->name }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile_number }}</td>
                                <td style="display: flex; padding: 0">

                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                       class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    @if($user->role_id != 1)
                                        <a class="btn btn-danger delete-model m-2" href="#"
                                           onclick="loadDeleteModal({{ $user->id }})">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $users->links() }}
                </div>
            </div>
        </div>

    </div>

    @include('users.delete-modal')

@endsection

@section('scripts')
    <script>
        function loadDeleteModal(id) {
            var route = '{{ route("users.destroy", ":user") }}';
            route = route.replace(':user', id);
            $('#user-delete-form').attr('action', route);
            $('#deleteModal').modal('show');
        }
    </script>

@endsection
