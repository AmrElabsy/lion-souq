<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $service
    ) {}
    
    public function index()
    {
        if(!isAdmin()) {
            return unauthorized();
        }
    
        return new UserCollection(User::all());
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->service->store($request->all());
        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->service->update($user->id, $request->all());
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        if(!isAdmin()) {
            return unauthorized();
        }

        $user->delete();

        return emptyResponse();
    }
}
