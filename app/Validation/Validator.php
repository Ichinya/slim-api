<?php


namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;
use App\Requests\CustomRequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;

class Validator
{
    protected $requestHandler;
    public array $errors = [];

    public function validate(Request $request, array $rules): Validator
    {
        foreach ($rules as $field => $value) {
            try {
                $value->setName(ucfirst($field))->assert(CustomRequestHandler::getParam($request, $field));
            } catch (NestedValidationException $ex) {
                $this->errors[$field] = $ex->getMessages();
            }
        }
        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }
}