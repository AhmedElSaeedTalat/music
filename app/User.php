<?php

namespace App;

use App\client;
use App\handleVendorRequests;
use App\subscribers;
use App\ticketed;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable , HasApiTokens , Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const subscriber = "subscriber";
    const regular_user = "regular";
    const admin = "admin";
    const seller ='vendor';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function subscriberCheck(){
        return $this->role == User::subscriber;
    }
     public function userCheck(){
        return $this->role == User::admin;
    }
    public function userVendor()
    {
        return $this->role ;
    }
    public function client(){
        return $this->hasOne(client::class);
    }
    public function seller(){
        return $this->hasOne(seller::class);
    }
     public function subscribe(){
        return hasOne(subscribers::class);
    }
    public function handleVendorRequests()
    {
        return $this->hasOne(handleVendorRequests::class);
    }
    public function ticketedUsers()
    {
        return $this->hasMany(ticketed::class,'vendors_id');
    }
}
