<?php

namespace App\Http\Controllers;

use App\album;
use Illuminate\Http\Request;

class albumsSingers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(album $album)
    {
         $singer = $album->singers()->get();
         $instance = $singer[0]->transformer;
         $singer = fractal($singer, new $instance);
        return response()->json(['singers'=>$singer],200);
    }
}
