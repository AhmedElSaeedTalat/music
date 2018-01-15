<?php

namespace App\Http\Controllers;

use App\Events;
use App\Events\Event;
use App\Events\chating;
use App\Mail\acceptedVendors;
use App\Mail\processRequests;
use App\User;
use App\adminMessages;
use App\album;
use App\clientMessages;
use App\handleVendorRequests;
use App\locations;
use App\messages;
use App\seller;
use App\singers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;
use Stripe\Stripe;

class loginHome extends Controller
{
	public function __construct()
	{
		$this->middleware('can:view,App\User')->only(['admin','checkComplaints']);
        $this->middleware('auth')->except(['search','searchProcess']);
	}

    /**
     * 
     * display form to receive request 
     * from vendors to display their 
     * respective events on our site
     *
     */

    public function index()
    {
        $albums = new album;
        $latestAlbum = $albums->take(4)->get();
        $locations = new locations;
        $locationFooter = $locations->take(6)->get();
    	return view('vendor.login',compact('latestAlbum','locationFooter'));
    }
    
    /**
     * 
     * Post request of vendors in db to 
     * check elegibility to be a vendor
     *
     */

    public function request(Request $request)
    {
    	$vendorName = request('name');
    	$email = request('email');
    	$address = request('address');
    	$rate = request('rate');
    	$rules = [
    		'name' => 'required',
    		'email' => 'required|email',
    		'address' => 'required',
    		'rate' => 'required',
    	];

    	$this->validate($request,$rules);
    	
        $request = handleVendorRequests::create([
			'vendorName' => $vendorName,
			'email' => $email,
			'address' => $address,
			'sellingRate' => $rate,
			'user_id' => auth()->user()->id,
    	]);
    	if($request)
    	{
            $albums = new album;
            $latestAlbum = $albums->take(4)->get();
            $locations = new locations;
            $locationFooter = $locations->take(6)->get();
    		return view('vendor.reply',compact('latestAlbum','locationFooter'));
    	} else {
    		return redirect()->back()->withInput(request()->all())->withErrors();
    	}
    }

    /**
     * displays all requests from vendors   
     * to be partner   
     * the admin accept or reject the requests
     *
     */

