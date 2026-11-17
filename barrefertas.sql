CREATE DATABASE IF NOT EXISTS barrefertas;

USE barrefertas;

DROP TABLE IF EXISTS comentarios;
DROP TABLE IF EXISTS curtidas;
DROP TABLE IF EXISTS pendentes;
DROP TABLE IF EXISTS amigos;
DROP TABLE IF EXISTS filmes;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    nascimento DATE NOT NULL,
    senha VARCHAR(256) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE filmes (
    id INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    nome VARCHAR(200) NOT NULL,
    descricao VARCHAR(500) NOT NULL,
    foto VARCHAR(200) NOT NULL,
    link VARCHAR(300) NOT NULL,
    classificacao INT NOT NULL,
    nota_usuario INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE amigos (
    id_usuario INT NOT NULL,
    id_amigo INT NOT NULL,
    PRIMARY KEY (id_usuario, id_amigo),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_amigo) REFERENCES usuarios(id)
);

CREATE TABLE pendentes (
    id_usuario INT NOT NULL,
    id_amigo INT NOT NULL,
    PRIMARY KEY (id_usuario, id_amigo),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_amigo) REFERENCES usuarios(id)
);

CREATE TABLE curtidas (
    id_usuario INT NOT NULL,
    id_filme INT NOT NULL,
    PRIMARY KEY (id_usuario, id_filme),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_filme) REFERENCES filmes(id)
);

CREATE TABLE comentarios (
    id INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_filme INT NOT NULL,
    comentario VARCHAR(400) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_filme) REFERENCES filmes(id)
);