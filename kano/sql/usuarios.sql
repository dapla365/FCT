CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id VARCHAR(255),
    username VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255),
    correo VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    rol INT DEFAULT 0,
    foto VARCHAR(255) DEFAULT "images/defecto.png"
);

INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('david00000', '$2y$10$cUbu7E3mNAGDPD7761OUlOojnKQl794YKTC35AUgSBt2M9GZQh/Iu', 'plazadiazdavid@gmail.com', 'David', 'Plaza Diaz', '3', 'images/david.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('inma11111', '$2y$10$3SMzIY8vq/A8XDutFPrlNuH54qZ2LrXSg1wDltggmnoKSnqPg6Ydm', 'inma@gmail.com', 'Inma', 'Gutierrez Gonzalez', '1', 'images/inma.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('javi22222', '$2y$10$OAtVluwtny5Bacz6W9uh7OdaJYB3d5Fb94KobIMvYRQLZqpm3YFL.', 'javi@gmail.com', 'Javi', 'Pelayo Pelatu', '2', 'images/javi.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('paco33333', '$2y$10$Ea8DwraYqIF82abvkmBI/eeArT2KVZLwe/u6yOk/hpcnt2YefjGr2', 'paco@gmail.com', 'Paco', 'Mefi Lete', '1', 'images/paco.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('sofia44444', '$2y$10$crdPeQ1WdoGqZ/TetVub4uQi/LQyLMqwDLWHkCXI0D6SvTm/T95Hi', 'sofia@gmail.com', 'Sofia', 'Cano Cozar', '1', 'images/sofia.png');
INSERT INTO usuarios(username, contrasena, correo, nombre, apellidos, rol, foto) VALUES ('juan55555', '$2y$10$SSqNEzQOy6PGkP35YjgKbetywIxq6EgzDrBlBd7NF88b9GGrD8r5O', 'juanrodriguezcastro86@gmail.com', 'Juan', 'Rodriguez Naprawca', '0', 'images/juan.png');

ALTER TABLE usuarios ADD CONSTRAINT ROL FOREIGN KEY (rol) REFERENCES roles(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
