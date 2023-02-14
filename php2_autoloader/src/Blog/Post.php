<?php

namespace GeekBrains\LevelTwo\Blog;

use GeekBrains\LevelTwo\Person\Person;

class Post
{
    /**
     * @param int $id
     * @param Person $author
     * @param string $text
     */
    public function __construct(
        private int $id,
        private Person $author,
        private string $text
    ) {
    }

    public function __toString()
    {
        return $this->author . ' пишет: ' . $this->text;
    }
}