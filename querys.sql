/* ---------------------------------------------------- */
/*  Generated by Enterprise Architect Version 13.5 		*/
/*  Created On : 04-Nov-2019 7:21:38 PM 				*/
/*  DBMS       : MySql 						*/
/* ---------------------------------------------------- */


CREATE DATABASE moviepass;
USE moviepass;
SET FOREIGN_KEY_CHECKS=0 
;

/* Drop Tables */
DROP TABLE IF EXISTS `MovieFunctions` CASCADE
;

DROP TABLE IF EXISTS `Rooms` CASCADE
;


DROP TABLE IF EXISTS `GenresPerMovie` CASCADE
;

DROP TABLE IF EXISTS `Cinemas` CASCADE
;

DROP TABLE IF EXISTS `Movies` CASCADE
;


DROP TABLE IF EXISTS `Genres` CASCADE
;











/* Create Tables */

CREATE TABLE `Cinemas`
(
	`idCinema` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`nameCinema` VARCHAR(50) NOT NULL,
	`adressCinema` VARCHAR(100) NOT NULL,
	`capacity` INT NOT NULL DEFAULT 1,
	`price` FLOAT NOT NULL DEFAULT 1,
	`active` BOOL NOT NULL DEFAULT true,
	CONSTRAINT `pk_table_cinemas` PRIMARY KEY (`idCinema` ASC)
)

;

CREATE TABLE `Genres`
(
	`idGenre` SMALLINT UNSIGNED NOT NULL,
	`nameGenre` VARCHAR(100) NOT NULL DEFAULT 'No Name',
	CONSTRAINT `pk_table_genre` PRIMARY KEY (`idGenre` ASC)
)

;

CREATE TABLE `GenresPerMovie`
(
	`idMovie` INT UNSIGNED NOT NULL,
	`idGenre` SMALLINT UNSIGNED NOT NULL,
	CONSTRAINT `pk_table_genres_per_movie` PRIMARY KEY (`idMovie` ASC, `idGenre` ASC)
)

;

CREATE TABLE `MovieFunctions`
(
	`idMovie` INT UNSIGNED NOT NULL,
	`date` DATE NOT NULL,
	`hour` TIME NOT NULL,
	`idFunction` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idRoom` SMALLINT UNSIGNED NOT NULL,
	CONSTRAINT `pk_table_MovieFunctions` PRIMARY KEY (`idFunction` ASC)
)

;

CREATE TABLE `Movies`
(
	`tittle` VARCHAR(50) NOT NULL DEFAULT 'No tittle',
	`language` VARCHAR(10) NOT NULL,
	`overview` VARCHAR(5000) NOT NULL DEFAULT 'No overview',
	`releaseDate` DATE NOT NULL,
	`poster` VARCHAR(50) NOT NULL,
	`idMovie` INT UNSIGNED NOT NULL,
	CONSTRAINT `pk_table_movies` PRIMARY KEY (`idMovie` ASC)
)

;

CREATE TABLE `Rooms`
(
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL DEFAULT 'Sin nombre',
	`price` FLOAT NOT NULL,
	`capacity` INT NOT NULL,
	`idCinema` SMALLINT UNSIGNED NOT NULL,
	CONSTRAINT `pk_table_rooms` PRIMARY KEY (`id` ASC)
)

;

/* Create Primary Keys, Indexes, Uniques, Checks */

ALTER TABLE `Genres` 
 ADD CONSTRAINT `unique_nameGenre_table_genre` UNIQUE (`nameGenre` ASC)
;

/* Create Foreign Key Constraints */

ALTER TABLE `GenresPerMovie` 
 ADD CONSTRAINT `fk_table_GenresPerMovie_ table_Genre`
	FOREIGN KEY (`idGenre`) REFERENCES `Genres` (`idGenre`) ON DELETE Restrict ON UPDATE Cascade
;

ALTER TABLE `GenresPerMovie` 
 ADD CONSTRAINT `fk_table_GenresPerMovie_table_Movies`
	FOREIGN KEY (`idMovie`) REFERENCES `Movies` (`idMovie`) ON DELETE Restrict ON UPDATE Cascade
;

ALTER TABLE `MovieFunctions` 
 ADD CONSTRAINT `fk_table_movieFunction_rooms`
	FOREIGN KEY (`idRoom`) REFERENCES `Rooms` (`id`) ON DELETE Restrict ON UPDATE Cascade
;

ALTER TABLE `MovieFunctions` 
 ADD CONSTRAINT `fk_table_MovieFunctions_table_Movies`
	FOREIGN KEY (`idMovie`) REFERENCES `Movies` (`idMovie`) ON DELETE Restrict ON UPDATE Cascade
;

ALTER TABLE `Rooms` 
 ADD CONSTRAINT `fk_table_rooms_table_cinemas`
	FOREIGN KEY (`idCinema`) REFERENCES `Cinemas` (`idCinema`) ON DELETE Restrict ON UPDATE Cascade
;

SET FOREIGN_KEY_CHECKS=1 
;
