CREATE DATABASE MoviePass;

use MoviePass

CREATE TABLE Cinemas(
	idCinema SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	nameCinema VARCHAR(50) NOT NULL,
	adressCinema VARCHAR(100) NOT NULL,
	active BOOLEAN NOT NULL DEFAULT true,
	CONSTRAINT pk_table_cinemas PRIMARY KEY (idCinema ASC)
);

CREATE TABLE Genres(
	idGenre SMALLINT UNSIGNED NOT NULL,
	nameGenre VARCHAR(100) NOT NULL DEFAULT 'No Name' UNIQUE,
	CONSTRAINT `pk_table_genre` PRIMARY KEY (`idGenre` ASC)
);

CREATE TABLE GenresPerMovie(
	idMovie INT UNSIGNED NOT NULL,
	idGenre SMALLINT UNSIGNED NOT NULL,
	CONSTRAINT pk_table_genres_per_movie PRIMARY KEY (idMovie ASC, idGenre ASC),
	CONSTRAINT `fk_table_GenresPerMovie_ table_Genre` 	FOREIGN KEY (`idGenre`) REFERENCES `Genres` (`idGenre`) ON DELETE Restrict ON UPDATE Cascade,
	CONSTRAINT `fk_table_GenresPerMovie_table_Movies` FOREIGN KEY (`idMovie`) REFERENCES `Movies` (`idMovie`) ON DELETE Restrict ON UPDATE Cascade
);

CREATE TABLE Movies(
	`tittle` VARCHAR(50) NOT NULL DEFAULT 'No tittle',
	`language` VARCHAR(10) NOT NULL,
	`overview` VARCHAR(5000) NOT NULL DEFAULT 'No overview',
	`releaseDate` DATE NOT NULL,
	`poster` VARCHAR(50) NOT NULL,
	`idMovie` INT UNSIGNED NOT NULL,
	CONSTRAINT `pk_table_movies` PRIMARY KEY (`idMovie` ASC)
);

CREATE TABLE Rooms(
	id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL DEFAULT 'Sin nombre',
	price FLOAT NOT NULL,
	capacity INT NOT NULL,
	idCinema SMALLINT UNSIGNED NOT NULL,
	CONSTRAINT pk_table_rooms PRIMARY KEY (id ASC),
	CONSTRAINT `fk_table_rooms_table_cinemas` 	FOREIGN KEY (`idCinema`) REFERENCES `Cinemas` (`idCinema`) ON DELETE Restrict ON UPDATE Cascade
);


CREATE TABLE MovieFunctions(
	`idFunction` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`date` DATE NOT NULL,
	`hour` TIME NOT NULL,
	`idRoom` SMALLINT UNSIGNED NOT NULL,
	`idMovie` INT UNSIGNED NOT NULL,
	CONSTRAINT `pk_table_MovieFunctions` PRIMARY KEY (`idFunction` ASC),
	CONSTRAINT `fk_table_movieFunction_rooms` FOREIGN KEY (`idRoom`) REFERENCES `Rooms` (`id`) ON DELETE Restrict ON UPDATE Cascade,
	CONSTRAINT fk_Movies FOREIGN KEY (idMovie) REFERENCES Movies (idMovie)
);

create table Roles(
	roleName varchar(30),
    constraint pk_roles primary key(roleName)
);

create table UserProfiles(
		idProfile int not null auto_increment,
    UserName varchar(30),
    UserlastName varchar(30),
    dni varchar(8) not null,
    telephoneNumber varchar(14) not null,
    constraint pk_userProfiles primary key(idProfile)
);

create table Users(
    email varchar(40) unique,
    pass varchar(30),
    roleName varchar(30),
    usersProfileId int,
    constraint pk_users primary key(email),
    constraint fk_users_role foreign key(roleName) references Roles(roleName),
    constraint fk_users_profile foreign key(usersProfileId) references UserProfiles(idProfile)
);

CREATE TABLE Buy (
    idBuy varchar(14) not null,
    idMovieFunction int not null,
    buyDate DATE NOT NULL,
    numberOfTickets SMALLINT DEFAULT 1,
    total SMALLINT not null,
    discount float not null,
		emailUser VARCHAR(40) not null,
    buyState boolean not null,

    CONSTRAINT pk_Buy PRIMARY key (idBuy),
    CONSTRAINT fk_MovieFunction FOREIGN KEY (idMovieFunction) REFERENCES MovieFunctions (idFunction),
    CONSTRAINT fk_User FOREIGN KEY (emailUser) REFERENCES Users (email)
);

CREATE TABLE CreditCards(
	company varchar(40),
	`number` varchar(16) not null UNIQUE,
	securityCode varchar(3) not null,
	expiryMonth varchar(2),
	expiryYear varchar(2),

	CONSTRAINT pk_creditcards PRIMARY KEY (`number`)
);

CREATE TABLE CreditCardPerUser(
	emailUser varchar(40),
	CreditCardNumber varchar(16),
	CONSTRAINT pk_CreditCardPerUser PRIMARY KEY (emailUser ASC, CreditCardNumber ASC),
	CONSTRAINT fk_Users FOREIGN KEY (emailUser) REFERENCES Users (email),
	CONSTRAINT fk_CreditCards FOREIGN KEY (CreditCardNumber) REFERENCES CreditCards (`number`)
);

INSERT INTO UserProfiles (UserName,UserlastName,dni,telephoneNumber) VALUES ("manu","last","123","321");
INSERT INTO Users (email,pass,roleName,usersProfileId) VALUES ("manu","123","admin",1);

INSERT INTO CreditCards (company,`number`,securityCode,expiryMonth,expiryYear) VALUES ("Visa","6583458042570138","123","02","19");
INSERT INTO CreditCards (company,`number`,securityCode,expiryMonth,expiryYear) VALUES ("Visa","4444444444444444","123","02","19");
INSERT INTO CreditCardPerUser (emailUser,CreditCardNumber) VALUES ("manu","6583458042570138");
INSERT INTO CreditCardPerUser (emailUser,CreditCardNumber) VALUES ("manu","4444444444444444");

INSERT INTO Cinemas (nameCinema,adressCinema,active) VALUES ("aldrey","adres1",true);
INSERT INTO Cinemas (nameCinema,adressCinema,active) VALUES ("cine2","adres2",true);

INSERT INTO Rooms(name,price,capacity,idCinema) VALUES("room1Aldrey",50,150,1);
INSERT INTO Rooms(name,price,capacity,idCinema) VALUES("room2Aldrey",60,200,1);
INSERT INTO Rooms(name,price,capacity,idCinema) VALUES("room1Cine2",40,300,2);
INSERT INTO Rooms(name,price,capacity,idCinema) VALUES("room2Cine2",30,30,2);

INSERT INTO MovieFunctions(date,hour,idRoom,idMovie) VALUES (curdate(),CURTIME(),1,475557);
