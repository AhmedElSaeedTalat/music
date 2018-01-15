<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class homeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index()
    {
        return "all Data";
    }

  
    public function show($id)
    {
        //
    }

     public function access()
    {
        return view('passport');
    

   }
     public function access1()
    {
        return view('auth');
    

   }
     public function access2()
    {
        return view('authorizationRequest');
    }
  }