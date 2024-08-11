<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\AuthService;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $service
    ) {}
    
    public function register(RegisterRequest $request)
    {
        return $this->service->store($request->all());
    }
    
    public function login(LoginRequest $request)
    {
        $data = $this->service->login($request->all());
        if ($data) {
            return $data;
        }
        
        $data = [
            'message' => 'Invalid Email or Password'
        ];
        return response($data, 400);
    }
}
