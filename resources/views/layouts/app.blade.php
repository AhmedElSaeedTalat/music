<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/css/app.css">
    <link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/css/index.css">
    <link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/font-awesome-4.7.0/css/font-awesome.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="login">
    <div id="app"> 
        @guest
        <section class="loginNav">
             <div class="container h-100">
                <div class="row h-100">
                    <div class="col-lg-2 col-lg-offset-10 d-flex align-items-center h-100">
                         <li><a href="{{ route('login') }}">Login</a></li>
                         <li><a href="{{ route('register') }}">Register</a></li>
                    </div>
                </div>
            </div>
        </section>                        
        @else
        
        @include('menu')
        @include('menuMobile')
        
        @endguest
        @yield('content')
    </div>
    <!-- Scripts -->
<script src="https://js.stripe.com/v3/"></script>
<script src="https://musicappevents.herokuapp.com/public/js/jquery.slim.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/tether.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/bootstrap.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/app.js"></script>
</body>
</html>
