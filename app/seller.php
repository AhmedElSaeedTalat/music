<?php

namespace App;

use App\Events;
use App\TicketedUsers;
use App\User;
use App\client;
use App\tickets;
use Illuminate\Database\Eloquent\Model;

class seller extends Model
{
    public $fillable = ['vendorName','address','email','sellingRate','user_id'];
	public function user()
	{
		return $this->belongsTo(User::class);
	}
    public function event(){
        return $this->belongsToMany(Events::class,"vendor_events","vendor_id","event_id");
    }
    public function ticket(){
        return $this->hasMany(tickets::class);
    }
    public function ticketed(){
    	return $this->hasMany(ticketed::class,"vendors_id");
    }
}
