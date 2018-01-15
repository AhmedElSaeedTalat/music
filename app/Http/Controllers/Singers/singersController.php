<?php

namespace App\Http\Controllers\Singers;

use App\Http\Controllers\Controller;
use App\Transformers\singerTransformer;
use App\singers;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class singersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(singers $singers)
    {
        $collection = $singers::all();
        $collection = $this->paginator($collection);
        $instance = $collection->first()->transformer;
        $transformer = fractal($collection,$instance);
        return response()->json(['singers'=>$transformer],200);
    }
   
    /**
     * Singers Paginator.
     *
     *  here is the paginating system for the Singers
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(singers $singer)
    {
         $instance = $singer->transformer;
         $singer = fractal($singer, new $instance);
        return response()->json(['singers'=>$singer],200);
    }
   
   /**
     * Store new Singer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function store()
    {
        $singer = request('singer');
        $image = request('image');
        $description = request('description');
        $birth = request('birth');
        if($image){
        $imageName = $image->hashName();
        $image->store("/images");    
        }
       $singer = singers::create([
            'singerName' => $singer,
            'image'=> $imageName,
            'bio' => $description,
            'dateOB' =>$birth, 
            ]);
       $instance = $singer->transformer;
       $transformer = fractal($singer,new $instance);
       return response()->json(["singer",$transformer],200);
    }
}
