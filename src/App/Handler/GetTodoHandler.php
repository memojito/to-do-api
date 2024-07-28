<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\TodoUser;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Authentication\UserInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class GetTodoHandler implements RequestHandlerInterface
{
    private AdapterInterface $dbAdapter;
    private LoggerInterface $logger;

    public function __construct(
        AdapterInterface $dbAdapter,
        LoggerInterface $logger
    ) {
        $this->logger    = $logger;
        $this->dbAdapter = $dbAdapter;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute(UserInterface::class);

        if (! $user instanceof TodoUser) {
            $this->logger->error('Invalid user type in request attributes');

            return new JsonResponse(['error' => 'Invalid user type'], 401);
        }

        $userId = $user->getId();
        $this->logger->info(
            'Fetching todos for user: ',
            ['user_id' => $userId]
        );
        
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from('todos')->where(['user_id' => $userId]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();

        $todos = [];
        foreach ($resultSet as $row) {
            $todos[] = $row;
        }

        return new JsonResponse($todos);
    }
}
