<?php

namespace App\Http\Controllers;

use App\singers;
use Illuminate\Http\Request;

class singersSongs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(singers $singer)
    {
        $song = $singer->song()->get();
        $instance = $song->first()->transformer;
        $song = fractal($song,new $instance);
        return response()->json(["songs"=>$song],200);
    }
}