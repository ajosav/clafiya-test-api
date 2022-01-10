<?php

namespace App\Helpers;

use App\Enums\StatusCode;
use App\Exceptions\ClafiyaException;
use App\Services\ProxyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Laravel\Passport\Exceptions\OAuthServerException;

class PassportUtil 
{

    public const REFRESH_TOKEN = 'refreshToken';

    public function respondWithToken(array $data) 
    {
        $response = Http::asForm()->post(url('/oauth/token'), $data);
        return $response->failed() ? false : $response->json();
    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     */
    public function refreshToken(ProxyService $proxyService, $request)
    {
        $refreshToken = $request->cookie(self::REFRESH_TOKEN);
        if(!$refreshToken)
            throw new ClafiyaException('Cookie is required to refresh token', StatusCode::VALIDATION);

        Cookie::queue(Cookie::forget(self::REFRESH_TOKEN));
        
        try {
            return $proxyService->proxy([
                'refresh_token' => $refreshToken
            ], 'refresh_token');
        } catch(OAuthServerException $e) {
            throw new ClafiyaException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout()
    {
        $accessToken = auth()->user()->token();

        DB::table('oauth_refresh_tokens')
        ->where('access_token_id', $accessToken->id)
        ->update([
            'revoked' => true
        ]);

        $accessToken->revoke();

        Cookie::queue(Cookie::forget(self::REFRESH_TOKEN));


    }
}