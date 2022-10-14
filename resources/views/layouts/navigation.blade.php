<nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container-fluid">
        @include('components.application-logo')
        <div class="d-flex justify-content-end">
            <a class="dropdown-toggle btn btn-outline-secondary rounded" href="#" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                @yield('header_dropdown_li')
                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="dropdown-item" type="submit">Sair</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
