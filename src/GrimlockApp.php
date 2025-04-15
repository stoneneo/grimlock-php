<?php

namespace Grimlock;

use Dotenv\Dotenv;
use Exception;
use Grimlock\Core\Exception\GrimlockException;

/**
 *
 */
class GrimlockApp
{

    /**
     * @return void
     * @throws GrimlockException
     */
    public static function initialize(): void
    {
        try {
            $dotenv = Dotenv::createImmutable(__DIR__.'/../../../../');
            $dotenv->load();
        } catch (Exception $e) {
            throw new GrimlockException(GrimlockApp::class, $e->getMessage());
        }
    }

}