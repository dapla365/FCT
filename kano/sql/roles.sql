CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(20) NOT NULL,
    nivel INT NOT NULL DEFAULT 0
);

INSERT INTO roles(nombre, nivel) VALUES ('USUARIO', 0);
INSERT INTO roles(nombre, nivel) VALUES ('PELUQUERO', 5);
INSERT INTO roles(nombre, nivel) VALUES ('JEFE-PELUQUERO', 10);
INSERT INTO roles(nombre, nivel) VALUES ('JEFE', 10);
