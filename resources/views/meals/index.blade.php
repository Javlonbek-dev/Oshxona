@extends('layouts.app')

@section('title', 'Ovqatlar ro\'yxati')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ovqatlar ro'yxati</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('meals.create') }}" class="btn btn-sm btn-primary">
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
                                <th width="70%">Nomi</th>
                                <th width="10%">Photo</th>
                                <th width="10%"><i class="fa fa-sliders"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($meals as $mKey => $meal)
                                <tr>
                                    <td>{{ ($meals->currentPage() - 1) * $meals->perPage() + $mKey + 1 }}</td>

                                    <td>{{ $meal->name }}</td>
                                    <td class="text-center">
                                        @if($meal->photo)
                                            <img src="{{ asset('storage/meals/photos/' . $meal->photo) }}"
                                                 alt="Meal Photo" style="max-width: 100px; max-height: 50px">
                                        @else
                                            No photo
                                        @endif

                                    </td>
                                    <td style="display: flex;">
                                        <a href="{{ route('meals.edit', ['meal' => $meal->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger delete-model m-2" href="#"
                                           onclick="loadDeleteModal({{ $meal->id }})">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $meals->links() }}
                </div>
            </div>
        </div>

    </div>

    @include('meals.delete-modal')

@endsection

@section('scripts')
    <script>
        function loadDeleteModal(id) {
            var route = '{{ route("meals.destroy", ":meal") }}';
            route = route.replace(':meal', id);
            $('#meal-delete-form').attr('action', route);
            $('#deleteModal').modal('show');
            console.log(route);
        }
    </script>
@endsection

