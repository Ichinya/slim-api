<?php

namespace App\Response;

use Psr\Http\Message\ResponseInterface as Response;

class CustomResponse
{
    public function is200Response(Response $response, $responseMessage): Response
    {
        $responseMessage = json_encode(["success" => true, "response" => $responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader('Content-Type', "application/json")
            ->withStatus(200);
    }

    public function is400Response(Response $response, $responseMessage): Response
    {
        $responseMessage = json_encode(["success" => true, "response" => $responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader('Content-Type', "application/json")
            ->withStatus(400);
    }


}