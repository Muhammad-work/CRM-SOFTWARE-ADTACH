@section('nav')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <div class="dropdown me-5">
                <button class="btn btn-sm btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Muhammad
                </button>
                <ul class="dropdown-menu me-5" aria-labelledby="dropdownMenuButton1">
                    <a class="dropdown-item" href=""
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="#" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </ul>
    </nav>
@endsection
