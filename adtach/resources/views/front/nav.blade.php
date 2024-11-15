@section('front.nav')
    <nav class="w-full h-[80px] flex justify-between place-items-center px-5 bg-[#25C3C6]">
        <div>
            <img class="w-[30%]" src="{{ asset('storage/img/logo.png') }}" alt="">
        </div>
        <div>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name  }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
@endsection
