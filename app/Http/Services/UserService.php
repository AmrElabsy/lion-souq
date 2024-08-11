<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function store($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' =>  Hash::make($data['password']),
            'role' => $data['role'] ?? 'user'
        ]);
    }

    public function update($id, $data)
    {
        $user = User::findorFail($id);
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'] ?? $user->role
        ]);
        
        $user->save();

        return $user;
    }
    
    public function changePassword($user, $data) {
        $user = User::find($user->id);
        if (Hash::check($data['old_password'], $user->password)) {
            $user->password = Hash::make($data['password']);
            $user->save();
            return [
                'message' => 'success'
            ];
        }
        
        return [
            'message' => 'error'
        ];
    }

}
