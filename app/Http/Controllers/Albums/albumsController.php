<?php

namespace App\Http\Controllers\Albums;

use App\Http\Controllers\Controller;
use App\album;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class albumsController extends Controller
{
	/**
     * Show All albums .
     *
     *  All Albums are displayed 
     */
    
    public function index()
    {
    	$album = new album;
    	$albums = $album->all();
    	$album = $this->paginator($albums);
    	$instance = $albums->first()->transformer;
    	$album = fractal($album,new $instance);
    	return response()->json(["albums"=>$album],200);
    }

    /**
     *  Paginator.
     *
     *  here is the paginating system 
     */

    public function paginator($collection){
        
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $results = $collection->slice(($page-1)*$perPage,$perPage);
        $paginated = new LengthAwarePaginator($results,$collection->count(),$perPage,$page,[
            'path' => LengthAwarePaginator::resolveCurrentPage(),
        ]);
        $paginated->appends(request()->all());
        return $paginated;
    }
     /**
     *  Event show.
     *
     *  here we show the mentioned informaion 
     */

     public function show(album $album){

    	$instance = $album->transformer;
        $transform = fractal($album,new $instance);
      
         return response()->json(['album',$transform],200);
    }
}
