CREATE TABLE tipos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(255) NOT NULL,
    precio INT NOT NULL
);

INSERT INTO tipos (tipo, precio) VALUES ('Corte', 10);
INSERT INTO tipos (tipo, precio) VALUES ('Barba', 6);
INSERT INTO tipos (tipo, precio) VALUES ('Corte y barba', 15);
