<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Db\Adapter\AdapterInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class PutTodoHandlerFactory
{
    public function __invoke(ContainerInterface $container): PutTodoHandler
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $logger    = $container->get(LoggerInterface::class);

        return new PutTodoHandler($dbAdapter, $logger);
    }
}
