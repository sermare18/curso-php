-- Fichero de inicialización de  base de datos
-- Por si borramos la db contacts_app nos permite volver a crearla

DROP DATABASE IF EXISTS contacts_app;

CREATE DATABASE contacts_app;

USE contacts_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

-- Ejemplo insercción de un usuario desde la propia base de datos
-- INSERT INTO users (name, email, password) VALUES("Sergio", "sergio.mare2002@gmail.com", "test1234");

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255),
    phone_number VARCHAR(255),

    -- Cualquier contacto que añadamos siempre va a estar asociado a un usuario, concretamente al id del usuario
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Ejemplo insercción de un contacto desde la propia base de datos
-- INSERT INTO contacts (user_id, name, phone_number) VALUES(1,"Antonio","123456789");

