<?php

namespace GeekBrains\LevelTwo\Person;

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

    public function __toString(): string
    {
        return "Пользователь: id $this->id с именем $this->username и логином $this->login.";
    }
}
