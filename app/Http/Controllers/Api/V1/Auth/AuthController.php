<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Facades\PassportUtil;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function authenticatedUser() 
    {
        $user = auth()->user();
        return (new UserResource($user))->additional([
            'status' => 'success',
            'message' => 'Successful'
        ]);
    }

    public function logout() {
        if(auth()->check()) {
            PassportUtil::logout();
            return response()->success('', [], 204);
        };
       return response()->errorResponse('You are not logged in', [], 401);
    }
}
