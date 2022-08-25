@php use App\Models\Contact;use App\Models\Department;use App\Models\Report;use App\Models\User; @endphp
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ auth()->check() ? route('home') :  route('index') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    @can('viewAny',Contact::class)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contacts.index') }}">
                                <span class="bi bi-people text-info" style="font-size: 1.5rem"></span> {{ __('Contacts')
                             }}</a>
                        </li>
                    @endcan
                    @can('viewAny',User::class)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <span class="bi bi-person-workspace text-warning" style="font-size: 1.5rem"></span> {{ __('Users') }}
                            </a>
                        </li>
                    @endcan
                    @can('viewAny',Department::class)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('departments.index') }}">
                                <span class="bi bi-building text-danger" style="font-size: 1.5rem"></span> {{ __('Departments') }}
                            </a>
                        </li>
                    @endcan
                    @can('viewAny',Report::class)
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('reports.index')}}">
                                <span class="bi bi-clipboard-data text-primary" style="font-size: 1.5rem"></span> {{__('Reports')}}
                            </a>
                        </li>
                    @endcan
                @endauth
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                           v-pre>
                            {{ Auth::user()->email }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
