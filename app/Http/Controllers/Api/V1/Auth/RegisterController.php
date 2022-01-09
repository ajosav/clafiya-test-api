<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\AuthenticateUserTrait;
use App\Http\Resources\User\AuthUserResource;
use App\Http\Requests\Auth\UserRegistrationRequest;
use App\Contracts\Repository\UserRepositoryInterface;

class RegisterController extends Controller
{
    use AuthenticateUserTrait;
    
    public function register(UserRegistrationRequest $request, UserRepositoryInterface $user)
    {
        $user = $user->create($request->validated());
        $token = $this->authenticate($request);
        $data = $user->userData($token);
        
        return response()->success('You are logged in!', $data);
    }
}
