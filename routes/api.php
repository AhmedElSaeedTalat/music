<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

	Route::resource("home","Home\homeController",["only" => ["index","show"]]);

   /**
	*
	* display songs resource
	*
	*/

	Route::resource("songs","Songs\songsController",["only"=>['index','show','store']]);

   /**
	*
	* display albums resource
	*
	*/

	Route::resource("albums","Albums\albumsController",["only"=>['index','show']]);


   /**
	*
	* display Events resource
	*
	*/

	Route::resource("events","Events\loEventsController",
		["only"=>['index','show','store','destroy','update','edit']]);


   /**
	*
	* display Singers resource
	*
	*/

	Route::resource("singers","Singers\singersController",["only"=>['index','show','store']]);

   /**
	*
	* display the singers for each Event
	*
	*/

	Route::resource("events.singers","eventSingers",["only"=>["index"]]);

   /**
	*
	* display songs for each singers
	*
	*/

	Route::resource("singers.songs","singersSongs",["only"=>["index","show"]]);

  /**
	*
	* display singer for each song
	*
	*/

	Route::resource("songs.singers","songsSingers",["only"=>["index","show"]]);

	/**
	*
	* display songs for each singers
	*
	*/

	Route::resource("singers.albums","singersAlbums",["only"=>["index"]]);

	/**
	*
	* display singers for each album
	*
	*/

	Route::resource("albums.singers","albumsSingers",["only"=>["index"]]);

	/**
	*
	* display songs for each album
	*
	*/

	Route::resource("albums.songs","albumsSongs",["only"=>["index"]]);

	/**
	*
	* display album for each song
	*
	*/

	Route::resource("songs.albums","songsAlbums",["only"=>["index"]]);

	//relation between events and tickets

	Route::resource("events.tickets",'eventsTickets',["only"=>["index"]]);

   /**
	*
	*  to get token using api link
	*
	*/

	Route::post('oauth/token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
