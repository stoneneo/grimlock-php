<?php

namespace Grimlock\Core\JWT;

use Exception;
use Firebase\JWT\JWT;
use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\JWT\Transfer\GrimlockJWTResponse;
use JimTools\JwtAuth\Decoder\FirebaseDecoder;
use JimTools\JwtAuth\Middleware\JwtAuthentication;
use JimTools\JwtAuth\Options;
use JimTools\JwtAuth\Secret;

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
     * @return JwtAuthentication
     */
    public static function validateJWT(): JwtAuthentication
    {
        return new JwtAuthentication(new Options(), new FirebaseDecoder(new Secret($_ENV['JWT_KEY'], $_ENV['JWT_ALG'])));
        /*try {
            //JWT::decode($jwt, $_ENV['JWT_KEY'], [$_ENV['JWT_ALG']]);
            $jwt = new JwtAuthentication(new Options(), new FirebaseDecoder(new Secret($_ENV['JWT_KEY'], $_ENV['JWT_ALG'])));
            return true;
        } catch (Exception $e) {
            throw new GrimlockException(GrimlockJWT::class,'Forbidden: you are not authorized.');
        }*/
    }

}