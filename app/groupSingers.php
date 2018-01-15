<?php

namespace App;

use App\Events;
use App\Scope\groupScope;
use App\album;
use App\singers;
use App\songs;
use Illuminate\Database\Eloquent\Model;

class groupSingers extends Model
{
    public $hidden =["singersCover"];
    // protected static function boot(){
    //     parent::boot();
    //     static::addGlobalScope(new groupScope);
    // }
    public function singers(){
    	return $this->hasMany(singers::class,"groupSingers_id");
    }
    public function album(){
    	return $this->hasMany(album::class,"groupSingers_id");
    }
    public function event(){
        return $this->belongsToMany(Events::class,"g_singers_events","singers_id","event_id");
    }
    public function songs(){
    	return $this->hasMany(songs::class,"groupSingers_id");
    }
}
