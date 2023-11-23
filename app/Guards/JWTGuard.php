<?php

namespace App\Guards;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class JWTGuard extends \PHPOpenSourceSaver\JWTAuth\JWTGuard
{
    public function attempt(array $credentials = [], $login = true)
    {
        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        $this->fireAttemptEvent($credentials);

        if ($this->hasValidCredentials($user, $credentials)) {
            dd($this->login($user));
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
        dd($token);

        return $this;
    }
}
