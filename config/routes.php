<?php

use App\Controllers\GuestEntryController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (Slim\App $app) {
    $app->post('/create-guest', [GuestEntryController::class, 'createGuest']);
    $app->options('/create-guest', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $response;
    });

    $app->get('/view-guest', [GuestEntryController::class, 'viewGuests']);
    $app->options('/view-guest', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $response;
    });

    $app->patch('/edit-guest/{id}', [GuestEntryController::class, 'editGuest']);
    $app->options('/edit-guest/{id}', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $response;
    });

    $app->delete('/delete-guest/{id}', [GuestEntryController::class, 'deleteGuest']);
    $app->options('/delete-guest/{id}', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $response;
    });

    $app->group("/auth", function ($app) {
        $app->post("/login", [\App\Controllers\AuthController::class, 'Login']);
        $app->options('/login', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
            return $response;
        });
        $app->post("/register", [\App\Controllers\AuthController::class, 'Register']);
        $app->options('/register', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
            return $response;
        });
    });
};
