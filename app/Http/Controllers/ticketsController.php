<?php

namespace App\Http\Controllers;

use App\Transformers\ticketTransformer;
use App\tickets;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ticketsController extends Controller
{
    public function index(tickets $tickets){
    	
    	$collection = $tickets::all();
    	
    	// data sort 

    	$request = request('sort_by');
    	$index = ticketTransformer::index($request);
    	$sortedData = $collection->sortBy($index);
    	$sortedData = $this->paginator($sortedData);


    	//filter data

  //   	$indexZ = request('filter');
		// $filterationIndex = ticketTransformer::index($indexZ);
  //   	$sortedData->where($indexZ,'filterationIndex')

    	// transformer

    	$instance = $collection->first()->transformer;
    	$transformedCollection = fractal($sortedData,$instance);

    	return response()->json(['tcikets'=>$transformedCollection],200);
    }
public function paginator($collection){
	$page = LengthAwarePaginator::resolveCurrentPage();
	$perPage = 2 ;
	$results = $collection->slice(($page-1)*$perPage,$perPage);
	$paginated = new LengthAwarePaginator($results,$collection->count(),$perPage,$page,[
		'path'=>LengthAwarePaginator::resolveCurrentPage()
	]) ;
	$paginated->appends(request()->all());
	return $paginated;
}
}
