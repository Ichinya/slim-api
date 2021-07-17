<?php

use App\Controllers\GuestEntryController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (Slim\App $app) {
    $app->post('/create-guest', [GuestEntryController::class, 'createGuest']);
    $app->get('/view-guest', [GuestEntryController::class, 'viewGuests']);
    $app->patch('/edit-guest/{id}', [GuestEntryController::class, 'editGuest']);
    $app->delete('/delete-guest/{id}', [GuestEntryController::class, 'deleteGuest']);

    $app->group("/auth", function ($app) {
        $app->post("/login", [\App\Controllers\AuthController::class, 'Login']);
        $app->post("/register", [\App\Controllers\AuthController::class, 'Register']);
    });
};