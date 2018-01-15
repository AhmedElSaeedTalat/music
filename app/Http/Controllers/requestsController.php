<?php

namespace App\Http\Controllers;

use App\Events;
use App\Mail\ticket;
use App\TicketedUsers;
use App\TicketsRequests;
use App\album;
use App\locations;
use App\singers;
use App\songs;
use App\ticketed;
use App\vendorTokens;
use App\vendorsLinks;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Stripe\Stripe;

class requestsController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:view,App\User')->only(['tokenInterface']);
	}
    /**
     * this function displays a form to request number of tickets  
     *
     *  here is passed the vendor id for the vendor selected
     */

    public function ticket($id)
    {
        $event = new Events;
        $event = $event->find($id);
        $singer = $event->singer()->get();
        $tickets = $event->tickets()->get();
        $location = $event->location()->get();
        //dd($tickets);
    	return view('requests.request',compact('event','singer','tickets','location'));
    }
 	
 	/**
     * Post ticket request in the database
     *
     * after saving the request in db the information
     * is sent to the vendor through oauth to have each
     * ticket processed
     */

    public function makeRequest()
    {

        /** 
        *   get the information about the ticketed requested
        */ 

        $number_adults = request('adult');
        $number_child  = request('child');
        if(auth()->check()){
            $user_id = auth()->user()->id;
        }
        $email = request('email');
        $name  = request('name');
        $vendor_id = request('vendor_id');
        $event_id  = request('event_id');
        $event  = request('event');
        $adultP = request('adultP');
        $childP = request('childP');


      /** 
       * save in the information in the database 
       */ 
        
        TicketsRequests::create([
            'vendors_id' => $vendor_id,
            'numberTickets_adult' => $number_adults,
            'numberTickets_child' => !empty($number_child) ? $number_child : null,
            'user_id' => !empty($user_id) ? $user_id : null,
            'userName' => $name,
            'email' =>$email, 
        ]);

     /** 
       *
       * calculate amount to be paid
       *
       */ 

        $totalChildExpence  = $number_child  * $childP;
        $totalAdultExpence  = $number_adults * $adultP;
        $totalAmountPayment =  ($totalAdultExpence + $totalChildExpence) * 100;

       /** 
        *
        *   perform payment
        *
        */ 

       $token = request('stripeToken');
       Stripe::setApiKey('sk_test_Lguw2wK24pKwyayFLm3jPJUD');

        \Stripe\Charge::create(array(
          "amount" => $totalAmountPayment,
          "currency" => "usd",
          "source" => $token, // obtained with Stripe.js
          "description" => "Charge for ticket event: $event"
        ));

        /** 
         *   issue tickets and send emails to customer with tickets
         */ 


		  for($i=0; $i < $number_adults; $i++)
        {
            $ticket_adult = ticketed::create([
                "ticketNumber" => str_random(10),
                "email" => $email,
                "ticket_type" => "adult",
                'visitor_name' => $name,
                'visitor_email' => $email,
                'user_id' => !empty($user_id) ? $user_id : null,
                'vendors_id' => $vendor_id,
                'event_id' => $event_id
            ]);
        }
        if(!empty($number_child))
        {
             for($i=0; $i < $number_child; $i++)
        {
            $random_serial = str_random(10);
            $ticket_child = ticketed::create([
                "ticketNumber" => str_random(10),
                "email" => $email,
                "ticket_type" => "child",
                'visitor_name' => $name,
                'visitor_email' => $email,
                'user_id' => !empty($user_id) ? $user_id : null,
                'vendors_id' => $vendor_id,
                'event_id' => $event_id
            ]);
        }
        }
       
         // query db to send tickets to users

        $query = ticketed::selectRaw('ticketNumber,ticket_type,visitor_name')
                                      ->where('visitor_email',$email)
                                      ->whereDate('created_at',date("Y-m-d"))
                                      ->get();
                                    
        
        for($i=0; $i < $query->count() ; $i++)
        {
            Mail::to($email)->send(new ticket($query[$i]));
        }

        $albums = new album;
        $latestAlbum = $albums->take(4)->get();
        $locations = new locations;
        $locationFooter = $locations->take(6)->get();
		return view('completedPurchase',compact('event_id','latestAlbum','locationFooter'));
        }
    

	/**
     * display all events
     *
     * @return void
     */

	public function events()
	{
		$x = new Events;
		$events = $x->with('singer')->whereDate('date','>',date("Y-m-d"))->with('location')->skip(0)->take(6)->get();
    /**
     * count events per page
     *
     * @return void
     */

    $perPage = 6;
    $all = $x->whereDate('date','>',date("Y-m-d"))->get();
    $countPages = count($all)/$perPage;

    /**
     * get random event for home page cover
     *
     * @return void
     */

    $event = $x->all()->random();
    $singerImage = $event->singer()->get()->pluck('singerCover');
     
     /**
     * pass 4 location from db 
     *
     * @return void
     */

    $location = new locations;
    $location = $location->take(4)->get();

     /**
     * pass 3 singers from db
     *
     * @return void
     */

    $singers = new singers;
    $singers = $singers->take(3)->get();

     /**
     * pass an event of the week 
     * date caclulated within a week
     * @return void
     */

    $date = date("Y-M-d");
    $usedDate =  date("Y-m-d",strtotime($date." + 7 days"));
    $eventOfWeek = $x->with('singer')
                    ->whereDate('date','>',date("Y-m-d"))
                    ->whereDate('date','<',$usedDate)
                    ->with('location')
                    ->take(1)
                    ->get();

   /**
     * pass an album
     * 
     * @return void
     */

   $album = new album;
   //$album = $album->all()->random();
   $album = $album->take(1)->get();
		return  response() ->view('events',compact('events','singerImage','event','location','countPages','singers','eventOfWeek','album'))->header('accept-ranges','bytes')->header('range','bytes');
                     
	}

  /**
     * paginateEvents
     *
     * @return void
     */

  public function paginateEvents()
  {
    $index = request('index');
    $x = new Events;
    if(empty($index))
    {
      $events = $x->with('singer')->with('location')->whereDate('date','>',date("Y-m-d"))->skip(0)->take(6)->get();
    } else {
      $events = $x->with('singer')->with('location')->whereDate('date','>',date("Y-m-d"))->skip(($index-1)*6)->take(6)->get();
    }
    
    return $events;
      }
    
    /**
     *  return events onload
     *
     * @return void
     */

  public function eventInfo()
  {
    
    $x = new Events;
    $events = $x->with('singer')->with('location')->whereDate('date','>',date("Y-m-d"))->skip(0)->take(6)->get();
    return $events;
  
  }

	/**
     * here is the admin could enter the information 
     * about the oauth to get the relevant token
     * 
     */

	public function tokenInterface()
	{
		return view('tokenInterface');
	}

	/**
     * here the oauth information is sent to the 
     * client server and then the token received
     * is then passed to db to be used when making
     * different request to  the vendor's client
     */

	public function tokenDetails()
	{
		
	   /** 
    	*	collect passed data of secret and the others
    	*/ 

		$secret = request('secret');
		$grant_type = request('grant_type');
		$userName = request('userName');
		$password = request('password');
		$client_id = request('client_id');
		$vendor_id = request('vendor_id');
		$refresh_token = request('refresh_token');
 		
 	   /** 
    	*	make request to vendor's client to get oauth
    	*/ 
 		
 		$client = new Client;
        $request = $client->request('POST','http://localhost:8080/api/oauth/token',[
            'form_params' => [
                'grant_type' => $grant_type,
                'client_id' => $client_id ,
                'client_secret' => $secret,
                'username' => $userName,
                'password' => $password, 
                'refresh_token' => request('grant_type') == 'refresh_token' ? $refresh_token : null,
            ],
             'headers' => [
                    "Content-Type" => "application/x-www-form-urlencoded",
                ],
        ]);

       /** 
    	*	pass the received token to db
    	*/ 
      
        $tokens = $request->getBody();
        $body = $tokens->getContents();
        $bla = explode("\"", $body);
        $access_token = $bla['9'];
        $refresh_token = $bla['13'];
        vendorTokens::where('vendor_id',$vendor_id)->delete();
        vendorTokens::create([
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'vendor_id' => $vendor_id,
       ]);
        return $tokens;
	}

    /**
     *
     * display image full size
     * composer require intervention/image
     *  using response
     */

    public function size($id)
    {
        $event = new Events;
        $event = $event->find($id);
        $singer = $event->singer()->get();
        $image = $singer[0]->image;
        
        $path = "images/$image";
        return Image::make($path)->response();
    }

     /**
     *
     * display selected singers
     * 
     *  
     */

     public function singers($id)
     {
        $singer = new singers;
        $singer = $singer->find($id);
        return response()->view('singers',compact('singer'));
     }
    
    /**
     *
     * display image full size
     * 
     *  using response
     */

    public function singersFullSize($id)
    {
        $singer = new singers;
        $singer = $singer->find($id);
        $image = $singer->image;
        $path = "images/$image";

        return Image::make($path)->response();
    }

    /**
     *
     * display related sound tracks
     * 
     *  soundtrack page
     */

    public function soundtrack($id)
    {
        $album = new album;
        $album = $album->find($id);
        return response()->view('soundtracks',compact('album'));
    }

    /**
     *
     * download selected track
     * 
     *  soundtrack page
     */

    public function download($id)
    {
        $soundtrack = new songs;
        $soundtrack = $soundtrack->find($id);
        $soundtrack = 'sound/'.$soundtrack->path;
        return response()->download($soundtrack);
    }

    public function location($id)
    {
        $location =  new locations;
        $location = $location->find($id);
        $albums = new album;
        $latestAlbum = $albums->take(4)->get();
        $locations = new locations;
        $locationFooter = $locations->take(6)->get();
        return view('location',compact('location','latestAlbum','locationFooter'));
    }
}
