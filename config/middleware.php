<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;

return function (App $app) {
    $app->getContainer()->get('settings');
    $app->addRoutingMiddleware();

    $app->add(
        new Tuupola\Middleware\JwtAuthentication([
            "ignore" => ["/auth/login", "/auth/register"],
            "secret" => \App\Interfaces\SecretKeyInterface::JWT_SECRET_KEY,
            "error" => function (Response $response, $arguments) {
                $data = [
                    "success" => false,
                    "response" => $arguments['message'],
                    "status_code" => 401
                ];
                return $response
                    ->withHeader("Content-Type", "application/json; charset=UTF-8")
                    ->getBody()
                    ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }
        ])
    );
    $app->addErrorMiddleware(true, true, true);
};