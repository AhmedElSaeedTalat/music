<?php

namespace App;

use App\client;
use Illuminate\Database\Eloquent\Model;

class TicketedUsers extends Model
{
    public $table = "TicketedUsers";
    public $fillable =  ["visitor_name","visitor_email","vendors_id","user_id","ticket_type","ticketNumber"];
     public function client(){
      return $this->belongsToMany(client::class,"ticketed_clients","ticketed_id","client_id");
    }
}
