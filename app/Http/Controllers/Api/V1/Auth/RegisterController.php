<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\AuthenticateUserTrait;
use App\Http\Resources\User\AuthUserResource;
use App\Http\Requests\Auth\UserRegistrationRequest;
use App\Contracts\Repository\UserRepositoryInterface;
use ErrorException;
use Illuminate\Database\QueryException;

class RegisterController extends Controller
{
    use AuthenticateUserTrait;
    
    public function register(UserRegistrationRequest $request, UserRepositoryInterface $user)
    {
        try
        {
            $user = $user->create($request->validated());
            $token = $this->authenticate($request);
            $data = $user->userData($token);
            
            return response()->success('User successfully created!', $data);
        } catch(QueryException $e)
        {
            report($e);
            return response()->success('Registration failed due to a internal error!', $data);
        } catch(ErrorException $e) 
        {
            report($e);
            return response()->success('Registration failed due to a internal error!', $data);
        }
        
    }
}
