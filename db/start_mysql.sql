SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `login` VARCHAR(45) NOT NULL COMMENT 'Login used by user to connect on the website.' ,
  `password` VARCHAR(40) NOT NULL ,
  `nickname` VARCHAR(45) NOT NULL COMMENT 'Nickname under with the user appaer on the website' ,
  `firstname` VARCHAR(45) NULL ,
  `lastname` VARCHAR(45) NULL ,
  `bio` VARCHAR(420) NULL ,
  `image` BLOB NULL ,
  `creation` DATETIME NOT NULL ,
  `change` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `usr_id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `usr_login_UNIQUE` (`login` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'User of the ticket system.';


-- -----------------------------------------------------
-- Table `project`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `project` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `short` VARCHAR(255) NULL DEFAULT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `rcs` ENUM('svn', 'git', 'hg') NOT NULL ,
  `path` VARCHAR(45) NOT NULL COMMENT 'Path where source code are.' ,
  `acl` VARCHAR(3) NOT NULL COMMENT 'Like UNIX rules, except that seven is not used. First digit for project’s members, seconde digit for other project’s members and last for all other (visitors…)' ,
  `creation` DATETIME NOT NULL ,
  `change` DATETIME NULL DEFAULT NULL ,
  `slug` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `prj_id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'All project that must be tracked ! :)';


-- -----------------------------------------------------
-- Table `ticket`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ticket` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `project_id` INT NOT NULL ,
  `user_id` INT NULL DEFAULT NULL ,
  `milestone_id` INT NULL DEFAULT NULL ,
  `title` VARCHAR(256) NOT NULL ,
  `text` VARCHAR(45) NOT NULL ,
  `type` ENUM('defect', 'enhancement', 'task') NOT NULL DEFAULT 'defect' ,
  `status` ENUM('open','closed') NOT NULL DEFAULT 'open' ,
  `assignedto` INT NULL DEFAULT NULL ,
  `priority` ENUM('highest','high','normal','low', 'lowest') NOT NULL DEFAULT 'normal' ,
  `severity` ENUM('critical','major', 'normal', 'minor', 'trivial') NOT NULL DEFAULT 'normal' ,
  `creation` DATETIME NOT NULL ,
  `change` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `tck_id_UNIQUE` (`id` ASC) ,
  CONSTRAINT `fk_Ticket_Project`
    FOREIGN KEY (`project_id` )
    REFERENCES `project` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Ticket about issues, enhancements, UX and so on…';


-- -----------------------------------------------------
-- Table `tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tag` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `slug` VARCHAR(45) NOT NULL ,
  `belongsto` ENUM('User', 'Project', 'Ticket', 'Wiki') NOT NULL ,
  `attachedto` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `tag_id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Tag for projects, tickets, user…';


-- -----------------------------------------------------
-- Table `comment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `comment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `action` TEXT NULL DEFAULT NULL ,
  `text` TEXT NOT NULL ,
  `ticket_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `creation` DATETIME NOT NULL ,
  `change` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `cmt_id_UNIQUE` (`id` ASC) ,
  CONSTRAINT `fk_Comment_Ticket1`
    FOREIGN KEY (`ticket_id` )
    REFERENCES `ticket` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comment_User1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `wiki`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `wiki` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `text` TEXT NULL ,
  `slug` VARCHAR(45) NOT NULL ,
  `belongsto` ENUM('User', 'Project') NULL DEFAULT NULL ,
  `attachedto` INT NULL DEFAULT NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `wik_id_UNIQUE` (`id` ASC) ,
  CONSTRAINT `fk_Wiki_User1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Wiki can belongs to User (his own pages on his profil page) ' /* comment truncated */;


-- -----------------------------------------------------
-- Table `member`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `member` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `project_id` INT NOT NULL ,
  `creation` DATETIME NOT NULL ,
  `change` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `phu_id_UNIQUE` (`id` ASC) ,
  CONSTRAINT `fk_ProjectHasUser_Project1`
    FOREIGN KEY (`project_id` )
    REFERENCES `project` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProjectHasUser_User1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `milestone`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `milestone` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `project_id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `ttd` DATETIME NOT NULL ,
  `creation` DATETIME NOT NULL ,
  `change` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `mls_id_UNIQUE` (`id` ASC) ,
  CONSTRAINT `fk_Milestone_Project1`
    FOREIGN KEY (`project_id` )
    REFERENCES `project` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `role`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `role` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `member_id` INT NOT NULL ,
  `on` ENUM('Milestone', 'Ticket', 'Comment', 'ProjectHasUser', 'Role', 'Wiki', 'Tag') NOT NULL ,
  `create` TINYINT NOT NULL DEFAULT 1 ,
  `read` TINYINT NOT NULL DEFAULT 1 ,
  `update` TINYINT NOT NULL DEFAULT 1 ,
  `delete` TINYINT NOT NULL DEFAULT 0 ,
  `creation` DATETIME NOT NULL ,
  `change` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `rol_id_UNIQUE` (`id` ASC) ,
  CONSTRAINT `fk_Role_ProjectHasUser1`
    FOREIGN KEY (`member_id` )
    REFERENCES `member` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `email`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `email` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `address` VARCHAR(150) NOT NULL ,
  `creation` DATETIME NOT NULL ,
  `change` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `eml_id_UNIQUE` (`id` ASC) ,
  CONSTRAINT `fk_Email_User1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `carboncopy`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `carboncopy` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ticket_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_CarbonCopy_Ticket1`
    FOREIGN KEY (`ticket_id` )
    REFERENCES `ticket` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CarbonCopy_User1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