    public function admin()
    {
    	$request = new handleVendorRequests;
    	$requests = $request->all();
    	$userNames = $request->with('user')->get()->pluck('user.name');
    	return view('vendor.requests',compact('requests','userNames'));
    }
    public function process()
    {
       
    /**
	 *     note that acceptedIndexes here refer to id of 
     *     the accepted of each row in handle table 
     */
    	
        $handle = new handleVendorRequests;
    	$accept = request('acceptIndexes');
    	$reject = request('rejectIndexes');
    	$acceptIndexes = array_unique($accept);
    	$rejectIndexes = array_unique($reject);

    	for ($i=0; $i < count($acceptIndexes) ; $i++) { 
    		$handle->where('id',$acceptIndexes[$i])->update(['request_proccess'=>'accept',"admin_id"=>auth()->user()->id]);
    	}

    	for ($i=0; $i < count($rejectIndexes) ; $i++) { 
    		$handle->where('id',$rejectIndexes[$i])->update(['request_proccess'=>'reject',"admin_id"=>auth()->user()->id]);
    	}


       /**
        *   pass accepted vendors to seller table 
        *    as they are vendors starting today
        */

       for ($i=0; $i < count($acceptIndexes) ; $i++) 
       { 
            $variable = $handle->selectRaw('vendorName,address,email,sellingRate,user_id')
                               ->where('id',$acceptIndexes[$i])
                               ->get();
            foreach ($variable as $key => $value) 
            {
               seller::create([
                        'vendorName' => $value->vendorName,
                        'address' => $value->address,
                        'email' => $value->email,
                        'sellingRate' =>$value->sellingRate,
                        'user_id' => $value->user_id
                    ]);
            }
          
        }

       /**
    	 * get emails for accepted vendors to contact them 
         */
    	
        $emailsAccepted = [];
    	
    	for ($i=0; $i < count($acceptIndexes) ; $i++) {
    	$emailsAccepted[] = $handle->selectRaw('email')->where('id',$acceptIndexes[$i])->get();
    	}

       /**
    	* get emails for rejected vendors to contact them 
        */

    	$emailsrejected = [] ;
    	
    	for ($i=0; $i < count($rejectIndexes) ; $i++) { 
			$emailsrejected[] = $handle->selectRaw('email')->where('id',$rejectIndexes[$i])->get();
    	}
        
        /**
    	 *
         * send the relevant email to the rejected vendors 
         *
         */

    foreach($emailsrejected as $emails){
    	retry(5,function() use ($emails){
    		Mail::to($emails)->send(new processRequests('rejected',$emails));
    	},100);
    }
		
	   /**
        * 
        * get user ids for accepted vendors
        *
        */
    	
        $user_id = [];
    	for ($i=0; $i < count($acceptIndexes) ; $i++) { 
    	$user_id[] = $handle->selectRaw('user_id')->where('id',$acceptIndexes[$i])->get()->pluck('user_id');
    	}
        
       /**
        *
    	*   generate clients for the accepted vendors 
        *
        */

    	$users_id = [];
    	
    	foreach ($user_id as $key => $value) 
        {
    		foreach ($value as $key => $l) 
            {
    				$users_id[] = $l;
    		}	
    	}
    	session(["user_ids"=>$users_id]);
    }

	
    public function give()
    {

        /**
         *
    	 * update oauth and get ready to 
         * send client by the relevant secret
         *
         */

    	 $ids = DB::table('oauth_clients')->selectRaw('id')
    	 						   ->where('name','vendor')
    	 						   ->orderBy('created_at','desc')
    	 						   ->take(request('vendor'))
    	 						   ->get()
    	 						   ->pluck('id');

    	for($i = 0, $y=0 ; $i < count($ids), $y < count(session('user_ids')); $i++, $y++)
    	{
    		DB::table('oauth_clients')->where('id',$ids[$i])->update(['password_client'=>1,'user_id'=>session('user_ids')[$y]]);	
    	}	
    
    	 /**
         *
         * sending the email to the accepted vendors
         * 
         *
         */

    	$hand = new handleVendorRequests;
    
    	 /**
         *
         *  get the email of the accepted vendors
         *
         */ 

    	$emails = [] ;
    	for($i = 0; $i < count($ids); $i++)
    	{
    		$emails[] = $hand->selectRaw('email')
    							->where('user_id',session('user_ids')[$i])
    							->get()
    							->pluck('email');
    	}

    	 /**
         *
         * get the client secret
         * 
         */

    	$secrets = DB::table('oauth_clients')->selectRaw('id,secret')
									->where('name','vendor')
									->orderBy('created_at','desc')
									->take(request('vendor'))
									->get();
									

    	
		 /**
         *
         * get userNames
         *
         */

		$users = new User;
		$userName = [];
		for($i = 0; $i < count($ids); $i++)
    	{
		$userName[] = $users->selectRaw('name')
					  ->where('id',session('user_ids')[$i])
					  ->get()
					  ->pluck('name');
		}

        /**
         *
         * send the emails with the relative information
         *
         */

    	for($i = 0; $i < count($ids); $i++)
    	{
    		Mail::to($emails[$i])->send(new acceptedVendors($secrets[$i],$userName[$i]));
    	}
    }


