@section('front.nav')
    <nav class="w-full h-[80px] flex justify-around place-items-center px-5 bg-[#1D4ED8]">
        <div class="w-[28%]">
            <img class="w-[100%]" src="{{ asset('storage/img/logo-2.png') }}" alt="">
        </div>
        <div class="w-full me-10">
            <ul class="flex justify-center place-items-center gap-[2rem] ">
                <li class="font-normal font-xl "><a href="{{ route('viewHome') }}" class="text-white">Home</a></li>
                <li class="font-normal font-xl "><a href="{{ route('customerSalesTable') }}" class="text-white">Customer Sale Page</a></li>
                <li class="font-normal font-xl "><a href="{{ route('customerLeadTable') }}" class="text-white">Customer Lead Page</a></li>
                <li class="font-normal font-xl "><a href="{{ route('customerTrialTable') }}" class="text-white">Customer Trial Page</a></li>
                <li class="font-normal font-xl "><a href="{{ route('viewHelpTable') }}" class="text-white">Help </a></li>
                <li class="font-normal font-xl "><a href="{{ route('help')  }}" class="text-white">Help Request</a></li>
            </ul>
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
