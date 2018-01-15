<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendorTokens extends Model
{
    public $fillable = ['access_token','refresh_token','vendor_id','user_name','pass','client_id','secret'];
}
