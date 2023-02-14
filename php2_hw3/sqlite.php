<?php
//Подключение к SQLite из PHP

//Создаём объект подключения к SQLite
$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

//Вставляем строку в таблицу пользователей
$connection->exec(
    "INSERT INTO users (first_name, last_name) VALUES ('Ivan', 'Nikitin')"
);


/* Запросы из консоли
ALTER TABLE users ADD uuid TEXT;  // Добавим поле uuid к таблице пользователей:

DROP TABLE users;  // удаляем таблицу

CREATE TABLE users (
uuid TEXT NOT NULL
CONSTRAINT uuid_primary_key PRIMARY KEY,
username TEXT NOT NULL
CONSTRAINT username_unique_key UNIQUE,
first_name TEXT NOT NULL,
last_name TEXT NOT NULL
);

SELECT * FROM users WHERE username = 'User-4'
 */