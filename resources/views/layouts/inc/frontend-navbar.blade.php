<div class="global-navbar">
    <div class="container">

        <div class="row">
            <div class="col-md-4">

            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">

        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">Custom Nieuws</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ms-5" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav">
                    <a class="nav-link" href="{{ route('articles.index') }}">Artikelen</a>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.index') }}">Projecten</a>
                    </li>

                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.productIndex') }}">Producten</a>
                    </li>

                </ul>


                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <div class="widget-header">
                        <a href="{{ route('cart.index') }}" class="icontext">
                            <div class="icon-wrap icon-xs bg2 round text-secondary"><i
                                    class="fa-solid fa-cart-shopping"></i></div>
                        </a>
                    </div>
                    @if (isset(Auth::user()->role_id) && Auth::user()->role_id == '1')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.articles.index') }}">Admin</a>
                        </li>
                    @endif
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Inloggen') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registreren') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img class="card-img-top" style="width:30px; height:30px; border-radius:7pc; opacity:1;"
                                    src="{{ asset('uploads/avatar/' . Auth::user()->avatar) }}">{{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @php
                                    $posts = App\Models\Article::all();
                                @endphp
                                @php
                                    $users = App\Models\User::all();
                                @endphp
                                @php
                                    $projects = App\Models\Project::all();
                                @endphp
                                {{-- <a href="{{route('myprofile',['user'])}}" class="dropdown-item">Mijn profiel</a> --}}
                            {{-- <a href="{{ route('post.myposts')}}" class="dropdown-item">Mijn artikelen</a>
                            <a href="{{ route('user.projects.myprojects')}}" class="dropdown-item">Mijn projecten</a>
                            <a href="{{ route('open') }}" class="dropdown-item">Mijn taken</a>
                                <a href="{{ route('home') }}" class="dropdown-item">Home</a>
                                <a href="{{ route('profile.profile') }}" class="dropdown-item">Mijn Profile</a>
                                <a href="{{ route('articles.myArticles')}}" class="dropdown-item side-menu">Mijn artikelen</a>
                                <a href="{{ route('projects.myProjects')}}" class="dropdown-item side-menu"> Mijn projecten</a>
                                <a href="{{ route('tasks.openTask')}}" class="dropdown-item side-menu"> Mijn taken</a> --}}
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    {{ __('Uitloggen') }}
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
</div>
