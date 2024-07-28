<?php

declare(strict_types=1);

namespace App\Model;

use Mezzio\Authentication\UserInterface;

class TodoUser implements UserInterface
{
    private int $id;
    private string $username;
    private string $password;
    private array $roles;
    private array $details;

    public function __construct(int $id, string $username, string $password, array $roles = [], array $details = [])
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->roles = ['admin'];
        $this->details = ['details'];
    }

    /**
     * @inheritDoc
     */
    public function getIdentity(): string
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): iterable
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function getDetail(string $name, $default = null)
    {
        return $this->details[$name] ?? $default;
    }

    /**
     * @inheritDoc
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
