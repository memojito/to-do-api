<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Db\Adapter\AdapterInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class DeleteTodoHandlerFactory
{
    public function __invoke(ContainerInterface $container): DeleteTodoHandler
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $logger    = $container->get(LoggerInterface::class);

        return new DeleteTodoHandler($dbAdapter, $logger);
    }
}
