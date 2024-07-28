<?php

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateTodoHandler implements RequestHandlerInterface
{
    private $todoService;
    private $logger;

    public function __construct(
        TodoService $todoService,
        LoggerInterface $logger
    ) {
        $this->todoService = $todoService;
        $this->logger      = $logger;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $title       = $data['title'] ?? null;
        $description = $data['description'] ?? null;

        if (empty($title) || empty($description)) {
            return new JsonResponse(['error' => 'Invalid input'], 400);
        }

        // Create the Todo item
        $todo = $this->todoService->createTodo($title, $description);

        // Log the creation of the new Todo item
        $this->logger->info('Created new todo item', ['todo' => $todo]);

        return new JsonResponse($todo, 201);
    }
}