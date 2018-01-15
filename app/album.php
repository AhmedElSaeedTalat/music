<?php

namespace App;

use App\Transformers\albumTransformer;
use App\singers;
use App\songs;
use Illuminate\Database\Eloquent\Model;

class album extends Model
{
	public $fillable = ["name"];
    public $transformer = albumTransformer::class;
    public function singers(){
    	return $this->belongsToMany(singers::class,'album_singers','album_id','singer_id');
    }
     public function songs(){
    	return $this->hasMany(songs::class);
    }
     public function groupSingers(){
    	return $this->belongsTo(groupSingers::class);
    }
}
