<?php

namespace Grimlock\Module\Notification\Firebase\Bean;

class Person
{

    private string $name;
    private string $lastname;
    private string $idRegistration;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIdRegistration(): string
    {
        return $this->idRegistration;
    }

    public function setIdRegistration(string $idRegistration): void
    {
        $this->idRegistration = $idRegistration;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

}