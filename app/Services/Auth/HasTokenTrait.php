<?php namespace App\Services\Auth;

use Firebase\JWT\JWT;

trait HasTokenTrait{

    public function getTokenAttribute($value)
    {
        $token = [
            "exp" => time() + 60 * 60 * 24 * 30,
            'id' => str_rot13($this->id),
        ];
        $token_jwt = str_rot13(JWT::encode($token, env('API_KEY'), 'HS512'));

        return ['token' => $token_jwt, 'valid' => $token['exp']];
    }

}