<?php

namespace Geekbrains\Php2;

use Geekbrains\Php2\Blog\Commands\Arguments;
use Geekbrains\Php2\Blog\Exceptions\InvalidArgumentException;
use Geekbrains\Php2\Blog\UUID;
use PHPUnit\Framework\TestCase;

class UUIDTest extends TestCase
{
    public function testItThrowsAnExceptionMalformedUUID(): void
    {
        $uuid = "x6d61d2d0-6bf8-426f-855a-dc9de949594b";

        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage("Malformed UUID: $uuid");

        new UUID("x6d61d2d0-6bf8-426f-855a-dc9de949594b");
    }
}
