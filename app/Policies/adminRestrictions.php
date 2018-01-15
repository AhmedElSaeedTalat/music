<?php

namespace App\Policies;

use App\User;
use App\handleVendorRequests;
use Illuminate\Auth\Access\HandlesAuthorization;

class adminRestrictions
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function view(User $user)
    {
        return $user->role == "admin";
    }
}
