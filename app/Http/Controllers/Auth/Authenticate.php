<?php

namespace App\Http\Controllers\Auth;

use App\Http\MyService\ResponseService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\GetTokenRequest;
use App\Http\Requests\RegistrationUserRequest;
use App\Http\Resources\BorrowerResource;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function getToken(GetTokenRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseService::wrapStatus(Response::HTTP_UNPROCESSABLE_ENTITY, false, [], 'The provided credentials are incorrect.');
        }

        $token = $user->createToken('user')->plainTextToken;
        return ResponseService::wrapStatus(Response::HTTP_OK, true, array_merge([
            'user' => $user->only('name', 'email', 'id', 'role'),
            'token' => $token
        ]));
    }

    public function registerUser(RegistrationUserRequest $request)
    {
        $createUser = User::create($request->toArray());
        return ResponseService::wrapStatus(Response::HTTP_OK, true, [
            'user' => collect($createUser)->only('name', 'email', 'id', 'role'),
            'token' => $createUser->createToken('user')->plainTextToken
        ]);
    }
}
