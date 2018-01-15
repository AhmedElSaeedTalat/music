<?php

namespace App\Http\Controllers\Songs;

use App\Http\Controllers\Controller;
use App\groupSingers;
use App\singers;
use App\songs;
use Faker\Generator as Faker;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class songsController extends Controller
{

	/**
     *
     * display all songs
     *
     */

    public function index()
    {

    	$songs = new songs;
    	$song  = $songs::all();
    	$song = $this->paginator($song);
    	$instance = $song->first()->transformer;
    	$song = fractal($song,new $instance);
    	return response()->json(['data'=>$song],200);
	}
   
   /**
     * songs Paginator.
     *
     *  here is the paginating system for the Songs
     */

public function paginator($collection)
{
	$page = LengthAwarePaginator::resolveCurrentPage();
	$perPage = 10;
	$results = $collection->slice(($page-1)*$perPage,$perPage);
	$paginator = new LengthAwarePaginator($results,$collection->count(),$perPage,$page,[
            'path' => LengthAwarePaginator::resolveCurrentPage(),
        ]);
	$paginator->appends(request()->all());
    return $paginator;
 }

   /**
     *
     * show Each Song.
     *  
     */

public function show(songs $song)
{
	 $instance = $song->transformer;
     $song = fractal($song,new $instance);
	 return response()->json(['song'=>$song],200);
}

public function store()
{
        $song = request('song');
        $singer = request('singer');
       // $sound = request('soundTrack');
        $genre = request('genre');
      //  if($sound){
       // $path = $sound->hashName();
      //  $sound->store("/sound");    
       // }
       $songs = songs::create([
            'name' => $song,
         //   'path'=> $path,
            'genre' => $genre
            ]);
       $singers = new singers;
       $id = $singers->where('singerName',$singer)->get()->pluck('id');
       $inst = new singers;
       $objectSinger = $inst->find($id[0]);
       $objectSinger->song()->save($songs);
       $instance = $songs->transformer;
       $transformer = fractal($songs,new $instance);
       return response()->json(["song",$transformer],200);
}
}