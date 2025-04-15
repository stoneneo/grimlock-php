<?php

namespace Grimlock\Core\Exception;

use Exception;
use Throwable;

/**
 * Class GrimlockException
 * Grimlock's own exception to handle errors
 * @package Grimlock\Exception
 * @author Rubén Darío Huamaní Ucharima
 */
class GrimlockException extends Exception
{

    private bool $logging;

    /**
     * GrimlockException constructor.
     * @param $class
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($class, $message = "", $code = 0, $logging = false, Throwable $previous = null)
    {
        //parent::__construct("[".$class."] -> ".$message, $code, $previous);
        parent::__construct($message, $code, $previous);
        $this->logging = $logging;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if ($this->logging)
            return __CLASS__. " : [{$this->code}]: {$this->message}\n";
        else
            return " : [{$this->code}]: {$this->message}\n";
    }

}