@auth
    @extends('layouts.app')

    @section('title', 'Permission Error')

    @section('content')
        <div class="container-fluid">

            <!-- 404 Error Text -->
            <div class="text-center">
                <div class="error mx-auto" data-text="404">404</div>
                <p class="lead text-gray-800 mb-5">Sahifa topilmadi!</p>
                <p class="text-gray-500 mb-0">Siz murojaat qilgan sahifa mavjud emas!</p>
                <a href="{{route('home')}}">← Asosiy sahifaga qaytish</a>
            </div>

        </div>
    @endsection
@endauth
