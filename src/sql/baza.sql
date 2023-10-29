-- drop database if exists pilkanozna;

-- create database pilkanozna;
-- use pilkanozna;

create table pilkarz (
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

CREATE TABLE `awatar` (
  `pk_awatar` int NOT NULL,
  `link` varchar(200) NOT NULL,
  `fk_pilkarz` int NOT NULL
)

create table druzyna (
	pk_druzyna int primary key auto_increment,
	nazwa varchar(55) not null unique,
	wygrane_mecze int not null,
	wartosc_druzyny int not null,
	data_zalozenia date not null,
	fk_stadion int not null,
	fk_krajdruzyny int not null
);
create table krajdruzyny (
	pk_krajdruzyny int primary key auto_increment,
	nazwa varchar(60) not null unique
);
create table krajpilkarza (
	pk_kraj int primary key auto_increment,
	nazwa varchar(60) not null unique
);
create table numernakoszulce (
	pk_numernakoszulce int primary key auto_increment,
	numer int not null unique
);
create table pozycja (
	pk_pozycja int primary key auto_increment,
	nazwa varchar(30) not null unique
);
create table stadion (
	pk_stadion int primary key auto_increment,
	nazwa varchar(60) not null unique,
	czy_zadaszony enum('TAK', 'NIE'),
	ilosc_miejsc_siedzacych int not null
);


INSERT INTO `stadion` VALUES (1,'Mrsool Park','TAK',25000),(2,'Spotify Camp Nou','TAK',99354),(3,'	Parc des Princes','TAK',48712),(4,'Etihad Stadium','TAK',55017),(5,'Stamford Bridge','TAK',40853);
INSERT INTO `pozycja` VALUES (1,'Środkowy napastnik'),(2,'Środkowy obrońca'),(3,'Prawy napastnik'),(4,'Bramkarz'),(5,'Lewy napastnik'),(6,'Ofensywny pomocnik'),(7,'Środkowy pomocnik');
INSERT INTO `numernakoszulce` VALUES (1,7),(2,9),(3,24),(4,15),(5,3),(6,99),(7,10),(8,30),(9,18),(10,20),(11,19),(12,6),(13,33),(14,5),(15,23);
INSERT INTO `krajdruzyny` VALUES (1,'Arabia Saudyjska'),(2,'Hiszpania'),(3,'Polska'),(4,'Francja'),(5,'Anglia'),(6,'Holandia');
INSERT INTO `krajpilkarza` VALUES (1,'Portugalia'),(2,'Polska'),(3,'Hiszpania'),(4,'Dania'),(5,'Francja'),(6,'Włochy'),(7,'Brazylia'),(8,'Argentyna'),(9,'Norwegia'),(10,'Niemcy'),(11,'Holandia'),(12,'Ukraina'),(13,'Anglia');

INSERT INTO `druzyna` VALUES (1,'Al-Nassr FC',14,81,'1955-10-24',1,1),
(2,'FC Barcelona',18,762,'1899-11-29',2,2),
(3,'FC Paris Saint-Germain',21,889,'1970-08-12',3,4),
(4,'Manchester City',20,1050,'1880-11-23',4,5),
(5,'Chelsea FC',20,1040,'1905-03-10',5,5);

create table pilkarzdruzyna (
	fk_pilkarz int,
	fk_druzyna int,
	primary key (fk_pilkarz, fk_druzyna)
);


INSERT INTO `pilkarzdruzyna` VALUES (1,1),(2,2),(3,2),(4,2),(5,2),(6,3),(7,3),(8,3),(9,3),(10,3),(11,4),(12,4),(13,4),(14,4),(15,4),(16,5),(17,5),(18,5),(19,5),(20,5);

