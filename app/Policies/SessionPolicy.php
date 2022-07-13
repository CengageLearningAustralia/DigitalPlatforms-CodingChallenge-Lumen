<?php

namespace App\Policies;


use App\Models\Session;
use App\Models\User;

class SessionPolicy
{
    public function view(User $user, Session $session) {
        return $user->id === $session->user_id;
    }

}
