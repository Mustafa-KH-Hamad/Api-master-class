<?php

namespace App\Policies\V1;

use App\Http\Ability\Ability;
use App\Models\User;
use App\Models\V1\ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function index(User $user , ticket $ticket){
        if($user->tokenCan(Ability::GET_TICKET)){
            return true; 
        }else if ($user->tokenCan(Ability::GET_OWN_TICKET)){
            return $ticket->user_id === $user->id;
        }
        
        return false ; 
    }
    public function store(User $user){
        if($user->tokenCan(Ability::STORE_TICKET)){
            return true; 
        }else if ($user->tokenCan(Ability::STORE_OWN_TICKET)){
            return Auth::user()->id === $user->id ;
        }
        return false; 
    }
    public function destroy(User $user , ticket $ticket){
        if($user->tokenCan(Ability::DELETE_TICKET)){
            return true; 
        }else if ($user->tokenCan(Ability::DELETE_OWN_TICKET)){
            return $ticket->user->is($user);
        }
        return false ; 
    }
    public function replace(User $user ){
        if($user->tokenCan(Ability::REPLACE_TICKET)){
            return true; 
        }
        return false ; 
    }
    public function update(User $user , ticket $ticket){
        if($user->tokenCan(Ability::UPDATE_TICKET)){
            return true; 
        }else if ($user->tokenCan(Ability::UPDATE_OWN_TICKET)){
            return $ticket->user->is($user);
        }
        return false ; 
    }
}
