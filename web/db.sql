CREATE TABLE `workers` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`first_name` VARCHAR(40) NOT NULL,
	`last_name` VARCHAR(50) NOT NULL,
	`token` VARCHAR(8) NOT NULL,
	`is_active` BOOLEAN NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
);


CREATE TABLE `logs` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`id_user` INT NOT NULL,
	`date` DATETIME NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE `tokens` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`token` VARCHAR(8) NOT NULL UNIQUE,
	`date` DATETIME NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO workers values(null, "Konrad", "Olszewski", "QWEQWE12", 1);
INSERT INTO workers values(null, "Olszewski", "Konrad", "ASDASD12", 1);
INSERT INTO workers values(null, "Konrad2", "Olszewski2", "WERWER12", 0);

INSERT INTO logs values(null, 1, now());
INSERT INTO logs values(null, 2, now());
INSERT INTO logs values(null, 1, now());
INSERT INTO logs values(null, 2, now());