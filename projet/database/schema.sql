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

CREATE TABLE IF NOT EXISTS `ee_courtsync`.`terrain` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `adresse` VARCHAR(255) NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `ee_courtsync`.`matchs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date_heure` DATETIME NULL,
  `terrain_id` INT NOT NULL,
  `utilisateur_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_matchs_terrains_idx` (`terrain_id` ASC) VISIBLE,
  INDEX `fk_matchs_utilisateurs1_idx` (`utilisateur_id` ASC) VISIBLE,
  CONSTRAINT `fk_matchs_terrains`
    FOREIGN KEY (`terrain_id`)
    REFERENCES `ee_courtsync`.`terrain` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matchs_utilisateurs1`
    FOREIGN KEY (`utilisateur_id`)
    REFERENCES `ee_courtsync`.`utilisateurs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `ee_courtsync`.`recits` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `contenu` TEXT NULL,
  `utilisateur_id` INT NOT NULL,
  `terrain_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_recits_utilisateurs1_idx` (`utilisateur_id` ASC) VISIBLE,
  INDEX `fk_recits_terrains1_idx` (`terrain_id` ASC) VISIBLE,
  CONSTRAINT `fk_recits_utilisateurs1`
    FOREIGN KEY (`utilisateur_id`)
    REFERENCES `ee_courtsync`.`utilisateurs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recits_terrains1`
    FOREIGN KEY (`terrain_id`)
    REFERENCES `ee_courtsync`.`terrain` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;