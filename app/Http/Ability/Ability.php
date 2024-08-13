<?php

namespace App\Http\Ability;

use App\Models\User;

final class Ability{
    const GET_TICKET = 'ticket:get';
    const UPDATE_TICKET = 'ticket:update';
    const REPLACE_TICKET = 'ticket:replace';
    const DELETE_TICKET = 'ticket:delete';
    const STORE_TICKET = 'ticket:store';

    const UPDATE_OWN_TICKET = 'ticket:own:update';
    const GET_OWN_TICKET = 'ticket:own:get';
    const DELETE_OWN_TICKET = 'ticket:own:delete';
    const STORE_OWN_TICKET = 'ticket:own:store';
    
    const GET_USER = 'user:get';
    const UPDATE_USER = 'user:update';
    const DELETE_USER = 'user:delete';
    const STORE_USER = 'user:store';
    const REPLACE_USER = 'user:replace';

    public static function ability(User $user){
        if($user->is_manager){
            return [
            self::GET_TICKET,
            self::UPDATE_TICKET,
            self::REPLACE_TICKET,
            self::DELETE_TICKET,
            self::STORE_TICKET,
            self::GET_USER,
            self::UPDATE_USER,
            self::DELETE_USER,
            self::STORE_USER,
            self::REPLACE_USER];
        }
        else{
            return[
            self::STORE_OWN_TICKET,
            self::GET_OWN_TICKET,
            self::UPDATE_OWN_TICKET,
            self::DELETE_OWN_TICKET,
            ];
        }
    }

}