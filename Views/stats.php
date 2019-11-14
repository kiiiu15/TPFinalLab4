<?php

?>

<form action="<?= FRONT_ROOT . "/Buy/getTotalByDate" ?>" method="post">
    <h5>check totals by date / cinema / movie</h5>

    <label>fecha desde</label>
    <input type="date" required name="fromDate">
    <label>fecha hasta</label>
    <input type="date" required name="toDate">
    <label>Cinemas</label>
    <select name="cinema">
        <option value="">Any</option>
    <?php 
    foreach ($cinemaList as $cinema) {
    ?>    
        <option value="<?= $cinema->getIdCinema() ?>"><?= $cinema->getName() ?></option>
    <?php
    }
    ?>
    </select>
    <label>Movies</label>
    <select name="movie">
        <option value="">Any</option>
    <?php 
        foreach ($movieList as $movie) {
    ?>
        <option value="<?=$movie->getId();?>"><?=$movie->getTitle();?></option>
    <?php
        }
    ?>
    </select>

<button type="submit">Get Total</button>
</form>


<form action="<?= FRONT_ROOT . "/Buy/getTotalByDate" ?>" method="post">
    <h5>check total of tickets by date / cinema / movie</h5>

    <label>fecha desde</label>
    <input type="date" required name="fromDate">
    <label>fecha hasta</label>
    <input type="date" required name="toDate">
    <label>Cinemas</label>
    <select name="cinema">
        <option value="">Any</option>
    <?php 
    foreach ($cinemaList as $cinema) {
    ?>    
        <option value="<?= $cinema->getIdCinema() ?>"><?= $cinema->getName() ?></option>
    <?php
    }
    ?>
    </select>
    <label>Movies</label>
    <select name="movie">
        <option value="">Any</option>
    <?php 
        foreach ($movieList as $movie) {
    ?>
        <option value="<?=$movie->getId();?>"><?=$movie->getTitle();?></option>
    <?php
        }
    ?>
    </select>

<button type="submit">Get Total</button>
</form>



<!-- 


CREATE DATABASE MoviePass2;

use MoviePass2

CREATE TABLE Cinemas(
	idCinema SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	nameCinema VARCHAR(50) NOT NULL,
	adressCinema VARCHAR(100) NOT NULL,
	capacity INT NOT NULL DEFAULT 1,
	price FLOAT NOT NULL DEFAULT 1,
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
    idBuy int not null auto_increment,
    idMovieFunction int not null,
    date DATE NOT NULL,
    numberOfTickets SMALLINT DEFAULT 1,
    total SMALLINT not null,
    discount float not null,
		emailUser VARCHAR(40) not null,
    state boolean not null,

    CONSTRAINT pk_Buy PRIMARY key (idBuy),
    CONSTRAINT fk_MovieFunction FOREIGN KEY (idMovieFunction) REFERENCES MovieFunctions (idFunction),
    CONSTRAINT fk_User FOREIGN KEY (emailUser) REFERENCES Users (email)
);

INSERT INTO Buy (idMovieFunction,date,numberOfTickets,total,discount,emailUser,state)
VALUES (1,CURTIME(),2,100,true,"manu",true);


INSERT INTO Buy (idMovieFunction,date,numberOfTickets,total,discount,emailUser,state)
VALUES (1,DATE("2017-06-15"),2,100,true,"manu",true);


SELECT * FROM Buy Where Buy.state = false AND Buy.emailUser = "manu";


SELECT *
FROM
	CreditCards AS CC
INNER JOIN
 	CreditCardPerUser AS CCPU
ON CC.number = CCPU.CreditCardNumber
WHERE CCPU.emailUser = "manu";

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


 -->