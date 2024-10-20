<?php

namespace Grimlock\Core\JWT;

use Exception;
use Firebase\JWT\JWT;
use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\JWT\Transfer\GrimlockJWTResponse;

/**
 *
 */
class GrimlockJWT
{

    /**
     * @param string $sub
     * @param string $email
     * @param string $name
     * @param int $expire
     * @return GrimlockJWTResponse
     */
    public static function createJWT(string $sub, string $email, string $name, int $expire): GrimlockJWTResponse
    {
        $token = [
            'sub' => $sub,
            'email' => $email,
            'name' => $name,
            'iat' => time(),
            'exp' => time() + $expire
        ];
        $authToken = JWT::encode($token, $_ENV['JWT_KEY'], $_ENV['JWT_ALG']);
        $refreshToken = JWT::encode($token, $_ENV['JWT_KEY'], $_ENV['JWT_ALG']);

        $jwtResponse = new GrimlockJWTResponse();
        $jwtResponse->setAuthToken($authToken);
        $jwtResponse->setRefreshToken($refreshToken);

        return $jwtResponse;
    }

    /**
     * @param string $jwt
     * @return bool
     * @throws GrimlockException
     */
    public static function validateJWT(string $jwt): bool
    {
        try {
            JWT::decode($jwt, $_ENV['JWT_KEY'], [$_ENV['JWT_ALG']]);
            return true;
        } catch (Exception $e) {
            throw new GrimlockException(GrimlockJWT::class,'Forbidden: you are not authorized.');
        }
    }

}