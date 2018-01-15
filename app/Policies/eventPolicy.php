<?php

namespace App\Policies;

use App\Events;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class eventPolicy
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
    public function basics(User $user,Events $events)
    {
        return $user->id == $events->user_id;
    }
}
