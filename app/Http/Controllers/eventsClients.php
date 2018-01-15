<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;

class eventsClients extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Events $event)
    {
       $clients = $event->vendor()
                        ->whereHas("ticketed.client.user")
                        ->with("ticketed.client.user")
                        ->get()
                        ->pluck("ticketed")
                        ->collapse()
                        ->pluck("client")
                        ->collapse()
                        ->pluck("user.name")
                        ->unique();
       if(empty($clients[0])){
        return response()->json(["event"=>$event,"error"=>"no attached users are to this event"]);
       }
        return response()->json(["event"=>$event,"client name" => $clients],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
