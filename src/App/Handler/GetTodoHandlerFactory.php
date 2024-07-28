<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Db\Adapter\AdapterInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class GetTodoHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetTodoHandler
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $logger    = $container->get(LoggerInterface::class);

        return new GetTodoHandler($dbAdapter, $logger);
    }
}
