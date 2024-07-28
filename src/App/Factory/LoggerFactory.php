<?php

declare(strict_types=1);

namespace App\Factory;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class LoggerFactory
{
    public function __invoke(ContainerInterface $container): Logger
    {
        $logger = new Logger('todo');

        $streamHandler = new StreamHandler('php://stdout');
        $streamHandler->setFormatter(new LineFormatter());
        $logger->pushHandler($streamHandler);

        return $logger;
    }
}
