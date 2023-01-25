<?php

namespace GeekBrains\LevelTwo\Person;

//use src\Person\Name;

class Person
{
    /**
     * @param Name $name
     * @param \DateTimeImmutable $registeredOn
     */
    public function __construct(
        private Name $name,
        private \DateTimeImmutable $registeredOn
    ) {
    }

    public function __toString()
    {
        return $this->name . ' (на сайте с ' . $this->registeredOn->format('Y-m-d') . ')';
    }
}
