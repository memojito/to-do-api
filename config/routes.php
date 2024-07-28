<?php

declare(strict_types=1);

use App\Handler\CreateTodoHandler;
use App\Handler\DeleteTodoHandler;
use App\Handler\GetTodoHandler;
use App\Handler\HomePageHandler;
use App\Handler\PingHandler;
use App\Handler\PutTodoHandler;
use Mezzio\Application;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

/**
 * FastRoute route configuration
 *
 * @see https://github.com/nikic/FastRoute
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/{id:\d+}', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

return static function (
    Application $app,
    MiddlewareFactory $factory,
    ContainerInterface $container
): void {
    $app->get('/api/v1', HomePageHandler::class, 'home');
    $app->get('/api/ping', PingHandler::class, 'api.ping');
    $app->get('/api/v1/todos', GetTodoHandler::class, 'todos.get');
    $app->post(
        '/api/v1/todos',
        [BodyParamsMiddleware::class, CreateTodoHandler::class],
        'todos.post'
    );
    $app->delete(
        '/api/v1/todos/{todoId}',
        DeleteTodoHandler::class,
        'todos.delete'
    );
    $app->put('/api/v1/todos/{todoId}', PutTodoHandler::class, 'todos.put');
};
