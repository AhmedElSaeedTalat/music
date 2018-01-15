<?php

namespace App\Http\Controllers;

use App\Events;
use App\singers;
use Illuminate\Http\Request;

class eventSingers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Events $event)
    {
        $events = $event->singer()->get();
        $instance = $events->first()->transformer;
        $singers = fractal($events,new $instance);
        return response()->json(["singers"=>$singers],200);
    }

}