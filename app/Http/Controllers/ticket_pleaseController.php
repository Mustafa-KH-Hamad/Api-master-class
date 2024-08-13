<?php

namespace App\Http\Controllers;

use App\Http\Ability\Ability;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginUser;
use App\Models\User;
use App\Trait\APIResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ticket_pleaseController extends Controller
{
    use APIResponses;
    /**
     * Summary of login
     * @unauthenticated
     * @param \App\Http\Requests\V1\LoginUser $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    function login(LoginUser $request){
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return $this->error('invailed cridentails');
        }
        
        
        $user = User::firstWhere('email', $request->email);
        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken(
                    'API token for ' . $user->email,
                    Ability::ability($user),
                    now()->addMonth()
                )->plainTextToken
            ]
        );
    }

    function logout(Request $request){
        //$request->user()->token()->delete() deletes all the token which is not right approch for this case
        //$request->user()->token()->where('token_id',$token)->delete();
        $request->user()->currentAccessToken()->delete();
        return $this->ok('',[]);
    }
}
