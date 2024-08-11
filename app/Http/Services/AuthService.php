<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\CustomerService;

class AuthService extends BaseService
{
    public function store($data)
    {
        $userService = new UserService();
        return $userService->store($data);
    }

    public function update($model, $data) {}

    public function login($data)
    {
        $user = User::where('email', $data['email'])->first();
        if ($user && Hash::check($data['password'], $user->password)) {
            $token = $user->createToken('token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token
            ];
        }
        
        return null;
    }
}
