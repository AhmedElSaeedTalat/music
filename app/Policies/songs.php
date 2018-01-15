<?php

namespace App\Policies;

use App\User;
use App\seller;
use Illuminate\Auth\Access\HandlesAuthorization;

class songs
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(User $user,seller $seller)
    {
        return $user->id === $seller->id;
    }
}
