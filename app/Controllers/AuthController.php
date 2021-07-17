<?php

namespace App\Controllers;

use App\Models\Users;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use App\Validation\Validator;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;

class AuthController
{

    protected Users $user;
    protected CustomResponse $customResponse;
    protected Validator $validator;

    public function __construct()
    {
        $this->user = new Users();
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
    }

    public function Register(Request $request, Response $response): Response
    {
        $this->validator->validate($request, [
            "name" => v::notEmpty(),
            "email" => v::notEmpty()->email(),
            "password" => v::notEmpty()
        ]);

        if ($this->validator->failed()) {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response, $responseMessage);
        }
        if ($this->EmailExist(CustomRequestHandler::getParam($request, 'email'))) {
            $responseMessage = "email уже существует";
            return $this->customResponse->is400Response($response, $responseMessage);
        }

        $passwordHash = $this->hashPassword(CustomRequestHandler::getParam($request, 'password'));

        $this->user->create([
            "name" => CustomRequestHandler::getParam($request, 'name'),
            "email" => CustomRequestHandler::getParam($request, 'email'),
            "password" => $passwordHash
        ]);
        $responseMessage = "Пользователь создан";
        return $this->customResponse->is200Response($response, $responseMessage);
    }

    public function Login(Request $request, Response $response): Response
    {
        $this->validator->validate($request, [
            "email" => v::notEmpty()->email(),
            "password" => v::notEmpty()
        ]);
        if ($this->validator->failed()) {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response, $responseMessage);
        }
        $verifyAccount = $this->verifyAccount(
            CustomRequestHandler::getParam($request, 'password'),
            CustomRequestHandler::getParam($request, 'email')
        );

        if ($verifyAccount == false) {
            $responseMessage = "invalid password";
            return $this->customResponse->is400Response($response, $responseMessage);
        }

        $responseMessage = GenerateTokenController::generateToken(CustomRequestHandler::getParam($request, 'email'));
        return $this->customResponse->is200Response($response, $responseMessage);
    }

    public function verifyAccount($password, $email): bool
    {
        $count = $this->user->where(['email' => $email])->count();
        if ($count == 0) {
            return false;
        }
        $user = $this->user->where(['email' => $email])->first();
        $passwordHash = $user->password;
        return password_verify($password, $passwordHash);
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function EmailExist($email): bool
    {
        $count = $this->user->where(['email' => $email])->count();
        if ($count == 0) {
            return false;
        }
        return true;
    }

}