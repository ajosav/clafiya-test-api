<?php

namespace App\Services;

use App\Facades\PassportUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class ProxyService
{
    public const REFRESH_TOKEN = 'refreshToken';
    /**
     * Proxy a request to the OAuth server.
     *
     * @param array $data the data to send to the server
     * @param string $grantType what type of grant type should be proxied
     */
    public function proxy(array $data = [], $grantType = 'password', ? string $scope = '*')
    {
        $data = array_merge($data, [
            'client_id'     => config('passport.password_access_client.id'),
            'client_secret' => config('passport.password_access_client.secret'),
            'grant_type'    => $grantType,
            'scope'    => $scope
        ]);

        $response = PassportUtil::respondWithToken($data);

        if(!$response)
        {
            return null;
        }
        if(isset($data['username']) && Cache::has($data['username']))
            Cache::forget($data['username']);
        // Create a refresh token cookie
        Cookie::queue(
            self::REFRESH_TOKEN,
            $response['refresh_token'] ?? null,
            60 * 60 * 24 * 10,
            null,
            null,
            false,
            true // HttpOnly
        );

        return $response;
    }


}