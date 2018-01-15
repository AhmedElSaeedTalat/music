<?php

namespace App\Http\Controllers;

use App\singers;
use Illuminate\Http\Request;

class singersAlbums extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(singers $singer)
    {
        $album = $singer->album()->get();
        $instance = $album->first()->transformer;
        $album = fractal($album,new $instance);
        return response()->json(['albums'=>$album],200);
    }

}
