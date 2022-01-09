<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\ClafiyaException;
use App\Facades\ClafiyaUtil;
use App\Facades\JwtUtil;
use App\Facades\PassportUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\AuthUserResource;
use App\Models\User;
use App\Services\ProxyService;
use App\Traits\AuthenticateUserTrait;

class LoginController extends Controller
{
    use AuthenticateUserTrait;

    protected $username;
    
    public function __construct()
    {
        $this->username = $this->findusername();
    }

    public function findUserName()
    {
        $login = request()->username;
        $fieldType = ClafiyaUtil::setLoginFieldType($login);
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    public function login(LoginRequest $request)
    {
        $user = $request->requestUser();
        $token = $this->authenticate($request);
        $data = $user->userData($token);
        
        return response()->success('You are logged in!', $data);
    }

    public function refreshToken(ProxyService $proxyService, Request $request)
    {
        $token = PassportUtil::refreshToken($proxyService, $request);
        if(!$token)
            throw new ClafiyaException('Refresh token expired', 401);

        return response()->success('sucessful', ClafiyaUtil::respondWithToken($token));
    }

    
}