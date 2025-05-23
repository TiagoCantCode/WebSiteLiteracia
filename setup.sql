CREATE DATABASE IF NOT EXISTS health_qa DEFAULT CHARACTER SET utf8 COLLATE=utf8_unicode_ci;
USE health_qa;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

create table types(
    id int(1) primary key auto_increment, 
    name_type varchar(13) not null
);

create table users(
    id int(5) primary key auto_increment,
    name varchar(50) null,
    email varchar(320) not null,
    password varchar(32) not null,
    idType int(1) not null,
    foreign key(idType) references types(id)
);

insert into types(name_type) values('administrador');
insert into types(name_type) values('utilizador');


create table questions(
    id int(2) primary key auto_increment,
    questionPT varchar(500) not null,
    questionEng varchar(500) not null, 
    answerPT varchar(500) not null,
    answerEng varchar(500) not null
);

