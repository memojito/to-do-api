<?php

namespace App\Handler;

use App\Model\Todo;
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

class CreateTodoHandler implements RequestHandlerInterface
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
            'Creating a todo for user: ',
            ['user_id' => $userId]
        );

        $data = $request->getParsedBody();
        $todo = new Todo($data['title'], $data['txt'], $userId);

        $sql    = new Sql($this->dbAdapter);
        $insert = $sql->insert();
        $insert->into('todos');

        $insert->values([
            'title'         => $todo->getTitle(),
            'txt'           => $todo->getTxt(),
            'state'         => $todo->getState()->value,
            'user_id'       => $todo->getUserId(),
            'creation_date' => $todo->getCreationDate()->format('Y-m-d')
        ]);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $id        = $statement->execute()->getGeneratedValue();

        //$id = $this->dbAdapter->getDriver()->getLastGeneratedValue();
        // if there is a way to return last item or last item id?
        $this->logger->info('Created new todo item', ['id' => $id]);

        return new EmptyResponse(201);
    }
}
