<?php

namespace Grimlock\Core\JWT\Transfer;

use JsonSerializable;

class GrimlockJWTResponse implements JsonSerializable
{
    private string $authToken;
    private string $refreshToken;

    public function jsonSerialize(): array
    {
        return array(
            'authToken'   => $this->authToken,
            'refreshToken' => $this->refreshToken,
        );
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function setAuthToken(string $authToken): void
    {
        $this->authToken = $authToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

}