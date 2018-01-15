<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/css/app.css">
    <link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/css/index.css">
    <link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/font-awesome-4.7.0/css/font-awesome.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="searchBody">
<section id="app">

 <!--
    **
     * the menu
     *
     * lead to different pages
     * 
 	**
 -->

@include('menu')
@include('menuMobile')

<!--
    **
     * display selected location
     *
     * body of page
     * 
 	**
 -->
 <section class="musicSearch">
     <div class="container">
        <div class="row">
            <div class="col-xs-offset-3 col-md-offset-4 col-8 mt-5 mb-2">
                <h1 class="color_white">
                    <i class="fa fa-music" aria-hidden="true"></i>
                    Search Now
                </h1>
            </div>
            <div class="col-xs-offset-3 col-6 col-md-offset-4 col-sm-8 col-md-6 col-lg-4">
                <form 
                action="/searchSingers"
                method="post" 
                class="d-flex justify-content-center align-items-center searchWrapper">
                {{ csrf_field() }}       
                        <input 
                        type="text" 
                        class="inputSearch" 
                        placeholder="Search your favourite singer for events" 
                        name="searchIndex">
                        
                        <button class="search-icon"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
 </section>

<!--
    **
     * 
     *
     * footer of page
     * 
 	**
 -->

@include('footer')

</body>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://musicappevents.herokuapp.com/public/js/jquery.slim.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/tether.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/bootstrap.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/app.js"></script>
</html>