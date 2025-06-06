<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head class="bg-dark text-white">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-adsense-account" content="ca-pub-6400123273776448">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ናሆም ኣፕ') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<style>

    @media (max-width: 576px) {
        .nav-tabs .nav-link {
            font-size: 14px;
            padding: 8px;
        }
    }

    /* resources/css/app.css */
@media (max-width: 767px) {
    .mobile-stack {
        flex-direction: column !important;
    }

    .mobile-small-text {
        font-size: 0.9rem;
    }

    .mobile-hide-extra {
        display: none;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .nav-tabs .nav-item {
        flex: 1;
        text-align: center;
    }

    .player-card {
        margin-bottom: 1rem;
    }

    .form-control {
        font-size: 14px;
    }
}


</style>
<body class="bg-dark text-white">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'ናሆም ኣፕ') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
@auth
                        @if(Auth::user() === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">{{ __('admin') }}</a>
                            </li>

                        @endif
                        @endauth
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
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
    <div class="container mt-4">
   <h1 class="text-center mb-4">Nay Eritrea Ketematat Xewta Ab Nederland(Holland) 2025<br> ናይ ኤርትራ ከተማታት ጸውታ ኣብ    ነዘርላንድ (ሆላንድ)     2025</h1>

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="fixtures-tab" data-bs-toggle="tab" data-bs-target="#fixtures" type="button" role="tab" aria-controls="fixtures" aria-selected="true">
                gtmat
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="standings-tab" data-bs-toggle="tab" data-bs-target="#standings" type="button" role="tab" aria-controls="standings" aria-selected="false">
                dereja
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="playersLists-tab" data-bs-toggle="tab" data-bs-target="#playersLists" type="button" role="tab" aria-controls="playersLists" aria-selected="false">
                texawati
            </button>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="players-tab" data-bs-toggle="tab" data-bs-target="#players" type="button" role="tab" aria-controls="players" aria-selected="false">
                amezgebti
            </button>
        </li>

    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade" id="playersLists" role="tabpanel" aria-labelledby="playersLists-tab">
            <div class="card mt-2">
                <div class="card-body">
                    <h2 class="text-center mb-3">texawti nay gantata</h2>
                    <div class="mb-4">
        <input type="text"
            wire:model.live="search"
            placeholder="texaweti dle abazi..."
            class="form-control">
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($players as $player)
            <div class="col-md-4 mb-4">
                <div class="card player-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ $player->name }}</h5>
                    </div>

                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img   src="{{ $player->photo ? asset('storage/'.$player->photo) : asset('images/default-player.jpg') }}" style="width: 50px; height: 50px;"
                                class="img-fluid rounded-circle player-photo"
                                alt="{{ $player->name }}">
                        </div>
                        <div class="player-info">
                            <p class="mb-1">
                                <strong>ganat:</strong> {{ $player->club->name }}
                            </p>
                            <p class="mb-1">
                                <strong>bota zselfelu:</strong> {{ $player->position }}
                            </p>
                            <p class="mb-0">
                                <strong>Tqlal shto:</strong>
                                <span class="badge bg-success">
                                    {{ $player->total_goals }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
                </div>
            </div>
        </div>
        <!-- Fixtures Tab -->
        <div class="tab-pane fade show active" id="fixtures" role="tabpanel" aria-labelledby="fixtures-tab">
            <div class="card mt-2">
                <div class="card-body">
                    <livewire:ManageFixtures />
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="players" role="tabpanel" aria-labelledby="players-tab">
            <div class="card mt-2">
                <div class="card-body">
                    <livewire:playerCards />
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="standings" role="tabpanel" aria-labelledby="standings-tab">
            <div class="card mt-2">
                <div class="card-body">
                    <livewire:ManageStandings />

                </div>
            </div>
        </div>
        </div>
</div>
   <footer class="bg-light text-dark text-center py-3">
        <div class="container">
            <div class="row mt-2">
                <div class="col-md-12">
                    <a href="https://github.com/nahom17" target="_blank" class="social-icon"><i
                            class="fab fa-github fa-2x"></i></a>
                    <a href="https://nahomtesfamichael.com" target="_blank" class="web-icon"><i
                            class="fab fa-github fa-2x"></i></a>
                    <a href="https://www.youtube.com/channel/UCIMHXf1qvVBxoYfWFpk9hiw?view_as=subscriber" target="_blank"
                        class="social-icon"><i class="fab fa-youtube fa-2x"></i></a>
                    <a href="https://www.facebook.com/nahom.tesfamichael.90" target="_blank" class="social-icon"><i
                            class="fab fa-facebook fa-2x"></i></a>
                    <a href="https://www.linkedin.com/in/nahom-tesfamichael-87a2a7135/" target="_blank"
                        class="social-icon"><i class="fab fa-linkedin fa-2x"></i></a>
                    <a href="https://www.instagram.com/nahom.info.tube/" target="_blank" class="social-icon"><i
                            class="fab fa-instagram fa-2x"></i></a>
                    <a href="https://www.instagram.com/auto_theorie_vragen/" target="_blank" class="social-icon"><i
                            class="fab fa-instagram fa-2x"></i></a>
                    &copy;
                    <script>document.write(new Date().getFullYear())</script> Nahom Tesfamichaeled
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @livewireScripts
</body>
</html>

