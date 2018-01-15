<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscriptionServices extends Model
{
    public function songs(){
    	return $this->hasMany(songs::class);
    }
}
