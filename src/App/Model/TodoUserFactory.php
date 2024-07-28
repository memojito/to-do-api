<?php

declare(strict_types=1);

namespace App\Model;

use Exception;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;
use Mezzio\Authentication\UserInterface;
use Psr\Container\ContainerInterface;

class TodoUserFactory
{
    public function __invoke(ContainerInterface $container): callable
    {
        $adapter = $container->get(AdapterInterface::class);
        return function (string $identity, array $roles = [], array $details = []) use ($adapter): UserInterface {
            $sql    = new Sql($adapter);
            $select = $sql->select();
            $select->from('todousers')->where(['username' => $identity]);

            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = $statement->execute()->current();

            if (! $resultSet) {
                throw new Exception('Unauthorized', 403);
            }

            return new TodoUser(
                (int) $resultSet['id'],
                $resultSet['username'],
                $resultSet['password'],
                $roles,
                $details
            );
        };
    }
}
