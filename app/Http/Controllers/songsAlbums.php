<?php

namespace App\Http\Controllers;

use App\songs;
use Illuminate\Http\Request;

class songsAlbums extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(songs $song)
    {
        $album = $song->album()->get();
        $instance = $album[0]->transformer;
        $transform = fractal($album,new $instance);
        return response()->json(['album',$transform],200);
    }
}
