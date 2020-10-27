--Crea la base de datos 
create database if not exists DAW204DBDepartamentos;

--Usa la base de datos DAW204DBDepartamentos
use DAW204DBDepartamentos;

--Crea la tabla Departamento
create table if not exists Departamento(
    CodDepartamento varchar(3) primary key,
    DescDepartamento varchar(255),
    FechaBaja date,
    VolumenNegocio float
)ENGINE=InnoDB;

--Crea el usuario usuarioDAW204DBDepartamentos
create user if not exists 'usuarioDAW204DBDepartamentos'@'%' identified by "paso";

--Da privilegios todos los privilegios sobre la base de datos 
grant all privileges on DAW204DBDepartamentos.* to 'usuarioDAW204DBDepartamentos'@'%';