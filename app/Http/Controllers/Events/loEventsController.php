<?php

namespace App\Http\Controllers\Events;

use App\Events;
use App\Mail\eventsAdds;
use App\generalApiQueries;
use App\locations;
use App\singer;
use App\singers;
use App\tickets;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class loEventsController extends generalApiQueries
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store','update','destroy']);
        $this->middleware('can:basics,event')->only(['update','destroy']);
    }

    /**
     * Show All Event .
     *
     *  All Events are displayed 
     */

   public function index(){
        $x = new Events;
    	$Events = Events::all();
        $y =  $Events->first()->transformer;
        $Events =  $this->paginator($Events);
        $transformer = fractal($Events,new $y)->toArray();
    	return response()->json(["Events"=>$transformer],200);
    }

    // cache 

    public function cacheResponse($data)
    {
        $url = request()->url();
        return Cache::remember($url,15/60,function() use ($data){
        return $data;
        });
    }
    
    /**
     * Event Paginator.
     *
     *  here is the paginating system for the Events
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

     public function show(Events $event){

    	$instance = $event->transformer;
      $transform = fractal($event,new $instance);
      
      return response()->json(['event information',$transform],200);
    }

    /**
     * Event Create.
     *
     *  here we create the event and add the related information
     */

    public function store(Request $request){

    $event = Events::selectRaw('id')->orderBy('id','desc')->take(1)->get()->pluck('id');
    $event_id = $event[0] + 1 ;
        //create event 
    $image = request('location_img');
    if(!empty($image)){
      $img_name = $image->hashName();
      $image->store('/images');
    }
    
    

    	$events = Events::create([
            "event_name"=>request('event'),
            "date"=>request('date'),
            "user_id" => $request->user()->id,
            'availableTickets' => request('numberOfTickets'),
            'description' => request('description'),
        ]);


      $location = locations::create([
        'image' => $img_name,
        'location' => request('location'),
        'address' => request('address'),
        'longitud' =>request('longitud'),
        'latitude' => request('latitude'),
        'description' => request('location_description'),
      ]);

      $location->event()->save($events);




        //check if singer exists in db 
            $sin = request('singer');
            json_decode($sin);
            if((json_last_error() == JSON_ERROR_NONE) ){
               $sin = json_decode($sin);
            }         
            $singers = new singers;
            $singer = [];
            for($i=0; $i<count($sin); $i++){
                 $singer[] = $singers->select('singerName')
                                 ->where('singerName',$sin[$i])
                                 ->get()
                                 ->pluck('singerName');
            }
          // know which singer isn't in the database
            $nonExistentIndex = [];
              $existentSingers = [];
         for($i=0; $i < count($sin); $i++){
            if($singer[$i]->isEmpty()){
               $nonExistentIndex[] =  $i;
            } else {
                $existentSingers[] = $i; 
            }
         }
         // insert singers and relate events to them 
           for($i=0; $i<count($nonExistentIndex); $i++){
            $singers = singers::create([
                        'singerName' => $sin[$nonExistentIndex[$i]],
                     ]);
            $singers->event()->attach($events);
           }
          for($i=0; $i<count($existentSingers); $i++){
           $singers = singers::selectRaw('id')
                    ->where('singerName',$sin[$existentSingers[$i]])
                    ->get()
                    ->pluck('id');
            $singers = singers::find($singers[0]);

            $singers->event()->save($events);
           }
       
       // instert ticket information 
           $ticket = tickets::create([
              'price_adult' => request('adultsPrice'),
              'price_child' => request('childrenPrice'),
              'user_id' => $request->user()->id,
              'event_id' => $event_id
           ]);

      // transform displayed instance
           $instance = $events->transformer;
           $transform = fractal($events,new $instance);

    	return response()->json(['event'=>$transform],200);
    }

 
    /**
     * Event Delete.
     *
     *  here we delete the event by the vendor
     */

    public function destroy(Events $event){
     tickets::where('event_id',$event->id)->delete();
     $event->singer()->detach();
     $deleted =   $event->delete();
     return response()->json(["deleted_event"=>$deleted],200);
    }
 


    /**
     * Event Update.
     *
     *  here is updated the event and the relevant information if provided
     */
    public function update(Events $event,Request $request){
      
      // update event name

      $the_event = request('event');
      if(!empty($the_event)){
          $event->update([
            'event_name' => $the_event
          ]);      
      }

       //update location

       $location = request('location');
          if(!empty($location)){
              $event->update([
                'location' => $location
              ]);      
          }
           //update date

        $date = request('date');
           if(!empty($date)){
              $event->update([
                'date' => $date
              ]);      
        }
          // update available tickets

          $numberTickets = request('numberOfTickets');
            if(!empty($numberTickets)){
              $event->update([
                'availableTickets' => $numberTickets
              ]);      
        }
          // update price for adults

          $price_adult = request('adultsPrice');
            if(!empty($price_adult)){
              tickets::where('event_id',$event->id)->update(['price_adult'=>$price_adult]);
                } 

          // update price for children

            $price_child = request('childrenPrice');
             if(!empty($price_child)){
                    tickets::where('event_id',$event->id)->update(['price_child'=>$price_child]);
                  } 
          // update related singers to the events    
              
             $sin = request('singer');
             if(!empty($sin)){

                //check if singer exists in db 
                  $event->singer()->detach();
                  $singers = new singers;
                  $singer = [];
                  for($i=0; $i < count($sin); $i++){
                       $singer[] = $singers->select('singerName')
                                       ->where('singerName',$sin[$i])
                                       ->get()
                                       ->pluck('singerName');
                  }

                // know which singer isn't in the database

                  $nonExistentIndex = [];
                  $existentSingers = [];
                  for($i=0; $i < count($sin); $i++){
                      if($singer[$i]->isEmpty()){
                         $nonExistentIndex[] =  $i;
                      } else {
                          $existentSingers[] = $i; 
                      }
               }

               // insert singers and relate events to them 

                 for($i=0; $i<count($nonExistentIndex); $i++){
                    $singers = singers::create([
                              'singerName' => $sin[$nonExistentIndex[$i]],
                                             ]);
                    $singers->event()->attach($event);
                 }

                for($i=0; $i<count($existentSingers); $i++){
                 $singers = singers::selectRaw('id')
                          ->where('singerName',$sin[$existentSingers[$i]])
                          ->get()
                          ->pluck('id');
                  $singers = singers::find($singers[0]);

                  $singers->event()->attach($event);
                 }
                } //end if condition 
                $instance = $event->first()->transformer;
                $event = fractal($event,new $instance);
                return response()->json(['event'=>$event],200);
}
}