CREATE TABLE correo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    token VARCHAR(255) NOT NULL
);
