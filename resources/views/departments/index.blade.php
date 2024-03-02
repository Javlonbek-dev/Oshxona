@extends('layouts.app')

@section('title', 'Bo\'limlar')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bo'limlar</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('departments.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Qo'shish
                    </a>
                </div>
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
                                <th width="9%">Kodi</th>
                                <th width="80%">Nomi</th>
                                <th width="10%"><i class="fa fa-sliders"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $dKey => $department)
                                <tr>
                                    <td>{{ ($departments->currentPage() - 1) * $departments->perPage() + $dKey + 1 }}</td>

                                    <td>{{ $department->code }}</td>
                                    <td>{{ $department->name }}</td>

                                    <td style="display: flex; padding: 0">
                                        <a href="{{ route('departments.edit', ['department' => $department->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger delete-model m-2" href="#"
                                           onclick="loadDeleteModal({{ $department->id }})">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $departments->links() }}
                </div>
            </div>
        </div>

    </div>

    @include('departments.delete-modal')

@endsection

@section('scripts')
    <script>
        function loadDeleteModal(id) {
            var route = '{{ route("departments.destroy", ":department") }}';
            route = route.replace(':department', id);
            $('#department-delete-form').attr('action', route);
            $('#deleteModal').modal('show');
            console.log(route);
        }
    </script>
@endsection

