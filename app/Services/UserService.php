<?php 
namespace App\Services;
use App\Models\User;
class UserService {

    public function UserService($request) {
        $user = new User();
        $user->name = $request->name;
       $user->username = $request->username;
        $user->email = $request->email;
        
        $user->password = bcrypt($request->password);
         return $user;
    }
}