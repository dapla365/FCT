CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    rol INT DEFAULT 0,
    foto VARCHAR(255) DEFAULT NULL
);

INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('david', 'david', 'plazadiazdavid@gmail.com', 'David', 'Plaza Diaz', '2', 'images/david.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('inma', 'inma', 'inma@gmail.com', 'Inma', 'Perez Gonzalez', '1', 'images/inma.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('javi', 'javi', 'javi@gmail.com', 'Javi', 'Perez Gonzalez', '1', 'images/javi.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('paco', 'paco', 'paco@gmail.com', 'Paco', 'Perez Gonzalez', '1', 'images/paco.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('sofia', 'sofia', 'sofia@gmail.com', 'Sofia', 'Perez Gonzalez', '1', 'images/sofia.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('juan', 'juan', 'juan@gmail.com', 'Juan', 'Perez Gonzalez', '0', 'images/juan.png');

ALTER TABLE usuarios ADD CONSTRAINT ROL FOREIGN KEY (rol) REFERENCES roles(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
