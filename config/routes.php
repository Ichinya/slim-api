<?php

use App\Controllers\GuestEntryController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (Slim\App $app) {
    $app->post('/create-guest', [GuestEntryController::class, 'createGuest']);
};