<?php

namespace App;

use App\Events;
use App\TicketedUsers;
use App\TicketsRequests;
use App\User;
use App\seller;
use App\tickets;
use App\vendors;


class client extends User
{
      public function user(){
        return $this->belongsTo(User::class);
    }
     public function seller(){
        return $this->belongsTo(seller::class);
    }
     public function event(){
        return $this->belongsTo(Events::class);
    }
     public function TicketsRequests(){
      return $this->belongsToMany(TicketsRequests::class,"client_events","client_id","ticket_id");
    }
     public function TicketedUsers(){
      return $this->belongsToMany(TicketedUsers::class,"ticketed_clients","client_id","ticketed_id");
    }
    public function vendor(){
        return $this->hasMany(vendors::class);
    }
}