    public function subscribe()
    {
        return view('subscribe');
    }
    public function cachier()
    {
        $token = request('stripeToken');
       Stripe::setApiKey('sk_test_Lguw2wK24pKwyayFLm3jPJUD');
      
       

        Auth::user()->charge(100);
       if(! Auth::user()->charge(100)){
        echo "nothing";
       }
      
        $user = auth()->user();
        $user->newSubscription('main', 'prem')->create($token, [
            'email' => auth()->user()->email,
]);
    }
    //********************************
    // used to try things only 
    public function bla()
    {
     //   $x = ["g"];
        //session()->put("vv",$x);
       // echo session('vv');
        //session()->push('vv','ahmed');
         //session()->push('vv','kamas');
//session()->forget('msgClient');
//       dd( session('vv'));
  $x =  new singers;
 $y= $x->search('Deja')->get()->pluck('singerName');
echo $y[0];
}
 public function sara()
    {
        $data = [
            "name"=>"ahmed",
            "phrase" => "welcome to the chat Kindly let us Know how can we help",
        ];
   Redis::publish('eve',json_encode($data));
   return view('x');

}

/**
 *
 * queries
 * 
 * query window for the customers
 */

public function pusher()
{
    $albums = new album;
    $latestAlbum = $albums->take(4)->get();
    $locations = new locations;
    $locationFooter = $locations->take(6)->get();
    $chatSession = str_random();
    session(['chat_id'=>$chatSession]);
    return view('pusher',compact('latestAlbum','locationFooter'));
}

/**
 *
 * send query to pusher
 * 
 * client side
 */

public function push()
{
    $user = auth()->user()->name;
    $message = request('message');
    $user = request('user');
    $time = request('time');
    $bla = auth()->user()->name;
    $chat_id = session('chat_id');
    if(session('msgClient')){
        $obj = (object) array('message'=>$message,'user'=>'you','time'=>$time);
        session()->push('msgClient',$obj);    
    }else{
           $obj = (object) array('message'=>$message,'user'=>'you','time'=>$time);
            session()->put('msgClient',[$obj]);        
    }
     event(new \App\Events\chating($message,$bla,$user,$chat_id)); 
}

/**
 *
 * handling queries
 * 
 * query window for the admins
 */

public function checkComplaints()
{
    return view('complaints');
}

/**
 *
 * send query response to pusher
 * 
 * admins side
 */

public function adminProcess()
{
     $user = auth()->user()->name;
     $userWithComplaint = request('userWithComplaint');
     $message = request('message');
     $time = request('time');
     $response = request('response');
     $index = request('index');

    /**
     *
     * store last admin message 
     * in session
     * admins side
     */

     $obj = (object) array('message'=>$message,'user'=>'Admin','time'=>$time,'userWithComplaint'=>$userWithComplaint,'response'=>$response,'index'=>$index);
        session()->put('msgAdmin',[$obj]);        
    
     /**
     *
     * store  admin message 
     * in DB
     * admins side
     */

     $client_id = User::where('name',$userWithComplaint)
                        ->get()
                        ->pluck('id');

    $chat_id = messages::where('client_id',$client_id[0])
                        ->get()
                        ->pluck('chat_id');                   
     $adminInst = new messages;
     $bla="";
     $adminMessage = $adminInst::create([
        'adminMessage' => $message,
        'admin_id' => auth()->user()->id,
        'directedTo' => $client_id[0],
        'chat_id' => $chat_id[0],
     ]);
    
     event(new \App\Events\chating($message,$userWithComplaint,$user,$bla)); 
}

public function clientChat()
{
    return session('msgClient');
}

/**
 *
 * send admin messages stored in sessions 
 * to chat page
 *
 * queries page
 */

public function clientChatAdmin()
{
    $adminMessage = request('adminMessage');
    $user = request('user');
    $userWithComplaint  = request('userWithComplaint');
    $time = request('time');
    if(session('msgClient')){
         $obj = (object) array('message' =>$adminMessage,'user'=>'Admin','time'=>$time);
        session()->push('msgClient',$obj);
    }else{
         $obj = (object) array('message' =>$adminMessage,'user'=>'Admin','time'=>$time);
            session()->put('msgClient',[$obj]);       
    }
     $clientChat = [
        'message' => session('msgClient'),
    ];
    return $clientChat;

}
public function adminsession()
{
    $clientChat = [
        'message' => session('msgAdmin'),
    ];
    return $clientChat;
}

public function clientAdmin()
{
    $user = request('user');
    $message = request('message');
    $time = request('time');
    $chat_id = request('chat_id');

    /**
     *
     * store last client message 
     * in session
     *
     * admins side
     */

    $obj = (object) array('message'=>$message,'user'=>$user,'time'=>$time);
        session()->put('msgAdmin',[$obj]);  
    

    /**
     *
     * store last client message 
     * in DB
     *
     * admins side
     */

     $clientInst = new messages;
     $client_id = User::where('name',$user)->get()->pluck('id');
     $clientMessage = $clientInst::create([
         'clientMessage' =>$message,
         'client_id' => $client_id[0],
         'directedTo' => auth()->user()->id,
         'chat_id' => $chat_id,
     ]);
    
    return  session('msgAdmin');
}


/**
 *
 * logout url 
 * 
 * auth
 */

public function loggingout()
{
    auth()->logout();
    return redirect("/events");
}

/**
 *
 * get full conversation of certain user 
 * 
 * post data
 * 
 */

 public function fullChat()
 {
    $client_name = request('id');
    $user = User::where('name',$client_name)->get()->pluck('id');
    $chat_id = messages::where('client_id',$user[0])
                        ->get()
                        ->pluck('chat_id');     
    $instance = new messages;
    $messages = $instance->where('chat_id',$chat_id)
                         ->get();
    return $messages;
 }

/**
 *
 * Search Singers 
 * 
 *
 * search page
 */

public function search()
{
    return view('search1');
}

/**
 *
 * process Singers search 
 * 
 *
 * search page
 */

 public function searchProcess()
{
    $index = request('searchIndex');
    $instance = new singers;
    $search = $instance->search($index)->get();
    return view('search2',compact('search'));
}
}
