<?php

use App\Events;
use App\TicketedUsers;
use App\TicketsRequests;
use App\User;
use App\album;
use App\client;
use App\groupSingers;
use App\seller;
use App\singers;
use App\songs;
use App\tickets;
use App\vendorData;
use App\vendors;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	      album::truncate();
	      client::truncate();
	      Events::truncate();
	      groupSingers::truncate();
	      singers::truncate();
	      songs::truncate();
	      TicketedUsers::truncate();
	      tickets::truncate();
	      TicketsRequests::truncate();
	      User::truncate();
	      seller::truncate();
	      vendorData::truncate();

	      // singers::flushEventListeners();
	      // groupSingers::flushEventListeners();

		  DB::table("siger_songs")->truncate();
	      factory("App\User",20)->create();
		  factory("App\Events",20)->create();;
		  $user = User::where('vendor','vendor')->get();
		  $number = $user->count();
	      factory("App\seller",$number)->create();
		  factory('App\tickets',20)->create();
		  factory("App\client",20)->create();
		  factory("App\TicketsRequests",20)->create();
		  factory("App\TicketedUsers",20)->create();
  		  factory("App\songs",20)->create();
		  factory("App\album",20)->create();
		  factory("App\groupSingers",20)->create();
		  factory("App\singers",20)->create();
		  // factory("App\vendor_datas",20)->create();
		  
		  // relationships
		  //****************

		  // Events - sellers

		  App\Events::all()->each(function($event){
		  	$vendor = App\seller::all()->random();
		  	$event->vendor()->attach($vendor);
		  });

		  // Events - singers
		  
		  App\Events::all()->each(function($event){
		  	$singer = App\singers::all()->random();
		  	$event->singer()->attach($singer);
		  });

		  // Events - groupSingers

		  App\Events::all()->each(function($event){
		  	$groupSingers = App\groupSingers::all()->random();
		  	$event->groupSingers()->attach($groupSingers);
		  });

		  // vendor - ticket

		  App\seller::all()->each(function($seller){
		  	$ticket = App\tickets::all()->random();
		  	$seller->ticket()->save($ticket);
		  });

		  // client - requests

		  App\client::all()->each(function($event){
		  	$TicketsRequests = App\TicketsRequests::all()->random();
		  	$event->TicketsRequests()->attach($TicketsRequests);
		  });

		 // vendor - ticketed

		  App\client::all()->each(function($event){
		  	$TicketsRequests = App\TicketedUsers::all()->random();
		  	$event->TicketedUsers()->attach($TicketsRequests);
		  });

		  // album - songs 

		  App\album::all()->each(function($album){
		  	$songs = App\songs::all()->random();
		  	$album->songs()->save($songs);
		  });

		  //gp-singers - singers

		  App\groupSingers::all()->each(function($gp){
		  	$singers = App\singers::all()->random();
		  	$singers1 = App\singers::all()->random();
		  	$singers2 = App\singers::all()->random();
		  	$gp->singers()->saveMany([$singers,$singers1,$singers2]);
		  });

		   // gp-singers - album

		  App\groupSingers::all()->each(function($gp){
		  	$album = App\album::all()->random();
		  	$gp->singers()->save($album);
		  });

		  // gp-singers - songs

		  App\groupSingers::all()->each(function($gp){
		  	$songs = App\songs::all()->random();
		  	$gp->singers()->save($songs);
		  });

		  // singer - songs

		  App\singers::all()->each(function($singer){
	    	$songs = new songs;
	    	$filtered = $songs->all()->filter(function($song){
	    		if($song->groupSingers_id == null){
	    			return $song;
	    		}
	    	});
	    	$x = $filtered->random();
		  	$singer->song()->attach($x);
		  });

		  // singers - album

		  App\singers::all()->each(function($singer){
		  	$album = App\album::all()->random();
		  	$singer->album()->save($album);
		  });

		 App\seller::all()->each(function($seller){
				
			  $user = User::where('vendor','vendor')->get();
		      $id = $user->random()->id;
		      $seller->user_id = $id;
		      $seller->save();
		 });
    }
}
