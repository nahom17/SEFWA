<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head class="bg-dark text-white">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-adsense-account" content="ca-pub-6400123273776448">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'nahomApp') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<style>


.social-icons {
        margin-bottom: 1.5rem;
    }

    .social-link {
        margin: 0 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    /* Brand Colors */
    .github { color: #ffffff; } /* GitHub white */
    .github:hover { color: #6cc644; } /* GitHub green */

    .website { color: #ffffff; } /* Default white */
    .website:hover { color: #2aa8d0; } /* Web blue */

    .youtube { color: #ff0000; } /* YouTube red */
    .youtube:hover { color: #cc0000; } /* Darker red */

    .facebook { color: #3b5998; } /* Facebook blue */
    .facebook:hover { color: #2d4373; } /* Darker blue */

    .linkedin { color: #0077b5; } /* LinkedIn blue */
    .linkedin:hover { color: #005582; } /* Darker blue */

    .instagram { color: #e1306c; } /* Instagram pink */
    .instagram:hover { color: #c13584; } /* Darker pink */

    /* Optional: Add animation on hover */
    .social-link:hover {
        transform: translateY(-3px);
    }

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
        
        @Auth
        @if(Auth::user()->role === "admin")
        <a href="https://nahomapp.com/admin">
            <button class="btn btn-info end">admindashbord</button>
        </a>
        @endif
        @endauth
    <h1 class="text-center mb-4">Nay Eritrea Ketematat Xewta Ab Nederland(Holland) 2025<br> ናይ ኤርትራ ከተማታት ጸውታ ኣብ    ነዘርላንድ (ሆላንድ)     2025</h1>

    <!-- Nav Tabs -->
      <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="fixtures-tab" data-bs-toggle="tab" data-bs-target="#fixtures" type="button" role="tab" aria-controls="fixtures" aria-selected="true">
            Gtmat <br> ግጥማት 
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="standings-tab" data-bs-toggle="tab" data-bs-target="#standings" type="button" role="tab" aria-controls="standings" aria-selected="false">
            Dereja <br> ደረጃ
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="players-tab" data-bs-toggle="tab" data-bs-target="#players" type="button" role="tab" aria-controls="players" aria-selected="false">
            Amezgebti <br> ኣመዝገብቲ
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="playersLists-tab" data-bs-toggle="tab" data-bs-target="#playersLists" type="button" role="tab" aria-controls="playersLists" aria-selected="false">
            hgata xewta <br> ሕግታት ጸውታ
        </button>
    </li>
</ul>



    <!-- Tab Content -->
  <div class="tab-content mt-3" id="myTabContent">
       <div class="tab-pane fade" id="players" role="tabpanel" aria-labelledby="players-tab">
        <div class="card mt-2">
            <div class="card-body">
                <livewire:playerCards />
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
     <div class="tab-pane fade" id="playersLists" role="tabpanel" aria-labelledby="playersLists-tab">
        <div class="card mt-2">
            <div class="card-body">
                <livewire:add-club />
            </div>
        </div>
    </div>

    <!-- Standings Tab -->
    <div class="tab-pane fade" id="standings" role="tabpanel" aria-labelledby="standings-tab">
        <div class="card mt-2">
            <div class="card-body">
                <livewire:ManageStandings />
            </div>
        </div>
    </div>

    <!-- Players Tab (Check if Livewire Component Exists) -->
   

    <!-- League Rules Tab (Check if Livewire Component Exists) -->
   
    
    
</div>


   <footer class="bg-dark text-white text-center py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="social-icons">
                    <!-- GitHub -->
                    <!-- Website -->
                    <a href="https://nahomtesfamichael.com" target="_blank" class="social-link website">
                        <i class="fas fa-globe fa-2x"></i>
                    </a>
                    
                    <!-- YouTube -->
                    <a href="https://www.youtube.com/channel/UCIMHXf1qvVBxoYfWFpk9hiw?view_as=subscriber" 
                       target="_blank" class="social-link youtube">
                        <i class="fab fa-youtube fa-2x"></i>
                    </a>
                    
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/nahom.tesfamichael.90" 
                       target="_blank" class="social-link facebook">
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>
                    
                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/in/nahom-tesfamichael-87a2a7135/" 
                       target="_blank" class="social-link linkedin">
                        <i class="fab fa-linkedin fa-2x"></i>
                    </a>
                    
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/auto_theorie_vragen/" 
                       target="_blank" class="social-link instagram">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <strong class="text-center">&copy;<script>document.write(new Date().getFullYear())</script> Nahom Tesfamichael</strong>
                <a href="https://nahomapp.com/privacy-policy" target="_blank" class="privacy-policy">
                    <li class="fab fa-policy fa-2x  text-white"> privacy-policy መሰል ብሕታውነት</li>
                </a>
            </div>
        </div>
    </div>
</footer>

<!-- Add Font Awesome CSS in your layout file -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @livewireScripts
</body>
</html>

