<?php

namespace App\DTO;

class UserDTO
{
    private string $email;
    private int $id;
    private array $roles;

    public function __construct(string $email, int $id, array $roles)
    {
        $this->email = $email;
        $this->id = $id;
        $this->roles = $roles;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}