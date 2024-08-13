<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filter\V1\TicketFilter;
use App\Http\Requests\V1\BaseTicketRequest;
use App\Http\Requests\V1\TicketRequest;
use App\Http\Resources\V1\ticketResource;
use App\Models\User;
use App\Models\V1\ticket;
use App\Trait\APIResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthorTicketController extends ApiController
{
    use APIResponses;
    
    public function index(User $user,TicketFilter $filter){
        return ticketResource::collection(ticket::where('user_id',$user->id)->filter($filter)->paginate());
    }
    public function store(TicketRequest $request){
        try{
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));
            
            if(Auth::user()->id === $user->id){
                return new ticketResource(ticket::create($request->mappedRequest()));
            }else{
                return $this->error( 'You are not Authorized for this action' , 401 );
            }
        }catch(ModelNotFoundException $err){
            return $this->ok('user not found ' , $err);
        }catch(AuthorizationException){
            return $this->error( 'You are not Authorized for this action' , 401 );
        }        
    }
    public function destroy(User $user,ticket $ticket)
    {
        try{
            //Gate::authorize('destroy',$ticket);i could do it like this but i  didn't use gate why ? that's good question :D
            $attribute = $user->ticket()->findOrFail($ticket->id);
            if(Auth::user()->id === $ticket->user_id){
                if($attribute){
                    $attribute->delete();
                    return $this->ok([],'ticket deleted successfully ');}else{return $this->error('ticket Not found',200);
                }
            }else {
                return $this->error( 'You are not Authorized for this action' , 401 );
            }
        }catch (ModelNotFoundException){
            return $this->error('ticket Not found',200);
        }
        
    }
    public function update($userid,$ticketid,BaseTicketRequest $request){
        //patch
        try{
            $ticket = ticket::findOrFail($ticketid);
            $user = User::findOrFail($userid);
            Gate::authorize('update',$ticket);
            $ticket->update($request->mappedRequest());
        }catch(ModelNotFoundException){
            return $this->error('Ticket not found',404);
        }catch(AuthorizationException){
            return $this->error('You are not Authorized for this action',401);
        }
           return  new ticketResource($ticket);
    }
    public function replace ($userid,$ticketid,BaseTicketRequest $request){
        
        try{

            $ticket = ticket::findOrFail($ticketid);
            $user = User::findOrFail($userid);
            if($user->id == $ticket->user_id){
                $ticket->update($request->mappedRequest());
                return  new ticketResource($ticket);

            }else {
                return $this->error('you are not autherized for this action ', 401);
            }
        }catch(ModelNotFoundException){
            return $this->error('User not found',404);
        }
    }
}
