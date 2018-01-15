<?php

namespace App;

use App\Scope\eventScope;
use App\Transformers\eventTransformer;
use App\client;
use App\groupSingers;
use App\locations;
use App\seller;
use App\singers;
use App\songs;
use App\tickets;
use App\vendors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    use SoftDeletes;
    public $transformer = eventTransformer::class;
    public $fillable = ["event_name","date","location",'user_id','availableTickets','description'];
    public $hidden = ["deleted_at",'updated_at','created_at','pivot','user_id'];
    protected $dates = ['deleted_at'];
      protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new eventScope);
    }
     public function vendor(){
        return $this->belongsToMany(seller::class,"vendor_events","event_id","vendor_id");
    }
    public function song(){
        return $this->hasMany(songs::class,"event_id");
    }
    public function singer(){
    	return $this->belongsToMany(singers::class,"singer_events","event_id","singer_id");
    }
    public function groupSingers(){
    	return $this->belongsToMany(groupSingers::class,"g_singers_events","event_id","singers_id");
    }
    public function tickets()
    {
        return $this->hasMany(tickets::class,'event_id');
    }
    public function location()
    {
        return $this->belongsTo(locations::class);
    }
}
