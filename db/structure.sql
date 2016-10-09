SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `user_roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_roles` (
  `role_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `role_name` VARCHAR(100) NULL DEFAULT NULL ,
  PRIMARY KEY (`role_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_name` VARCHAR(100) NULL DEFAULT NULL ,
  `user_full_name` VARCHAR(255) NULL DEFAULT NULL ,
  `user_password` VARCHAR(45) NULL DEFAULT NULL ,
  `user_email` VARCHAR(45) NULL DEFAULT NULL ,
  `user_pob` VARCHAR(100) NULL ,
  `user_dob` DATE NULL ,
  `user_role_role_id` INT(11) NULL ,
  `user_is_deleted` TINYINT(1) NULL DEFAULT 0 ,
  `user_input_date` TIMESTAMP NULL DEFAULT NULL ,
  `user_last_update` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`user_id`) ,
  INDEX `fk_user_user_role1_idx` (`user_role_role_id` ASC) ,
  CONSTRAINT `fk_user_user_role1`
    FOREIGN KEY (`user_role_role_id` )
    REFERENCES `user_roles` (`role_id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `logs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `logs` (
  `log_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `log_date` TIMESTAMP NULL DEFAULT NULL ,
  `log_action` VARCHAR(45) NULL DEFAULT NULL ,
  `log_module` VARCHAR(45) NULL DEFAULT NULL ,
  `log_info` TEXT NULL DEFAULT NULL ,
  `user_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`log_id`) ,
  INDEX `fk_g_activity_log_g_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_g_activity_log_g_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `ci_session`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ci_session` (
  `id` VARCHAR(40) NOT NULL ,
  `ip_address` VARCHAR(45) NOT NULL ,
  `timestamp` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `data` BLOB NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `ci_sessions_timestamp` (`timestamp` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `instances`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `instances` (
  `instance_id` INT NOT NULL AUTO_INCREMENT ,
  `instance_name` VARCHAR(255) NULL ,
  `instance_email` VARCHAR(45) NULL ,
  `instance_address` TEXT NULL ,
  `instance_phone` VARCHAR(45) NULL ,
  `instance_input_date` TIMESTAMP NULL ,
  `instance_last_update` TIMESTAMP NULL ,
  `users_user_id` INT(11) NULL ,
  PRIMARY KEY (`instance_id`) ,
  INDEX `fk_institusi_users1_idx` (`users_user_id` ASC) ,
  CONSTRAINT `fk_institusi_users1`
    FOREIGN KEY (`users_user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `channels`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `channels` (
  `channel_id` INT NOT NULL AUTO_INCREMENT ,
  `channel_name` VARCHAR(255) NULL ,
  PRIMARY KEY (`channel_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `violations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `violations` (
  `violation_id` INT NOT NULL AUTO_INCREMENT ,
  `violation_title` VARCHAR(255) NULL ,
  `violation_input_date` TIMESTAMP NULL ,
  `violation_last_update` TIMESTAMP NULL ,
  `users_user_id` INT(11) NULL ,
  PRIMARY KEY (`violation_id`) ,
  INDEX `fk_violations_users1_idx` (`users_user_id` ASC) ,
  CONSTRAINT `fk_violations_users1`
    FOREIGN KEY (`users_user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `activities`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `activities` (
  `activity_id` INT NOT NULL AUTO_INCREMENT ,
  `activity_title` VARCHAR(255) NULL ,
  `activity_input_date` TIMESTAMP NULL ,
  `activity_last_update` TIMESTAMP NULL ,
  `users_user_id` INT(11) NULL ,
  PRIMARY KEY (`activity_id`) ,
  INDEX `fk_activities_users1_idx` (`users_user_id` ASC) ,
  CONSTRAINT `fk_activities_users1`
    FOREIGN KEY (`users_user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cases`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cases` (
  `case_id` INT NOT NULL AUTO_INCREMENT ,
  `case_address` TEXT NULL ,
  `case_region` ENUM('Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Timur', 'Jakarta Barat', 'Jakarta Utara') NULL ,
  `channels_channel_id` INT NULL ,
  `case_date` DATE NULL ,
  `sanksi_type` ENUM('Teguran Tertulis', 'Paksaan Pemerintah') NULL ,
  `case_input_date` TIMESTAMP NULL ,
  `case_last_update` TIMESTAMP NULL ,
  `users_user_id` INT(11) NULL ,
  `activities_activity_id` INT NULL ,
  `instances_instance_id` INT NULL ,
  `stage_id` INT NULL ,
  PRIMARY KEY (`case_id`) ,
  INDEX `fk_cases_channels1_idx` (`channels_channel_id` ASC) ,
  INDEX `fk_cases_users1_idx` (`users_user_id` ASC) ,
  INDEX `fk_cases_activities1_idx` (`activities_activity_id` ASC) ,
  INDEX `fk_cases_instances1_idx` (`instances_instance_id` ASC) ,
  CONSTRAINT `fk_cases_channels1`
    FOREIGN KEY (`channels_channel_id` )
    REFERENCES `channels` (`channel_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cases_users1`
    FOREIGN KEY (`users_user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cases_activities1`
    FOREIGN KEY (`activities_activity_id` )
    REFERENCES `activities` (`activity_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cases_instances1`
    FOREIGN KEY (`instances_instance_id` )
    REFERENCES `instances` (`instance_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cases_has_violations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cases_has_violations` (
  `cases_has_violations_id` INT NOT NULL AUTO_INCREMENT ,
  `cases_case_id` INT NULL ,
  `violations_violation_id` INT NULL ,
  PRIMARY KEY (`cases_has_violations_id`) ,
  INDEX `fk_cases_has_violations_violations1_idx` (`violations_violation_id` ASC) ,
  INDEX `fk_cases_has_violations_cases1_idx` (`cases_case_id` ASC) ,
  CONSTRAINT `fk_cases_has_violations_cases1`
    FOREIGN KEY (`cases_case_id` )
    REFERENCES `cases` (`case_id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL,
  CONSTRAINT `fk_cases_has_violations_violations1`
    FOREIGN KEY (`violations_violation_id` )
    REFERENCES `violations` (`violation_id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cases_disposisi`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cases_disposisi` (
  `cases_disposisi_id` INT NOT NULL AUTO_INCREMENT ,
  `cases_case_id` INT NULL ,
  `from_role_id` INT(11) NULL ,
  `to_role_id` INT(11) NULL ,
  `cases_disposisi_input_date` TIMESTAMP NULL ,
  `cases_disposisi_last_update` TIMESTAMP NULL ,
  `users_user_id` INT(11) NULL ,
  PRIMARY KEY (`cases_disposisi_id`) ,
  INDEX `fk_cases_disposisi_cases1_idx` (`cases_case_id` ASC) ,
  INDEX `fk_cases_disposisi_user_roles1_idx` (`from_role_id` ASC) ,
  INDEX `fk_cases_disposisi_user_roles2_idx` (`to_role_id` ASC) ,
  INDEX `fk_cases_disposisi_users1_idx` (`users_user_id` ASC) ,
  CONSTRAINT `fk_cases_disposisi_cases1`
    FOREIGN KEY (`cases_case_id` )
    REFERENCES `cases` (`case_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cases_disposisi_user_roles1`
    FOREIGN KEY (`from_role_id` )
    REFERENCES `user_roles` (`role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cases_disposisi_user_roles2`
    FOREIGN KEY (`to_role_id` )
    REFERENCES `user_roles` (`role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cases_disposisi_users1`
    FOREIGN KEY (`users_user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
