<?php

namespace Grimlock\Core\Transfer;

use JsonSerializable;

class ErrorResponse implements JsonSerializable
{
    private int $code = 0;
    private string $message = '';
    public function jsonSerialize(): array
    {
        return array(
            'code' => $this->code,
            'message' => $this->message
        );
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

}