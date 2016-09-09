<?php

namespace App\Services\Auth;


use Firebase\JWT\JWT;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class JwtGuard implements Guard
{

    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The name of the field on the request containing the API token.
     *
     * @var string
     */
    protected $inputKey;

    /**
     * User id extracted from JWT
     *
     * @var string
     */
    protected $userId;


    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider $provider
     * @param  \Illuminate\Http\Request $request
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->inputKey = 'token';
        $this->userId = 'id';
        define('API',true);
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        //TODO FIX ME
        if ($this->provider->retrieveById($credentials['id'])) {
            return true;
        }
        return false;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (!is_null($this->user)) {
            return $this->user;
        }
        $user = null;
        $uid = $this->getTokenForRequest();
        if (!empty($uid)) {
            $user = $this->provider->retrieveById($uid);
        }
        return $this->user = $user;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    protected function getTokenForRequest()
    {
        // Retrieve JWT

        // Use Bearer Header
        $token = $this->request->bearerToken();

        // Use GET
        if (empty($token))
            $token = $this->request->input($this->inputKey);

        //Try to decode, JWS Encoded token
        try {
            /* add a leeway to account for when there is a clock skew times between
             * the signing and verifying servers. It is recommended that this leeway should
             * not be bigger than a few minutes.
             * $leeway in seconds */
            JWT::$leeway = 60;
            $payload = (array)JWT::decode(str_rot13($token), env('API_KEY'), ['HS512']);
            $uid = str_rot13($payload['id']);
            return $uid;
        } catch (\Exception $r) {
            return null;
        }

    }

    /**
     * Set the current request instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

}