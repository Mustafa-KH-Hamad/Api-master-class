<?php

namespace App\Policies\V1;

use App\Http\Ability\Ability;
use App\Models\User;


class UserPolicy
{
    public function index(User $user){
        if($user->tokenCan(Ability::GET_USER)){
            return true; 
        }
        return false ; 
    }
    public function store(User $user){
        if($user->tokenCan(Ability::STORE_USER)){
            return true; 
        }
        return false; 
    }
    public function destroy(User $user ){
        if($user->tokenCan(Ability::DELETE_USER)){
            return true; 
        }
        return false ; 
    }
    public function replace(User $user ){
        if($user->tokenCan(Ability::REPLACE_USER)){
            return true; 
        }
        return false; 
    }
    public function update(User $user ){
        if($user->tokenCan(Ability::UPDATE_USER)){
            return true; 
        }
        return false ; 
    }
}
