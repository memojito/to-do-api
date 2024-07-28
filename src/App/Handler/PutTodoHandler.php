<?php

namespace App\Handler;

use App\Model\TodoUser;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Authentication\UserInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class PutTodoHandler implements RequestHandlerInterface
{
    private AdapterInterface $dbAdapter;
    private LoggerInterface $logger;

    public function __construct(
        AdapterInterface $dbAdapter,
        LoggerInterface $logger,
    ) {
        $this->logger    = $logger;
        $this->dbAdapter = $dbAdapter;
    }


    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute(UserInterface::class);

        if ( ! $user instanceof TodoUser) {
            $this->logger->error('Invalid user type in request attributes');

            return new JsonResponse(['error' => 'Invalid user type'], 401);
        }

        $userId = $user->getId();
        $this->logger->info(
            'Updating a todo for user: ',
            ['user_id' => $userId]
        );
    }
}