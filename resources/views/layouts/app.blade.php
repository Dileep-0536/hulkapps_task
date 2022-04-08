<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Task') }}</title>
    <!-- Fonts -->
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> 
</head>
<body>
<!-- loader -->
<div class="loader"></div>
    <div id="app">
        <!-- header -->
        <nav class="navbar navbar-expand-lg navbar-light shadow-lg p-3 mb-5 bg-light rounded">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Task') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav">
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
                            <li class="nav-item">
                                    <a type="button" class='nav-link' id='logout_btn' href='#'>
                                        {{ __('Logout') }}
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @include('layouts.side_menu')
        <!-- main body content -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<!-- scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script>
// loading loader
$(window).on('load',function() {
    $(".loader").fadeOut("slow");
});

//checking user is logged or not
var loggedIn = "{{ auth()->check() ? 'true' : 'false' }}";

//logout through ajax
$(document).ready(function(){
    $("#logout_btn").click(function(e){
        e.preventDefault();
        localStorage.clear();
        var dest_url = "{{ route('logout') }}";
        $.ajax({
            type:"POST",
            url:dest_url,
            headers: {'X-CSRF-Token': $('meta[name="_token"]').attr('content')},
            dataType:"JSON",
            success: function(res){
                if(res.success) {
                    alert(res.data);
                    setTimeout(() => {
                        window.location.replace("{{ url('/') }}");
                    }, 1000);
                }
            }
        });
    });
});
</script>
<!-- other scripts -->
@stack('scripts')
</html>