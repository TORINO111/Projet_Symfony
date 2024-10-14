<?php

namespace App\DTO;

class ClientSearch
{
    public ?string $surname = null;
    public ?string $telephone = null;

    public ?bool $hasUser = null;

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function hasUser(): ?bool
    {
        return $this->hasUser;
    }

    public function setHasUser(?bool $hasUser): self
    {
        $this->hasUser = $hasUser;
        return $this;
    }
}