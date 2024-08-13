<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Filter\V1\AuthorFilter;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;

class Authorcontroller extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuthorFilter $filter)
    {
        // if($this->includes('auth')){
        //     return UserResource::collection(User::with('ticket')->paginate());
        // }
        return UserResource::collection(User::filter($filter)->paginate());
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $author)
    {
        //the course does it like new UserResource($author);
        if($this->includes('auth')){
            return  UserResource::collection(User::find($author)->load('ticket'));
        }
        return UserResource::collection(User::find($author));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
