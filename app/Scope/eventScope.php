<?php 
namespace App\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class eventScope implements Scope{
	public function apply(Builder $builder,Model $model){
		$builder->has("singer");
		$builder->has("tickets");
		$builder->has("location");
	}


	}
