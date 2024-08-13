<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filter\V1\AuthorFilter;
use App\Http\Filter\V1\TicketFilter;
use App\Http\Requests\V1\BaseTicketRequest;
use App\Http\Requests\V1\BaseUserRequest;
use App\Models\V1\ticket;
use App\Http\Requests\V1\TicketRequest;
use App\Http\Requests\V1\UserRequest;
use App\Http\Resources\V1\ticketResource;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Trait\APIResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends ApiController
{
    use APIResponses;
    /**
     * Display a listing of the resource.
     */
    
    public function index(AuthorFilter $filter)
    {
        // if($this->includes('ticket')){
        //     return ticketResource::collection( ticket::with('user')->paginate() );
        // }
        // return ticketResource::collection( ticket::paginate() );
        
        return UserResource::collection( User::filter($filter)->paginate() );//lera ka filter bang kraea awa scopefilter a la model laravel scope prefix ladada dazane buildare dawe baxoe loe dadane 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request )
    {
       try{
        
        Gate::authorize('store',user::class);
        return new UserResource(user::create($request->mappedRequest()));
                
       }catch(ModelNotFoundException $err){
            return $this->ok('user not found ' , $err);
       }catch(AuthorizationException){
            return $this->error('You are not Authorized for this action',401);
       }

       
    //    $attributes = [
    //     "user_id" => $request->input("data.relationships.author.data.id"),
    //     "title" => $request->input("data.attributes.title"),
    //     "status" => $request->input("data.attributes.status"),
    //     "discription" => $request->input("data.attributes.discription")
        
    //    ];
    //    dd($attributes);
      
    //    return new ticketResource::collection(ticket::create($attributes));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try{
        Gate::authorize('index',$user);
        if($this->includes('user')){
            return new UserResource($user->load('tickets'));
        }
        }catch(ModelNotFoundException){
            return $this->error('User not found',404);
        }
        catch(AuthorizationException){
            return $this->error('You are not Authorized for this action',401);
        }
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($userid,BaseUserRequest $request)
    {
        try{
            $user = User::findOrFail($userid);
            Gate::authorize('update',$user);
            $user->update($request->mappedRequest());
        }catch(ModelNotFoundException){
            return $this->error('User not found',404);
        }catch(AuthorizationException){
            return $this->error('You are not Authorized for this action',401);
        }
           return  new UserResource($user);
    }
    public function replace ($userid,UserRequest $request){
        try{
            $user = User::findOrFail($userid);
            Gate::authorize('replace',$user);
            $user->update($request->mappedRequest());
        }catch(ModelNotFoundException){
            return $this->error('User not found',404);
        }
           return  new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            Gate::authorize('destroy',$user);
            $user->delete();

            return $this->ok([],'user deleted successfully ');
        }catch (ModelNotFoundException){
            return $this->error('user Not found',200);
        }
        
    }

}
