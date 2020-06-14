CREATE DATABASE IF NOT EXISTS laravel_master;
USE laravel_master;

CREATE TABLE IF NOT EXISTS users (
    id              int(255) auto_increment not null,
    role            varchar(20),
    name            varchar(100),
    surname         varchar(200),
    nick            varchar(100),
    email           varchar(255),
    password        varchar(255),
    image           varchar(255),
    created_at      datetime,
    updated_at      datetime,
    remember_token  varchar(255),
    CONSTRAINT pk_users PRIMARY KEY (id)
)ENGINE=InnoDb;

INSERT INTO users VALUES (null, 'user', 'Gonzalo', 'Iglesias', 'ghiglesias', 'gi@gmail.com', 'pass', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES (null, 'user', 'Mariela', 'Navarro', 'marunav', 'maru@gmail.com', 'passmaru', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES (null, 'user', 'Juan', 'Lopez', 'juanlopez', 'jlopez@gmail.com', 'passjuan', null, CURTIME(), CURTIME(), null);

CREATE TABLE IF NOT EXISTS images (
    id              int(255) auto_increment not null,
    user_id         int(255),
    image_path      varchar(255),
    description     text,
    created_at      datetime,
    updated_at      datetime,
    CONSTRAINT pk_images PRIMARY KEY (id),
    CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

INSERT INTO images VALUES(null, 1, 'test.jpg', 'descripcion de prueba 1', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, 'playa.jpg', 'descripcion de prueba 2', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, 'arena.jpg', 'descripcion de prueba 3', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 3, 'familia.jpg', 'descripcion de prueba 4', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS comments (
    id              int(255) auto_increment not null,
    user_id         int(255),
    image_id        int(255),
    content         text,
    created_at      datetime,
    updated_at      datetime,
    CONSTRAINT pk_comments PRIMARY KEY (id),
    CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO comments VALUES (null, 1, 4, 'Buena foto de familia!', CURTIME(), CURTIME());
INSERT INTO comments VALUES (null, 2, 1, 'Buena foto de playa!', CURTIME(), CURTIME());
INSERT INTO comments VALUES (null, 2, 4, 'que buenooo!', CURTIME(), CURTIME());


CREATE TABLE IF NOT EXISTS likes (
    id              int(255) auto_increment not null,
    user_id         int(255),
    image_id        int(255),
    created_at      datetime,
    updated_at      datetime,
    CONSTRAINT pk_likes PRIMARY KEY (id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO likes VALUES(null, 1, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 2, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 3, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 3, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 2, 1, CURTIME(), CURTIME());

