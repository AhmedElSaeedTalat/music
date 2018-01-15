<?php

namespace App;

use App\Events;
use App\Transformers\ticketTransformer;
use App\client;
use App\seller;
use Illuminate\Database\Eloquent\Model;

class tickets extends Model
{
	public $transformer = ticketTransformer::class;
	public $fillable = ['price_adult','price_child','user_id','event_id'];
	public $hidden = ['updated_at','created_at','user_id'];
     public function seller(){
        return $this->belongsTo(seller::class);
    }
    public function Events(){
        return $this->belongsTo(Events::class);
    }
}
