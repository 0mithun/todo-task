<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Auth\LoginResource;
use Illuminate\Auth\AuthenticationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' =>  ['required'],
            'password'  =>  ['required'],
        ]);

        $user = User::query()->where('email', request('email'))->first();

        if ($user && Hash::check(request('password'), $user->password)) {
            $token = $user->createToken('user');

            return (new LoginResource($user))->additional(['token'=> $token->plainTextToken]);
        }
        throw new AuthenticationException();
    }
}
