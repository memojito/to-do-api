<?php

namespace App\Model;

use App\Enum\TodoState;

class Todo
{
    private ?int $id;
    private string $title;
    private string $txt;
    private TodoState|string $state;
    private int $userId;
    private \DateTime $creationDate;

    public function __construct(
        string $title,
        string $txt,
        int $userId
    ) {
        $this->title        = $title;
        $this->txt          = $txt;
        $this->state        = TodoState::CREATED;
        $this->userId       = $userId;
        $this->creationDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTxt(): string
    {
        return $this->txt;
    }

    public function getState(): TodoState
    {
        return $this->state;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }
}
