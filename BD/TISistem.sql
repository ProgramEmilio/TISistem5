Create database TISistem;
Use TISistem;
-- crar llaves foraneas
-- id salon
-- drop database TISistem

Create table Tipo_Usuarios(
Id_Utipo int not null auto_increment primary key,
Utipo varchar(50) not null
);


Create table Usuarios(
Id_usuario int not null auto_increment primary key,
Id_Utipo int not null,
nombre varchar(50) not null,
apellido varchar(50) not null,
Id_departamento int not null,
contraseña varchar(20)
);

alter table Usuarios add(
foreign key(Id_Utipo) references Tipo_Usuarios(Id_Utipo)
);

Create table departamento(
Id_departamento int not null auto_increment primary key,
nombre varchar(50) not null,
J_departamento varchar(100) not null
);

create table edificio(
Id_edificio varchar(20) not null,
Id_departamento int not null,
PRIMARY KEY(Id_edificio, Id_departamento)
);

create table tipo_salon (
id_ts int not null auto_increment primary key,
tipo  varchar(20) not null
);

Create table salon(
Id_salon varchar(20) not null primary key,
Id_edificio varchar(20) not null,
tipo int not null,
Id_usuario int not null,
descripcion text
);

alter table salon add(
foreign key(tipo) references tipo_salon(id_ts)
);
alter table salon add(
foreign key(Id_usuario) references Usuarios(Id_usuario)
);

Create table PC(
Id_PC varchar(15) not null primary key,
Id_salon varchar(20) not null,
PCtipo varchar(15) not null,
procesador varchar(15) not null,
rom varchar(15) not null,
ram varchar(15) not null,
serie varchar(15) not null,
MAC varchar(15) not null,
fechacompra date not null
);

Create table Impresoras(
Id_Impresoras varchar(15) not null primary key,
Id_salon varchar(20) not null,
Imtipo varchar(15) not null,
serie varchar(15) not null,
marca varchar(15) not null,
descripcion text,
fechacompra date not null
);

Create table Proyector(
Id_Proyector varchar(15) not null primary key,
Id_salon varchar(20) not null,
Protipo varchar(15) not null,
serie varchar(15) not null,
marca varchar(15) not null,
descripcion text,
fechacompra date not null
);


Create table Reporte(
Id_reporte int not null primary key auto_increment,
Id_usuario int not null,
Id_trabajador int not null,
Id_equipo varchar(15) not null,
Estado varchar(15)not null,
Fecha datetime,
Id_catalogo int not null,
Prioridad varchar(15) not null,
Fecha_Liberado datetime not null
);

Create table Peticion(
Id_peticion int not null primary key auto_increment,
Id_trabajador int not null,
Id_equipo varchar(15) not null,
Estado varchar(15)not null,
Fecha datetime,
peticion text not null,
presupuesto float not null
);

Create table catalogo_servicios(
Id_catalogo int not null primary key auto_increment,
catalogo text not null
);

Create table Problemas(
Id_problema int not null primary key auto_increment,
problema text not null,
causa_raiz text not null,
error_conocido text not null,
solucion text not null,
usuario int not null
);

CREATE TABLE respuestas (
id_respuesta int not null primary key auto_increment,
facilidad text not null,
rendimiento text not null,
precisi text not null
);

CREATE TABLE Hallazgo (
Id_hallazgo int not null primary key auto_increment,
Id_reporte int not null,
Id_trabajador int not null,
descripcion text not null,
requiere int not null,
Fecha datetime
);

alter table Hallazgo add(
foreign key(Id_trabajador) references Usuarios(Id_usuario),
foreign key(Id_reporte) references Reporte(Id_reporte)
);

alter table Problemas add(
foreign key(usuario) references Usuarios(Id_usuario)
);

alter table Peticion add(
foreign key(Id_trabajador) references Usuarios(Id_usuario)
);

alter table Reporte add(
foreign key(Id_catalogo) references catalogo_servicios(Id_catalogo)
);

alter table Reporte add(
foreign key(Id_usuario) references Usuarios(Id_usuario),
foreign key(Id_trabajador) references Usuarios(Id_usuario)
);

alter table Usuarios add(
foreign key(Id_departamento) references departamento(Id_departamento)
);
alter table edificio add(
foreign key(Id_departamento) references departamento(Id_departamento)
);
alter table salon add(
foreign key(Id_edificio) references edificio(Id_edificio)
);
alter table PC add(
foreign key(Id_salon) references salon(Id_salon)
);
alter table Impresoras add(
foreign key(Id_salon) references salon(Id_salon)
);
alter table Proyector add(
foreign key(Id_salon) references salon(Id_salon)
);


-- Inserts
INSERT INTO `departamento` (`Id_departamento`, `nombre`, `J_departamento`) VALUES 
(NULL, 'Sistemas', 'Marysol'), 
(NULL, 'Gestion Empresarial', 'Fidel castro'), 
(NULL, 'Industrial', 'Espinosa paz');

