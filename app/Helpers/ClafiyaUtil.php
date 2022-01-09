<?php

namespace App\Helpers;

use Throwable;

class ClafiyaUtil 
{
    private const PHONE_FIELD = 'phone_number';

    private const EMAIL_FIELD = 'email';

    public function generateReference($model, $field, ? string $prefix = '') : string
    {
        $reference = $prefix.mt_rand(10000000, 99999999999).time();
        // call the same function if the token exists already
        if ($this->tokenExist($model, $field, $reference)) {
            return $this->generateReference($model, $field);
        }
        return $reference;
    }

    private function tokenExist($model, $field, $reference) : bool
    {
        // query the database and return a boolean
        return $model::where($field, $reference)->exists();
    }

    public function setLoginFieldType($login)
    {
        return filter_var($login, FILTER_VALIDATE_EMAIL) ? self::EMAIL_FIELD : self::PHONE_FIELD;
    }

    public function encode(?array $data): ?string
    {
        try {
            return $data === null ? null : json_encode($data, JSON_THROW_ON_ERROR);
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function respondWithToken(array $tokenData) : array
    {
        return [
            "token_type" => $tokenData['token_type'],
            "expires_in" => $tokenData['expires_in'],
            "access_token"=> $tokenData['access_token']
        ];
    }

}