<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    public $fillable = ["adminMessage","clientMessage","admin_id","client_id","directedTo",'chat_id'];
}
