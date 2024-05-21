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
	login VARCHAR(100) NOT NULL,
    pass VARCHAR(255),
    nombre VARCHAR(100),
    email VARCHAR(100),
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
	idPieza VARCHAR(100) PRIMARY KEY,
	nombreOficial VARCHAR(100) NOT NULL,
    cofigoMarca VARCHAR(20),
    denominacion VARCHAR(100),
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
	nombreCategoria VARCHAR(100),
    descripcion VARCHAR(255),
    idFamilia INT
);

-- estructura tabala familia
CREATE TABLE familia (
	idFamilia INT AUTO_INCREMENT PRIMARY KEY,
	nombreFamilia VARCHAR(100),
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
	nombreFiscalCliente VARCHAR(255),
    denominacion VARCHAR(255),
    cifCliente VARCHAR(9),
    direccion VARCHAR(255),
    email VARCHAR(255)
);

-- estructura tabala para la relacion entre las piezas y el evento
CREATE TABLE piezas_evento (
	idPieza VARCHAR(100),
    idEvento INT,
    cantidad INT,
    observaciones VARCHAR(255)
);

-- CREACION CLAVES FORANEAS
ALTER TABLE usuario ADD FOREIGN KEY (idRol) REFERENCES rol(idRol);

-- creacion de una clave primaria compuesta para la tabla activityLog
ALTER TABLE activityLog ADD PRIMARY KEY (idUsuario, log);
-- creacion de clave foranea
ALTER TABLE activityLog ADD FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario) ON DELETE CASCADE;

ALTER TABLE pieza ADD FOREIGN KEY (idCategoria) REFERENCES categoria(idCategoria);

ALTER TABLE categoria ADD FOREIGN KEY (idFamilia) REFERENCES familia(idFamilia);

ALTER TABLE evento ADD FOREIGN KEY (idCliente) REFERENCES cliente(idCliente);

-- creacion de una clave primaria compuesta para la tabla piezas_evento
ALTER TABLE piezas_evento ADD PRIMARY KEY (idPieza, idEvento);
-- creacion de las dos claves foraneas
ALTER TABLE piezas_evento ADD FOREIGN KEY (idPieza) REFERENCES pieza(idPieza);
ALTER TABLE piezas_evento ADD FOREIGN KEY (idEvento) REFERENCES evento(idEvento);

-- INSERCCIÓN DE DATOS TABLA rol
INSERT INTO rol (idRol, nombreRol, descripcion) VALUES
(1, "administrador", "Acceso a toda la info y permisos de borrado y editado"),
(2, "trabajador", "Acceso a toda la info sin permisos de borrado y editado");

-- INSERCCION DE DATOS DE PRUEBA

INSERT INTO familia (idFamilia, nombreFamilia, logo, descripcion) VALUES (0, 'FamiliaTest', 'logoFamiliaTest', 'Test de familia');
INSERT INTO categoria (idCategoria, nombreCategoria, logo, descripcion, idFamilia) VALUES (0, 'CategoriaTest', 'logoCategoriaTest', 'Test de categoria', 0);
INSERT INTO pieza (idPieza, nombreOficial, cofigoMarca, denominacion, foto, precio, stock, peso, longitud, observaciones, idCategoria) VALUES ('testPieza', 'Test de Pieza', '1234.123', 'Una pieza de prueba', 'test', 100.99, 10, '100g', '40cm', 'observaciones', 0);

-- cambiamos como llamamos y describimos los roles
UPDATE rol SET nombreRol = 'edicion', descripcion = 'Permisos para hacer modificaciones' WHERE idRol = 1;
UPDATE rol SET nombreRol = 'lectura', descripcion = 'Permisos de solo lectura' WHERE idRol = 2;