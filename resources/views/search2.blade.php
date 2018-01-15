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
 <section class="mt-5 saerchResuls">
     <div class="container">
        <div class="row">
           <div class="col-8">
               <h1 class="color_white">
                   Results
               </h1>
               <div class="wrapper">   
                   <div class="img">
                       <img src="https://musicappevents.herokuapp.com/public/images/mobile.png" alt="">
                   </div>
               </div>
               <p class="addSearch">Advert</p>
               <div class="results mt-5">
                    <p class="hover singer">Singer:</p>
                   @foreach($search as $singers)
                   <p>
                   <a href="/singer/{{$singers->id}}">{{$singers->singerName}}</a>
                    </p>
                   @endforeach
               </div>
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

<section class="searchFooter">
   @include('footer') 
</section>


</body>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://musicappevents.herokuapp.com/public/js/jquery.slim.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/tether.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/bootstrap.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/app.js"></script>
</html>