<?php

namespace App\Policies;

use App\User;
use App\seller;
use Illuminate\Auth\Access\HandlesAuthorization;

class seller
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function __construct()
    {
    }
    public function view(User $user,seller $seller)
    {
      return $user->id === $seller->id;
 
    }
}
