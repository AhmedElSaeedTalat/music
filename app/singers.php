<?php

namespace App;

use App\Events;
use App\Scope\singersScope;
use App\Transformers\singerTransformer;
use App\album;
use App\groupSingers;
use App\songs;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class singers extends Model
{
     use Searchable;
    public $transformer = singerTransformer::class;
    public $hidden =["singerCover",'updated_at','created_at','pivot'];
    public $fillable = ["singerName","singerCover","image","bio"];
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::addGlobalScope(new singersScope);
    // }
      public function searchableAs()
    {
        return 'singers_index';
    }
   public function song(){
        return $this->belongsToMany(songs::class,"siger_songs","singer_id","song_id");
    }
    public function album(){
    	return $this->belongsToMany(album::class,'album_singers','singer_id','album_id');
    }
    public function event(){
        return $this->belongsToMany(Events::class,"singer_events","singer_id","event_id");
    }
    public function groupSingers(){
    	return $this->belongsTo(groupSingers::class);
    }
}
