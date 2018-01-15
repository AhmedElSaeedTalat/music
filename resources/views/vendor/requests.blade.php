<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/index.css')}}">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="requestVendorsBody">
<section id="app" class="mt-4">

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
   * table to accept vendors
   *
   * body of the page
   * 
  **
 -->
<section class="adminRequests mt-5">
  	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="color_white">Vendors Requests</h1>
			</div>
				</div><!-- row-->
        <div class="row mt-5 headLine">
           <div class="col-1">
            <p class="mb-0">number</p>
          </div>
           <div class="col-2">
              <p class="mb-0">Vendor Name:</p>
            </div>
           <div class="col-1">
              <p class="mb-0">Address</p>
            </div>
             <div class="col-3">
              <p class="mb-0">email</p>
            </div>
             <div class="col-1">
              <p class="mb-0">Profits</p>
            </div>
           <div class="col-2">
             <p class="mb-0"> User Name</p>
            </div>
            <div class="col-2">
              <p class="mb-0">Action</p>
            </div>
        </div><!-- row-->
      </div>
        <form class="container vendorBorder" method="post" action="/requestsprocessed" @submit.prevent='saveChanges'>
            {{csrf_field()}}
            @for($x = 0 ,$y=0 ; $x < count($requests),$y < count($userNames) ; $x++,$y++)
            <div class="row d-flex align-items-center <?php if($x % 2 == 0){echo 'bg_grey'; } else { echo 'bg_black' ;} ;?>">
                <div class="col-1  mb-2 ">
                  <p class="color_white mb-0">{{$x}}</p>
                </div>
                <div class="col-2  mb-2 "> 
                  <p class="color_white mb-0">{{$requests[$x]->vendorName}}</p>
               </div>
                <div 
                class="col-1 mb-2"
                > 
                   <p class="color_white mb-0">{{$requests[$x]->address}}</p>
                </div>
                <div class="col-3"> 
                    <p class="color_white mb-0">{{$requests[$x]->email}}</p>
                </div>
                <div class="col-1"> 
                   <p class="color_white mb-0"> {{$requests[$x]->sellingRate}}</p>
                 </div>
                 <div class="col-2"> 
                    <p class="color_white mb-0">{{$userNames[$y]}}</p>
                 </div>
                 <div class="col-1">
                  @if($requests[$x]->request_proccess == "accept")
                   <i class="fa fa-check accepts " aria-hidden="true" ></i>
                  @else 
                    <div @click="accept(`{{$requests[$x]->id}}`,`{{$x}}`)">
                      <p class="color_white accept accepts secondArg"   >accept</p>  
                    </div>
                     
                  @endif
                  </div>
                  <div class="col-1">
                  @if($requests[$x]->request_proccess == "reject")
                    <i class="fa fa-times rejects" aria-hidden="true"></i>
                  @else 
                      <div @click="reject(`{{$requests[$x]->id}}`,`{{$x}}`)">
                        <p class="color_white accept rejects"  >reject</p>
                      </div>   
                  @endif
                  </div>
             </div><!-- row -->
             @endfor
             <button class="btn btn-warning">Save Changes</button>    
     </form>
</section>
</section>
	<script src="http://localhost:8000/js/app.js"></script>
</body>
</html>