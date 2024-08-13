<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Ability\Ability;
use App\Http\Filter\V1\TicketFilter;
use App\Http\Requests\V1\BaseTicketRequest;
use App\Models\V1\ticket;
use App\Http\Requests\V1\TicketRequest;
use App\Http\Resources\V1\ticketResource;
use App\Models\User;
use App\Trait\APIResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ticketController extends ApiController
{
    use APIResponses;
    /**
     * Display a listing of the resource.
     */
    
    public function index(TicketFilter $filter)
    {
        // if($this->includes('ticket')){
        //     return ticketResource::collection( ticket::with('user')->paginate() );
        // }
        // return ticketResource::collection( ticket::paginate() );
        
        return ticketResource::collection( ticket::filter($filter)->paginate() );//lera ka filter bang kraea awa scopefilter a la model laravel scope prefix ladada dazane buildare dawe baxoe loe dadane 
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
    public function store(TicketRequest $request )
    {
       try{
        
        $user = User::findOrFail($request->input('data.relationships.author.data.id'));
        if(Auth::user() === $user){
            Gate::authorize('store',ticket::class);
            return new ticketResource(ticket::create($request->mappedRequest()));
        }else{
            return $this->error('the tickt should assign to user '.$user->id,401) ;
        }
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
    public function show(ticket $ticket)
    {
        try{
        Gate::authorize('index',$ticket);
        if($this->includes('ticket')){
            return new ticketResource($ticket->load('author'));
        }
        }catch(ModelNotFoundException){
            return $this->error('User not found',404);
        }
        catch(AuthorizationException){
            return $this->error('You are not Authorized for this action',401);
        }
        return new ticketResource($ticket);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($ticketid,BaseTicketRequest $request)
    {
        try{
            $ticket = ticket::findOrFail($ticketid);
            Gate::authorize('update',$ticket);
            $ticket->update($request->mappedRequest());
        }catch(ModelNotFoundException){
            return $this->error('User not found',404);
        }catch(AuthorizationException){
            return $this->error('You are not Authorized for this action',401);
        }
           return  new ticketResource($ticket);
    }
    public function replace ($ticketid,TicketRequest $request){
        try{

            $ticket = ticket::findOrFail($ticketid);
            Gate::authorize('replace',$ticket);
            $attributes = [
                "user_id" => $ticket->user_id,
                "title" => $request->input("data.attributes.title"),
                "status" => $request->input("data.attributes.status"),
                "discription" => $request->input("data.attributes.discription")
               ];
               $ticket->update($attributes);
        }catch(ModelNotFoundException){
            return $this->error('User not found',404);
        }
           return  new ticketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ticket $ticket)
    {
        try{
            Gate::authorize('destroy',$ticket);
            $ticket->delete();

            return $this->ok([],'ticket deleted successfully ');
        }catch (ModelNotFoundException $err){
            return $this->error('ticket Not found',200);
        }
        
    }

}
