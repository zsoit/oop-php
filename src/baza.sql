drop database if exists pilkanozna;

create database pilkanozna;
use pilkanozna;

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
INSERT INTO `pilkarz` VALUES
(1,'Cristiano','Ronaldo',1.87,'1985-02-05','PRAWA',20,1,1,1,1),
(2,'Robert','Lewandowski',1.85,'1988-08-21','PRAWA',45,14,2,2,1),
(3,'Eric','García',1.82,'2001-01-09','PRAWA',18,0,1,3,2),
(4,'Andreaas','Christensen',1.87,'1996-04-10','PRAWA',30,3,4,4,2),
(5,'Ousmane','Dembélé',1.78,'1997-05-15','OBU-NOŻNY',60,4,5,1,3),
(6,'Kylian','Mbappé',1.78,'1998-12-20','PRAWA',180,13,5,1,1),
(7,'Presnel','Kimpembe',1.83,'1995-08-13','LEWA',40,0,5,5,2),
(8,'Gianluigi','Donnarumma',1.96,'1999-02-25','PRAWA',50,0,6,6,4),
(9,'Lionel','Messi',1.7,'1987-06-24','LEWA',50,9,8,8,3),
(10,'Neymar','Da Silva Santos Júnior',1.75,'1992-02-05','PRAWA',75,12,7,7,5),
(11,'Erling','Haaland',1.95,'2000-07-21','LEWA',170,25 ,9,2,1),
(12,'Stefan','Ortega',1.85,'1992-11-06','PRAWA',6,0,10,9,4),
(13,'Bernardo','Silva',1.73,'1994-08-10','LEWA',80,2,1,10,6),
(14,'Julián','Álvarez',1.7,'2000-01-31','PRAWA',50,4,8,11,1),
(15,'Nathan','Aké',1.8,'1995-02-18','LEWA',30,0,11,12,2),
(16,'Wesley','Fofana',1.86,'2000-12-17','PRAWA',65,0,5,13,2),
(17,'Enzo','Fernández',1.78,'2001-01-17','PRAWA',55,0,8,14,7),
(18,'Mykhaylo','Mudryk',1.75,'2001-01-05','PRAWA',40,0,12,4,5),
(19,'Conor','Gallagher',1.82,'2000-02-06','PRAWA',32,1,13,15,7),
(20,'Armando','Broja',1.91,'2001-09-10','PRAWA',30,1,13,9,1);

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


-- alter table pilkarz
-- add constraint fk_kraj
-- foreign key (fk_kraj)
-- references krajpilkarza (pk_kraj);

-- alter table pilkarz
-- add constraint fk_numernakoszulce
-- foreign key (fk_numernakoszulce)
-- references numernakoszulce (pk_numernakoszulce);

-- alter table pilkarz
-- add constraint fk_pozycja
-- foreign key (fk_pozycja)
-- references Pozycja (pk_pozycja);

-- alter table druzyna
-- add constraint fk_stadion
-- foreign key (fk_stadion)
-- references stadion (pk_stadion);

-- alter table druzyna
-- add constraint fk_krajdruzyny
-- foreign key (fk_krajdruzyny)
-- references krajdruzyny (pk_krajdruzyny);

-- alter table pilkarzdruzyna
-- add constraint fk_pilkarz
-- foreign key (fk_pilkarz)
-- references pilkarz (pk_pilkarz);

-- alter table pilkarzdruzyna
-- add constraint fk_druzyna
-- foreign key (fk_druzyna)
-- references druzyna (pk_druzyna);