INSERT INTO `edificio` (`Id_edificio`, `Id_departamento`) VALUES 
('A', '1'), 
('B', '1'), 
('CC', '1'), 
('F', '3'), 
('G', '3'), 
('H', '3'), 
('P', '2'), 
('Q', '2'), 
('R', '2');

INSERT INTO `tipo_salon` (`id_ts`, `tipo`) VALUES 
(1, 'Clases'), 
(2, 'Cubiculo'), 
(3, 'Laboratorio'), 
(4, 'Oficina');

INSERT INTO `tipo_usuarios` (`Id_Utipo`, `Utipo`) VALUES 
(1, 'Admin'), 
(2, 'Usuario'), 
(3, 'Trabajador'), 
(4, 'Jefe de taller'),
(5, 'Consejo');

INSERT INTO `usuarios` (`Id_usuario`, `Id_Utipo`, `nombre`, `apellido`, `Id_departamento`, `contraseña`) VALUES 
(1, '1', 'Emilio', 'Palma Jimenez', '1', '12'), 
(2, '2', 'Pedro', 'Ramirez Parra', '2', '12'), 
(3, '3', 'Juan', 'Melendres Lechuga', '1', '12'), 
(4, '2', 'Ramon', 'Ramirez Parra', '3', '12'), 
(5, '4', 'Angel', 'sanchez de la Cruz', '1', '12'), 
(6, '3', 'Ghost', 'Ramirez Parra', '1', '12');

INSERT INTO `salon` (`Id_salon`, `Id_edificio`, `tipo`, `Id_usuario`, `descripcion`) VALUES 
('A1', 'A', '1', '1', 'Clases normales'), 
('B1', 'B', '1', '1', 'Clases normales'), 
('F1', 'F', '1', '3', 'Clases normales'), 
('G1', 'G', '1', '4', 'Clases normales'), 
('H1', 'H', '1', '4', 'Clases normales'), 
('PW', 'CC', '3', '1', 'Clases normales'), 
('Q1', 'Q', '1', '1', 'Clases normales'), 
('R1', 'R', '1', '2', 'Clases normales'), 
('UP', 'P', '1', '1', 'Clases normales');


INSERT INTO `impresoras` (`Id_Impresoras`, `Id_salon`, `Imtipo`, `serie`, `marca`, `descripcion`, `fechacompra`) VALUES 
('Im-001', 'A1', 'Inyeccion', 'edwfsdsssfdfd', 'Canonon', 'hhhththtdhtdt', '2009-02-19');

INSERT INTO `pc` (`Id_PC`, `Id_salon`, `PCtipo`, `procesador`, `rom`, `ram`, `serie`, `MAC`, `fechacompra`) VALUES 
('Pc-001', 'A1', 'Escritorio', 'Core i9', '500gb SSD', '16gb', 'edwfsdsssfdfd', 'sccdcdsdds4', '2009-02-16'), 
('Pc-002', 'B1', 'Escritorio', 'Core i9', '500gb', '16gb', 'edwfsdsssfdfd', 'sccdcdsdds', '2009-02-19'), 
('Pc-003', 'PW', 'Escritorio', 'Core i9', '500gb', '16gb', 'edwfsdsssfdfd', 'sccdcdsdds4', '2009-02-18'), 
('Pc-004', 'F1', 'Escritorio', 'Core i9', '502gb', '16gb', 'edwfsdsssfdfd', 'sccdcdsdds', '2009-02-16'), 
('Pc-005', 'G1', 'Escritorio', 'Core i9', '500gb', '16gb', 'edwfsdsssfdfd', '65654654hggfff', '2009-02-19'), 
('Pc-006', 'H1', 'Escritorio', 'Core i9', '502gb', '18gb', 'edwfsdsssfdfd', 'sccdcdsdds', '2009-02-18'), 
('Pc-007', 'Q1', 'Todo en uno', 'Core i9', '500gb', '16gb', 'edwfsdsssfdfd55', 'sccdcdsdds4', '2009-02-19'), 
('Pc-008', 'Q1', 'Todo en uno', 'Core i9', '500gb', '16gb', 'edwfsdsssfdfd55', 'sccdcdsdds', '2009-02-16'), 
('Pc-009', 'R1', 'Escritorio', 'Core i9', '502gb', '16gb', 'edwfsdsssfdfd', 'sccdcdsdds', '2009-02-18'), 
('Pc-010', 'UP', 'Escritorio', 'Core i9', '500gb', '16gb', 'edwfsdsssfdfd4', 'sccdcdsdds4', '2009-02-16');

INSERT INTO `proyector` (`Id_Proyector`, `Id_salon`, `Protipo`, `serie`, `marca`, `descripcion`, `fechacompra`) VALUES 
('Pro-001', 'A1', 'Inyeccion', 'edwfsdsssfdfd33', 'Canonon', 'fsdfdsdfsdffsdfs', '2009-02-18');
