-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `ee_courtsync` DEFAULT CHARACTER SET utf8 ;
USE `ee_courtsync` ;

CREATE TABLE IF NOT EXISTS `ee_courtsync`.`utilisateurs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NOT NULL,
  `courriel` VARCHAR(100) NOT NULL,
  `mot_de_passe` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `courriel_UNIQUE` (`courriel` ASC) VISIBLE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `ee_courtsync`.`terrains` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `adresse` VARCHAR(255) NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `ee_courtsync`.`matchs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date_heure` DATETIME NULL,
  `terrains_id` INT NOT NULL,
  `utilisateurs_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_matchs_terrains_idx` (`terrains_id` ASC) VISIBLE,
  INDEX `fk_matchs_utilisateurs1_idx` (`utilisateurs_id` ASC) VISIBLE,
  CONSTRAINT `fk_matchs_terrains`
    FOREIGN KEY (`terrains_id`)
    REFERENCES `ee_courtsync`.`terrains` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matchs_utilisateurs1`
    FOREIGN KEY (`utilisateurs_id`)
    REFERENCES `ee_courtsync`.`utilisateurs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `ee_courtsync`.`recits` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `contenu` TEXT NULL,
  `utilisateurs_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_recits_utilisateurs1_idx` (`utilisateurs_id` ASC) VISIBLE,
  CONSTRAINT `fk_recits_utilisateurs1`
    FOREIGN KEY (`utilisateurs_id`)
    REFERENCES `ee_courtsync`.`utilisateurs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `ee_courtsync`.`participants` (
  `utilisateurs_id` INT NOT NULL,
  `matchs_id` INT NOT NULL,
  PRIMARY KEY (`utilisateurs_id`, `matchs_id`),
  INDEX `fk_utilisateurs_has_matchs_matchs1_idx` (`matchs_id` ASC) VISIBLE,
  INDEX `fk_utilisateurs_has_matchs_utilisateurs1_idx` (`utilisateurs_id` ASC) VISIBLE,
  CONSTRAINT `fk_utilisateurs_has_matchs_utilisateurs1`
    FOREIGN KEY (`utilisateurs_id`)
    REFERENCES `ee_courtsync`.`utilisateurs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_utilisateurs_has_matchs_matchs1`
    FOREIGN KEY (`matchs_id`)
    REFERENCES `ee_courtsync`.`matchs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;