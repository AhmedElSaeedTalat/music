<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class handleVendorRequests extends Model
{
    public $fillable = [
    	'vendorName','email','address','sellingRate','request_proccess','user_id','admin_id'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
