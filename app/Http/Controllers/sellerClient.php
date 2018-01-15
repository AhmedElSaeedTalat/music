<?php

namespace App\Http\Controllers;

use App\client;
use App\seller;
use Illuminate\Http\Request;

class sellerClient extends Controller
{
    /**
     * display the histtory of client vendor relationship
     *
     * only admin in the page can access information
     */

    // the user of this function is to get the users who purchased tickets from each seller
    public function __construct()
    {
       $this->middleware('can:view,App\User');
    }
    public function index(Request $request,seller $seller)
    {
       $user = $seller->user()->with('ticketedUsers')->get()->pluck('ticketedUsers');
       return view('sellerClient',compact('user','seller'));
      
    }

  }