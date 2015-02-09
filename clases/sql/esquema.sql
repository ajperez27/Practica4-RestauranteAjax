create database restaurante default
character set utf8 collate utf8_unicode_ci;

grant all on restaurante.* to
root@localhost identified by '';

flush privileges;

CREATE TABLE plato (
  idPlato int not null auto_increment primary key,
  nombre varchar(30) not null,
  descripcion varchar(300) not null,
  precio decimal(6,2) not null
) ENGINE=InnoDB;

CREATE TABLE foto (
idFoto int NOT NULL auto_increment,
idPlato int not null,    
url varchar(250)NOT NULL,
CONSTRAINT PK_id_fotos PRIMARY KEY(idFoto),
CONSTRAINT FK_id_plato FOREIGN KEY (idPlato) REFERENCES plato(idPlato) ON DELETE CASCADE ON UPDATE CASCADE
)

CREATE TABLE IF NOT EXISTS `usuario` (
`login` varchar(30) NOT NULL primary key,
`clave` varchar(40) NOT NULL,
`nombre` varchar(30) NOT NULL,
`apellidos` varchar(60) NOT NULL,
`email` varchar(40) NOT NULL,
`fechaalta` date NOT NULL,
`isactivo` tinyint(1) NOT NULL,
`isroot` tinyint(1) NOT NULL DEFAULT 0,
`rol` enum('administrador', 'usuario') NOT NULL DEFAULT 'usuario',
`fechalogin` datetime
) ENGINE=InnoDB;