<?php

namespace App;

use App\Events;
use App\client;
use App\tickets;
use Illuminate\Database\Eloquent\Model;

class vendors extends Model
{
	public $table = "vendors";
	
    public function client(){
        return hasMany(client::class);
    }
    public function event(){
        return $this->belongsToMany(Events::class,"vendor_events","vendor_id","event_id");
    }
    public function ticket(){
        return hasMany(tickets::class);
    }
}
