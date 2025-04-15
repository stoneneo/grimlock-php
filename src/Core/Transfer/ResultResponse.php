<?php

namespace Grimlock\Core\Transfer;

use JsonSerializable;

/**
 *
 */
class ResultResponse implements JsonSerializable
{
    private bool $success = false;
    private string $message = '';
    private ?object $result = null;

    public function jsonSerialize(): array
    {
        return array(
            'success'   => $this->success,
            'message' => $this->message,
            'result' => $this->result
        );
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getResult(): ?object
    {
        return $this->result;
    }

    public function setResult(?object $result): void
    {
        $this->result = $result;
    }

}