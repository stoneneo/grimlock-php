<?php

namespace Grimlock\Core\Middleware;

use Exception;
use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\JWT\GrimlockJWT;
use Grimlock\Core\Transfer\ErrorResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

/**
 *
 */
class GrimlockAuth implements MiddlewareInterface
{

    /**
     * @param Request $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $jwtHeader = $request->getHeaderLine('Authorization');
            if (! $jwtHeader) {
                throw new GrimlockException(GrimlockAuth::class,'JWT Token required.', 400);
            }

            $jwt = explode('Bearer ', $jwtHeader);
            if (! isset($jwt[1])) {
                throw new GrimlockException(GrimlockAuth::class,'JWT Token invalid.', 400);
            }

            GrimlockJWT::validateJWT($jwt[1]);

            return $handler->handle($request);
        } catch (Exception $e) {
            $errorResponse = new ErrorResponse();
            $errorResponse->setCode(401);
            $errorResponse->setMessage($e->getMessage());

            $response = new Response();
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader("Content-Type", "application/json")->withStatus(401);;
        }
    }

}