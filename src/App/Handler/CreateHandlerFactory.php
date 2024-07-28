<?php

namespace App\Handler;

use Laminas\Db\Adapter\AdapterInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class CreateHandlerFactory
{
    public function __invoke(ContainerInterface $container): CreateTodoHandler
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $logger    = $container->get(LoggerInterface::class);

        return new CreateTodoHandler($dbAdapter, $logger);
    }
}