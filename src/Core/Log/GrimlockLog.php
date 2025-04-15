<?php

namespace Grimlock\Core\Log;

use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\Log\Enum\LevelLog;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @author Ruben Dario Huamani Ucharima
 */
class GrimlockLog
{

    private Logger $logger;

    /**
     * @throws GrimlockException
     */
    public function __construct(LevelLog $level) {
        $this->logger = new Logger('Grimlock');
        if (empty($_ENV['PROJECT_LOG']) || $_ENV['PROJECT_LOG'] == '') {
            throw new GrimlockException(GrimlockLog::class,  'Grimlock File Log [PROJECT_LOG] not found or empty');
        }

        $streamHandler = new StreamHandler($_ENV['PROJECT_LOG'], $level->value);
        $this->logger->pushHandler($streamHandler);
    }

    public function error(string $message): void {
        $this->logger->error($message);
    }

    public function info(string $message): void {
        $this->logger->info($message);
    }

    public function debug(string $message): void {
        $this->logger->debug($message);
    }

    public function warn(string $message): void {
        $this->logger->warning($message);
    }

    public function notice(string $message): void {
        $this->logger->notice($message);
    }

    public function critical(string $message): void {
        $this->logger->critical($message);
    }

}