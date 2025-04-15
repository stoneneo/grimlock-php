<?php

namespace Grimlock\Core\Util;

use Exception;
use Grimlock\Core\Exception\GrimlockException;
use ReflectionClass;

/**
 * Class Enumeration
 * @package Grimlock\Util
 * @author Rubén Darío Huamaní Ucharima
 */
class Enumeration
{

    /**
     * @param $class
     * @param $value
     * @return bool
     * @throws GrimlockException
     */
    public static function contains($class, $value): bool
    {
        try {
            $reflectionCass = new ReflectionClass($class);
            foreach ($reflectionCass->getConstants() as $keyClass => $valueClass) {
                if ($valueClass == $value) {
                    return true;
                }
            }
            return false;
        } catch(Exception $e) {
            throw new GrimlockException(Enumeration::class, $e->getMessage());
        }
    }

}