<?php

namespace App\Response;

class CustomResponse
{
    public function is200Response($response, $responseMessage)
    {
        $responseMessage = json_encode(["success" => true, "response" => $responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader('Contant-Type', "application/json")
            ->withStatus(200);
    }

    public function is400Response($response, $responseMessage)
    {
        $responseMessage = json_encode(["success" => true, "response" => $responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader('Contant-Type', "application/json")
            ->withStatus(400);
    }


}