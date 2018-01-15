<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ticketed extends Model
{
    public $fillable =  ["visitor_name","visitor_email","vendors_id","user_id","ticket_type","ticketNumber","event_id"];
     public function client(){
      return $this->belongsToMany(client::class,"ticketed_clients","ticketed_id","client_id");
    }
}
