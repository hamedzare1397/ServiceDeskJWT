<?php

namespace App\Guards;

use \PHPOpenSourceSaver\JWTAuth\JWTGuard as JWTGuardBase;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use PHPOpenSourceSaver\JWTAuth\JWT;

class JWTGuard extends JWTGuardBase
{
    public function attempt(array $credentials = [], $login = true)
    {
        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        $this->fireAttemptEvent($credentials);
        if ($this->hasValidCredentials($user, $credentials)) {
            return $login ? $this->login($user) : true;
        }

        $this->fireFailedEvent($user, $credentials);

        return false;
    }

    public function login(JWTSubject $user)
    {
        $token = $this->jwt->fromUser($user);
        $this->setToken($token)->setUser($user);

        $this->fireLoginEvent($user);

        return $token;
    }

    public function setToken($token)
    {
        $this->jwt->setToken($token);

        return $this;
    }
}
