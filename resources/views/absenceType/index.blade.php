@extends('layouts.app')

@section('title', 'Ish kelmaslik sabablari')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ishga kelmaslik sabablari</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('absenceTypes.create') }}" class="btn btn-sm btn-primary">
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
                            <th width="89%">Nomi</th>
                            <th width="10%"><i class="fa fa-sliders"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($absenceTypes as $aKey => $absenceType)
                            <tr>
                                <td>{{ ($absenceTypes->currentPage() - 1) * $absenceTypes->perPage() + $aKey + 1 }}</td>

                                <td>{{ $absenceType->name }}</td>

                                <td style="display: flex; padding: 0">
                                    <a href="{{ route('absenceTypes.edit', ['absenceType' => $absenceType->id]) }}"
                                       class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger delete-model m-2" href="#"
                                       onclick="loadDeleteModal({{ $absenceType->id }})">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $absenceTypes->links() }}
                </div>
            </div>
        </div>

    </div>

    @include('absenceTypes.delete-modal')

@endsection

@section('scripts')
    <script>
        function loadDeleteModal(id) {
            var route = '{{ route("absenceTypes.destroy", ":absenceType") }}';
            route = route.replace(':absenceType', id);
            $('#absence-type-delete-form').attr('action', route);
            $('#deleteModal').modal('show');
            console.log(route);
        }
    </script>
@endsection
