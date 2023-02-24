-- Fichero de inicialización de  base de datos
-- Por si borramos la db contacts_app nos permite volver a crearla

DROP DATABASE IF EXISTS contacts_app;

CREATE DATABASE contacts_app;

USE contacts_app;

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    phone_number VARCHAR(255)
);

-- Ejemplo insercción de un contacto desde la propia base de datos
INSERT INTO contacts (name, phone_number) VALUES("Pepe","123456789");

