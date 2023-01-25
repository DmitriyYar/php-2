<?php

namespace Geekbrains\Php2\Person;

class User
{
    /**
     * @param int $id
     * @param Name $username
     * @param string $login
     */
    public function __construct(
        private int    $id,
        private Name   $username,
        private string $login,
    ) {
    }

    /**
     * @return Name
     */
    public function getUsername(): Name
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    public function __toString(): string
    {
        return "Пользователь: id $this->id с именем $this->username и логином $this->login.";
    }
}

