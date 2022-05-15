<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        return 'Просмотр списка всех сотрудников админом';
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        return $request;
    }

    public function show(User $user)
    {
        return $user;
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }

    public function login(Request $request)
    {
        $user = User::where([
            'login'=>$request->login,
            'password'=>$request->password,
        ])->first();
        if (!$user) {
            throw new APIException(401,'Authentication failed');
        }
        /*$user->api_token=Str::random(25);
        $user->save();*/
        return response()->json([
            'data'=>[
                'user_token'=>$user->generateToken(),
            ]
        ]);
    }

    public function logout()
    {
        Auth::user()->logoutToken();
        return [
            'message'=>'logout',
        ];
    }

}
