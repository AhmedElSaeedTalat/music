<?php

namespace App\Http\Controllers;

use App\album;
use Illuminate\Http\Request;

class albumsSongs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(album $album)
    {
         $song = $album->songs()->get();
         $instance = $song[0]->transformer;
         $song = fractal($song,new $instance);
         return response()->json(['song'=>$song],200);
    }
}
