DROP DATABASE IF EXISTS personas;
CREATE DATABASE personas;
USE personas;

CREATE TABLE Genero (
  idGenero INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  genero VARCHAR(50) NOT NULL,
  PRIMARY KEY(idGenero)
);

CREATE TABLE Programa (
  idPrograma INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  programa VARCHAR(50) NOT NULL,
  PRIMARY KEY(idPrograma)
);

CREATE TABLE Persona (
  Identificacion INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) BINARY NOT NULL,
  email VARCHAR(100) NOT NULL,
  fecha_na DATE NOT NULL,
  idGenero INTEGER UNSIGNED NOT NULL,
  idPrograma INTEGER UNSIGNED NOT NULL,
  observaciones VARCHAR(500) NOT NULL,
  PRIMARY KEY(Identificacion),
  INDEX Persona_FKIndex1(idGenero),
  INDEX Persona_FKIndex2(idPrograma)
);

INSERT  INTO Genero(genero) VALUES
("Masculino"),
("Femenino"),
("Otro");

INSERT INTO Programa(programa) VALUES
("INGENIERIA DE SISTEMAS"),
("INGENIERIA INDUSTRIAL"),
("INGENIERIA AMBIENTAL"),
("INGENIERIA MÉCANICA"),
("ENFERMERÍA"),
("BACTERILOGÍA"),
("FÍSICA"),
("QUÍMICA"),
("MATEMÁTICAS");

SELECT Identificacion, nombre, email, fecha_na, 
  (SELECT G.genero FROM genero G WHERE G.idGenero = P.idGenero) as genero,
  (SELECT Pr.programa FROM programa Pr WHERE Pr.idPrograma = P.idPrograma) as programa, 
  observaciones 
FROM persona P;