<?php

namespace App\Controllers;

use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GuestEntryController
{

    protected $customResponse;

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
    }

    public function createGuest(Request $request, Response $response)
    {
        $username = CustomRequestHandler::getParam($request,"name");
        return $this->customResponse->is200Response($response, $username);
    }
}