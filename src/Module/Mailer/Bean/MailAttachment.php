<?php

namespace Grimlock\Module\Mailer\Bean;

class MailAttachment
{

    private string $base64;
    private string $name;
    private string $type;

    public function getBase64(): string
    {
        return $this->base64;
    }

    public function setBase64(string $base64): void
    {
        $this->base64 = $base64;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

}

