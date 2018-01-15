<?php

namespace App;

use App\client;
use Illuminate\Database\Eloquent\Model;

class TicketsRequests extends Model
{
    public $table = "TicketsRequests" ;
    public $fillable = ["vendors_id","numberTickets_adult","numberTickets_child","user_id","userName","email"];
    public function client(){
      return $this->belongsToMany(client::class,"client_events","ticket_id","client_id");
    }
}
