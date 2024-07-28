<?php

use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\Basic\BasicAccess;
use Mezzio\Authentication\UserRepository\PdoDatabase;
use Mezzio\Authentication\UserRepositoryInterface;

return [
    'dependencies' => [
        'aliases' => [
            UserRepositoryInterface::class => PdoDatabase::class,
            AuthenticationInterface::class => BasicAccess::class,
        ],
    ],
    'authentication' => [
        'realm' => 'api',
    ],
];
