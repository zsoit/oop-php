-- drop database if exists pilkanozna;

-- create database pilkanozna;
-- use pilkanozna;

CREATE TABLE pilkarz (
	pk_pilkarz int primary key auto_increment,
	imie varchar(30) not null,
	nazwisko varchar(30) not null,
	wzrost float not null,
	data_urodzenia date not null,
	wiodaca_noga enum('LEWA', 'PRAWA', 'OBU-NOŻNY'),
	wartosc_rynkowa int not null,
	ilosc_strzelonych_goli int not null,
	fk_kraj int not null,
	fk_numernakoszulce int not null,
	fk_pozycja int not null
);

CREATE TABLE awatar (
  pk_awatar int NOT NULL,
  link varchar(200) NOT NULL,
  fk_pilkarz int NOT NULL
)

CREATE TABLE krajpilkarza (
	pk_kraj int primary key auto_increment,
	nazwa varchar(60) not null unique
);
CREATE TABLE numernakoszulce (
	pk_numernakoszulce int primary key auto_increment,
	numer int not null unique
);
CREATE TABLE pozycja (
	pk_pozycja int primary key auto_increment,
	nazwa varchar(30) not null unique
);


INSERT INTO `pozycja` VALUES (1,'Środkowy napastnik'),(2,'Środkowy obrońca'),(3,'Prawy napastnik'),(4,'Bramkarz'),(5,'Lewy napastnik'),(6,'Ofensywny pomocnik'),(7,'Środkowy pomocnik');
INSERT INTO `numernakoszulce` VALUES (1,7),(2,9),(3,24),(4,15),(5,3),(6,99),(7,10),(8,30),(9,18),(10,20),(11,19),(12,6),(13,33),(14,5),(15,23);
INSERT INTO `krajpilkarza` VALUES (1,'Portugalia'),(2,'Polska'),(3,'Hiszpania'),(4,'Dania'),(5,'Francja'),(6,'Włochy'),(7,'Brazylia'),(8,'Argentyna'),(9,'Norwegia'),(10,'Niemcy'),(11,'Holandia'),(12,'Ukraina'),(13,'Anglia');




