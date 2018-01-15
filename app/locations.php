<?php

namespace App;

use App\Events;
use Illuminate\Database\Eloquent\Model;

class locations extends Model
{
    public $fillable =  ['location','image','address','longitud','altitud','description'];
    public function event()
    {
    	return $this->hasMany(Events::class,'location_id');
    }
}
