SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `eshop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `eshop` ;

-- -----------------------------------------------------
-- Table `eshop`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eshop`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `mask` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eshop`.`sell_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eshop`.`sell_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `category` VARCHAR(45) NULL,
  `brand` VARCHAR(45) NULL,
  `price` VARCHAR(45) NULL,
  `phone_no` VARCHAR(45) NULL,
  `location` VARCHAR(45) NULL,
  `user_id` INT NULL,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  PRIMARY KEY (`id`),
  INDEX `fk_sell_items_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_sell_items_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eshop`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eshop`.`buy_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eshop`.`buy_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `category` VARCHAR(45) NULL,
  `brand` VARCHAR(45) NULL,
  `price` VARCHAR(45) NULL,
  `phone_no` VARCHAR(45) NULL,
  `location` VARCHAR(45) NULL,
  `user_id` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_buy_items_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_buy_items_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eshop`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
