<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;

class eventsTickets extends Controller
{
    public function index(Events $event)
    {
    	$tickets = $event->tickets()->get();
    	$instance = $tickets->first()->transformer;
    	$transformer = fractal($tickets,new $instance);
    	return response()->json(['tickets'=>$transformer],200);
    }
}
