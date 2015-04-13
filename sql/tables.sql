drop table contacts;

CREATE TABLE `db_ramco`.`contacts` (
  `guid` VARCHAR(50) NOT NULL,
  `nrds` VARCHAR(50) NULL,
  `first_name` VARCHAR(50) NULL,
  `last_name` VARCHAR(50) NULL,
  PRIMARY KEY (`guid`),
  UNIQUE INDEX `guid_UNIQUE` (`guid` ASC));