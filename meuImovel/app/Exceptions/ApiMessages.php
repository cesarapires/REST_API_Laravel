<?php

namespace App\Exceptions;

class ApiMessages{

    private $message = [];

    public function __construct(string $message, array $data = []){
        $this->message['message'] = $message;
        $this->message['errors'] = $data;
    }

    public function getMessage(): array{
        return $this->message;
    }
}
