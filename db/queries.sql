CREATE DATABASE db-CRUD COLLATE utf8mb4_general_ci;
CREATE TABLE users (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY(id)
);
CREATE TABLE posts (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    `image` VARCHAR(255),
    body TEXT NOT NULL,
    user_id INTEGER UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);
INSERT INTO users (name, email, password)
VALUES (
        'Mohamed',
        'mohamed@gmail.com',
        '$2y$10$DtqF11r0GAp9/S4DM5zDe.RigF3bACRz9Dd.qxbbKZ3rDRUCsWvGC'
    );