<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name'  =>  ['required'],
            'email' =>  ['required', 'email:filter'],
            'password'  =>  ['required', 'confirmed'],
        ]);

        $user = User::create($request->only('name', 'email') + [
            'password'  =>  bcrypt(request('password')),
        ]);

        return response()->json(new RegisterResource($user), Response::HTTP_CREATED);
    }
}
