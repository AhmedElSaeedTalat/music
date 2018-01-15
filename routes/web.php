<?php

use App\Events\Event;
use App\Events\chating;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * 
 * display form to receive request 
 * from vendors to display their 
 * respective events on our site
 *
 */

Route::get('/myeventshome','loginHome@index')->middleware('checkAuth');

/**
 * 
 * Post request of vendors in db to 
 * check elegibility to be a vendor
 *
 */

Route::post('/requestvendor','loginHome@request');

/**
 * displays all requests from vendors   
 * to be partner   
 * the admin accept or reject the requests
 *
 */

Route::get('/vendorrequests','loginHome@admin');

/**
 *
 * vendor requests get processed based on the
 * action taken by the admin
 *
 */
Route::post('/requestsprocessed','loginHome@process');

Route::post('/xx','loginHome@give');
Route::get('/bla','loginHome@bla');
Route::get('/sara','loginHome@sara');

/**
 * displays a form to request number of tickets  
 *
 * everyone can access the page
 */

Route::get('/ticket/{id}','requestsController@ticket');

/**
 * Post ticket request in the database
 *
 */

Route::post('ticket/purchase','requestsController@makeRequest');

/**
 * display all events to the public
 *
 * everyone can access the page
 */

Route::get('/events','requestsController@events');

/**
 * post events data based on selected page
 *
 * everyone can access the page
 */

Route::post('/events','requestsController@paginateEvents');

/**
 * return events onload
 *
 * everyone can access the page
 */

Route::get('/eventsonload','requestsController@eventInfo');

/**
 * display interface to get token from specific vendor
 *
 * only admin in the page can access information
 */

Route::get('tokenInterface','requestsController@tokenInterface');

/**
 * process token response and post information in db
 *
 * only admin in the page can access information
 */

Route::post('/token/details','requestsController@tokenDetails');

/**
 * display the histtory of client vendor relationship
 *
 * only admin in the page can access information
 */

Route::resource("seller.client","sellerClient",["only"=>["index"]]);

/**
 * display image full size
 * composer require intervention/image is used
 *  using response
 */

Route::get("/fullsize/{id}","requestsController@size");

/**
 *
 * display selected singers
 *  
 */

Route::get("/singer/{id}","requestsController@singers");


/**
 *
 * display image Singers 
 * full size
 *
 */

Route::get("/image/{id}","requestsController@singersFullSize");

/**
 *
 * display related sound tracks
 * 
 * album page
 */

Route::get("/soundtrack/{id}","requestsController@soundtrack");

/**
 *
 * download selected track 
 * 
 * 
 */

Route::get("download/{id}","requestsController@download");

/**
 *
 * location
 * 
 * display selected location
 */

Route::get("location/{id}","requestsController@location");

/**
 *
 * subscription
 * 
 * handles faild subscription
 */

Route::post('stripe/webhook', 'Laravel\Cashier\WebhookController@handleWebhook');

Route::get("/subscription","loginHome@subscribe");
Route::post("/subscription","loginHome@cachier");

/**
 *
 * queries
 * 
 * query window for the customers
 */

Route::get("/query","loginHome@pusher");

/**
 *
 * handling queries
 * 
 * query window for the admins
 */

Route::get("/adminqueries","loginHome@checkComplaints");

/**
 *
 * send query to pusher
 * 
 * client side
 */

Route::post('send','loginHome@push');

/**
 *
 * send query response to pusher
 * 
 * admins side
 */

Route::post('adminSend','loginHome@adminProcess');

/**
 *
 * send user messages stored in sessions 
 * to chat page
 *
 * queries page
 */

Route::get("/chat","loginHome@clientChat");

/**
 *
 * send admin messages stored in sessions 
 * to chat page
 *
 * queries page
 */

Route::post("/usersession","loginHome@clientChatAdmin");


/**
 *
 * send user messages stored in sessions 
 * to chat page
 *
 * queries page
 */

Route::get("/adminsession","loginHome@adminsession");

/**
 *
 * send user messages stored in sessions 
 * to chat page
 *
 * to adminqueries page
 */

Route::post("/clientadmin","loginHome@clientAdmin");

/**
 *
 * logout url 
 * 
 *
 * auth
 */

Route::post("/loggingout","loginHome@loggingout");


/**
 *
 * get full conversation of certain user 
 * 
 * post data
 * 
 */

Route::post("/chatfull","loginHome@fullChat");

/**
 *
 * Search Singers 
 * 
 *
 * search page
 */

Route::get("/search","loginHome@search");

/**
 *
 * process Singers search 
 * 
 *
 * search page
 */

Route::post("/searchSingers","loginHome@searchProcess");
