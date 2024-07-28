<?php

namespace App\Handler;

use App\Model\TodoUser;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Authentication\UserInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class DeleteTodoHandler implements RequestHandlerInterface
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
            'Deleting a todo for user: ',
            ['user_id' => $userId]
        );

        $todoId = (int)$request->getAttribute('todoId');

        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from('todos')
               ->where(['id' => $todoId, 'user_id' => $userId]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute()->current();

        if ( ! $resultSet) {
            return new JsonResponse(
                ['error' => 'Todo not found or not owned by user'],
                404
            );
        }

        $delete = $sql->delete();
        $delete->from('todos')->where(['id' => $todoId]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();

        return new EmptyResponse();
    }
}
