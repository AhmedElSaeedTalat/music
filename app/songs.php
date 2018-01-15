<?php

namespace App;

use App\Events;
use App\Transformers\songsTransformer;
use App\album;
use App\groupSingers;
use App\singers;
use Illuminate\Database\Eloquent\Model;

class songs extends Model
{
    public $fillable = ["name","genre","path"];
    public $hidden = ["songCover"];
    public $transformer = songsTransformer::class;
    public function event(){
    	return $this->belongsTo(Events::class);
    }
    public function singers(){
    	return $this->belongsToMany(singers::class,"siger_songs","song_id","singer_id");
    }
      public function group(){
    	return $this->belongsTo(groupSingers::class);
    }
     public function album(){
    	return $this->belongsTo(album::class);
    }
}
