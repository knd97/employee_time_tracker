ALTER DATABASE `wbudowane` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

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
	`id_worker` INT NOT NULL,
	`date_start` DATETIME NOT NULL,
	`date_end` DATETIME,
	`is_finished` BOOLEAN NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
);

CREATE TABLE `tokens` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`token` VARCHAR(8) NOT NULL UNIQUE,
	`date` DATETIME NOT NULL,
	`is_active` BOOLEAN NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
);

INSERT INTO workers values(null, "Konrad", "Olszewski", "QWEQWE12", 1);
INSERT INTO workers values(null, "Olszewski", "Konrad", "ASDASD12", 1);
INSERT INTO workers values(null, "Konrad2", "Olszewski2", "WERWER12", 0);

INSERT INTO logs values(null, 1, now(), DATE_ADD(now(),INTERVAL 8 HOUR), 1);
INSERT INTO logs values(null, 3, now(), DATE_ADD(now(),INTERVAL 8 HOUR), 1);
INSERT INTO logs values(null, 2, now(), DATE_ADD(now(),INTERVAL 8 HOUR), 1);
