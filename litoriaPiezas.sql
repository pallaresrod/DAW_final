-- drop database if exists LitoriaPiezas;
-- create database LitoriaPiezas;s
-- use LitoriaPiezas;

-- BASE DE DATOS: litoriaPiezas

-- al insertar un valor de 0 en una columna AUTO_INCREMENT, no se generará automáticamente el siguiente valor, sino que se insertará literalmente el 0
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"; 
-- todas las operaciones deben completarse con éxito o ninguna de ellas debe tener efecto
START TRANSACTION;
-- cualquier operación relacionada con el tiempo se realice en función de la zona horaria UTC (Coordinated Universal Time)
SET time_zone = "+00:00";

-- estructura tabla usuario
CREATE TABLE usuario (
	idUsuario INT AUTO_INCREMENT PRIMARY KEY,
	login VARCHAR(100) NOT NULL UNIQUE,
    pass VARCHAR(255),
    nombre VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    idRol INT,
    last_log datetime DEFAULT NULL
);

-- estructura activityLog
CREATE TABLE activityLog (
	idUsuario INT,
    log datetime
);

-- estructura aux rol
CREATE TABLE rol (
	idRol INT PRIMARY KEY,
    nombreRol VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255)
);

-- estructura tabala pieza
CREATE TABLE pieza (
	idPieza INT AUTO_INCREMENT PRIMARY KEY,
	codigoPieza VARCHAR(100) UNIQUE,
	nombreOficial VARCHAR(100) NOT NULL UNIQUE,
    codigoMarca VARCHAR(20),
    precio DECIMAL(7, 2),
    stock INT,
    stockActual INT DEFAULT NULL,
    peso VARCHAR(20),
    longitud VARCHAR(20),
    observaciones VARCHAR(255),
    idCategoria INT
);

-- estructura tabala categoria
CREATE TABLE categoria (
	idCategoria INT AUTO_INCREMENT PRIMARY KEY,
	nombreCategoria VARCHAR(100) UNIQUE,
    descripcion VARCHAR(255),
    idFamilia INT
);

-- estructura tabala familia
CREATE TABLE familia (
	idFamilia INT AUTO_INCREMENT PRIMARY KEY,
	nombreFamilia VARCHAR(100) UNIQUE,
    descripcion VARCHAR(255)
);

-- estructura tabala evento
CREATE TABLE evento (
	idEvento INT AUTO_INCREMENT PRIMARY KEY,
	nombreEvento VARCHAR(100),
    fechaInicioEstimada datetime,
    fechaFinalEstimada datetime,
    fechaInicioReal datetime,
    fechaFinalReal datetime,
    lugarEvento VARCHAR(255),
    observaciones VARCHAR(255),
    idCliente INT
);

-- estructura tabala cliente
CREATE TABLE cliente (
	idCliente INT AUTO_INCREMENT PRIMARY KEY,
	nombreFiscalCliente VARCHAR(255) UNIQUE,
    denominacion VARCHAR(255) UNIQUE,
    cifCliente VARCHAR(9) UNIQUE,
    direccion VARCHAR(255),
    email VARCHAR(255)
);

-- estructura tabala para la relacion entre las piezas y el evento
CREATE TABLE piezas_evento (
	idPieza INT,
    idEvento INT,
    cantidad INT,
    observaciones VARCHAR(255)
);

-- CREACION CLAVES FORANEAS
ALTER TABLE usuario ADD FOREIGN KEY (idRol) REFERENCES rol(idRol);

-- creacion de una clave primaria compuesta para la tabla activityLog
ALTER TABLE activityLog ADD PRIMARY KEY (idUsuario, log);

ALTER TABLE activityLog ADD FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario) ON DELETE CASCADE;

ALTER TABLE pieza ADD FOREIGN KEY (idCategoria) REFERENCES categoria(idCategoria);

ALTER TABLE categoria ADD FOREIGN KEY (idFamilia) REFERENCES familia(idFamilia);

ALTER TABLE evento ADD FOREIGN KEY (idCliente) REFERENCES cliente(idCliente);

-- creacion de una clave primaria compuesta para la tabla piezas_evento
ALTER TABLE piezas_evento ADD PRIMARY KEY (idPieza, idEvento);

ALTER TABLE piezas_evento ADD FOREIGN KEY (idPieza) REFERENCES pieza(idPieza);
ALTER TABLE piezas_evento ADD FOREIGN KEY (idEvento) REFERENCES evento(idEvento);



-- INSERCCIÓN DE DATOS TABLA rol
INSERT INTO rol (idRol, nombreRol, descripcion) VALUES
(1, "edicion", "Permisos para hacer modificaciones"),
(2, "lectura", "Permisos de solo lectura");

-- INSERCCION DE DATOS DE PRUEBA
INSERT INTO usuario (login, pass, nombre, email, idRol) VALUES ('test_1', '$2y$10$H5cCHNjCCY/6fXWi0ldgf.exQXQaar5j/SL6P5roQqcLJUfljqPMy', 'Test Uno', 'test@uno.com', 1); -- pass: TestTest1
INSERT INTO usuario (login, pass, nombre, email, idRol) VALUES ('test_2', '$2y$10$JM84GL/mFJ9wHQ3YUX9nIOumSSgO.l9NAkpPr.NXATd9xFYXHaH1i', 'Test Dos', 'test@dos.com', 1); -- pass: TestTest2
INSERT INTO usuario (login, pass, nombre, email, idRol) VALUES ('test_3', '$2y$10$39cK72KXZTWtbbs0UEvXj.Gon3Qd5wc9XoixFXdz0r2gKRtpm8BCW', 'Test Tres', 'test@tres.com', 1); -- pass: TestTest3

INSERT INTO familia (nombreFamilia, descripcion) VALUES ('Familia Test uno', 'Test de familia 1');
INSERT INTO familia (nombreFamilia, descripcion) VALUES ('Familia Test dos', 'Test de familia 2');
INSERT INTO familia (nombreFamilia, descripcion) VALUES ('Familia Test tres', 'Test de familia 3');

INSERT INTO categoria (nombreCategoria, descripcion, idFamilia) VALUES ('Categoria Test uno', 'Test de categoria 1', 1);
INSERT INTO categoria (nombreCategoria, descripcion, idFamilia) VALUES ('Categoria Test dos', 'Test de categoria 2', 2);
INSERT INTO categoria (nombreCategoria, descripcion, idFamilia) VALUES ('Categoria Test tres', 'Test de categoria 3', 3);
INSERT INTO categoria (nombreCategoria, descripcion, idFamilia) VALUES ('Categoria Test cuatro', 'Test de categoria 4', 2);

INSERT INTO pieza (codigoPieza, nombreOficial, codigoMarca, precio, stock, peso, longitud, observaciones, idCategoria) VALUES ('testPieza', 'Test de Pieza', '1234.123', 100.99, 10, '100g', '40cm', 'observaciones', 2);
INSERT INTO pieza (codigoPieza, nombreOficial, codigoMarca, precio, stock, peso, longitud, observaciones, idCategoria) VALUES ('testPiezaDos', 'Test de Pieza 2', '4321.123', 200.99, 20, '200g', '60cm', 'observaciones', 4);















