<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
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

    public function before($user, $ability)
    {
        
    }

    public function deviceAdmin(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    


}
