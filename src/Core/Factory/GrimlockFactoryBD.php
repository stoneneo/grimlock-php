<?php

namespace Grimlock\Core\Factory;

use Grimlock\Core\Exception\GrimlockException;
use Illuminate\Database\Capsule\Manager as Capsule;
use PDO;

/**
 *
 */
class GrimlockFactoryBD
{
    /**
     * @return Capsule
     * @throws GrimlockException
     */
    public static function create(): Capsule
    {
        if (empty($_ENV['DB_DRIVER']) || $_ENV['DB_DRIVER'] == '')
        {
            throw new GrimlockException(GrimlockFactoryBD::class,  'Key DB_DRIVER not found or empty');
        }
        if (empty($_ENV['DB_HOST']) || $_ENV['DB_HOST'] == '')
        {
            throw new GrimlockException(GrimlockFactoryBD::class,  'Key DB_HOST not found or empty');
        }
        if (empty($_ENV['DB_NAME']) || $_ENV['DB_NAME'] == '')
        {
            throw new GrimlockException(GrimlockFactoryBD::class,  'Key DB_NAME not found or empty');
        }
        if (empty($_ENV['DB_USER']) || $_ENV['DB_USER'] == '')
        {
            throw new GrimlockException(GrimlockFactoryBD::class,  'Key DB_USER not found or empty');
        }
        if (empty($_ENV['DB_PASS']) || $_ENV['DB_PASS'] == '')
        {
            throw new GrimlockException(GrimlockFactoryBD::class,  'Key DB_PASS not found or empty');
        }
        $manager = new Capsule;
        $manager->addConnection([
            'driver'    => $_ENV['DB_DRIVER'],
            'host'      => $_ENV['DB_HOST'],
            'database'  => $_ENV['DB_NAME'],
            'username'  => $_ENV['DB_USER'],
            'password'  => $_ENV['DB_PASS'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'options'   => [
                PDO::ATTR_EMULATE_PREPARES => true
            ]
        ]);
        // Make this Capsule instance available globally via static methods... (optional)
        $manager->setAsGlobal();
        $manager->bootEloquent();

        return $manager;
    }

}