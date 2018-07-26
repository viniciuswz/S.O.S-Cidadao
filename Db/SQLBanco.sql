-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema Reclama1
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Reclama1
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Reclama1` DEFAULT CHARACTER SET latin1 ;
USE `Reclama1` ;

-- -----------------------------------------------------
-- Table `Reclama1`.`Tipo_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Tipo_usuario` (
  `cod_tipo_usu` INT NOT NULL AUTO_INCREMENT,
  `descri_tipo_usu` VARCHAR(45) NOT NULL,
  `status_tipo_usu` CHAR(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_tipo_usu`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Usuario` (
  `cod_usu` INT NOT NULL AUTO_INCREMENT,
  `nome_usu` VARCHAR(60) NOT NULL,
  `email_usu` VARCHAR(60) NOT NULL,
  `senha_usu` VARCHAR(60) NOT NULL,
  `img_capa_usu` VARCHAR(100) NOT NULL,
  `img_perfil_usu` VARCHAR(100) NOT NULL,
  `status_usu` CHAR(1) NOT NULL DEFAULT 'A',
  `dataHora_cadastro_usu` DATETIME NOT NULL,
  `cod_tipo_usu` INT NOT NULL,
  PRIMARY KEY (`cod_usu`),
  INDEX `fk_Usuario_Tipo_usuario_idx` (`cod_tipo_usu` ASC),
  CONSTRAINT `fk_Usuario_Tipo_usuario`
    FOREIGN KEY (`cod_tipo_usu`)
    REFERENCES `Reclama1`.`Tipo_usuario` (`cod_tipo_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Debate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Debate` (
  `cod_deba` INT NOT NULL AUTO_INCREMENT,
  `img_deba` VARCHAR(100) NOT NULL,
  `nome_deba` VARCHAR(45) NOT NULL,
  `dataHora_deba` DATETIME NOT NULL,
  `status_deba` CHAR(1) NOT NULL DEFAULT 'A',
  `tema_deba` VARCHAR(100) NOT NULL,
  `descri_deba` LONGTEXT NOT NULL,
  `cod_usu` INT NOT NULL,
  PRIMARY KEY (`cod_deba`),
  INDEX `fk_Debate_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Debate_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Debate_Participante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Debate_Participante` (
  `cod_deba` INT NOT NULL,
  `cod_usu` INT NOT NULL,
  `data_inicio_lista` DATETIME NOT NULL,
  `data_fim_lista` DATETIME NULL,
  `ind_visu_criador` CHAR(1) NOT NULL DEFAULT 'N',
  `status_lista` CHAR(1) NOT NULL DEFAULT 'A',
  INDEX `fk_Participantes_debate_Debate1_idx` (`cod_deba` ASC),
  PRIMARY KEY (`cod_deba`, `cod_usu`, `data_inicio_lista`),
  INDEX `fk_Participantes_debate_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Participantes_debate_Debate1`
    FOREIGN KEY (`cod_deba`)
    REFERENCES `Reclama1`.`Debate` (`cod_deba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Participantes_debate_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Debate_Denun`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Debate_Denun` (
  `cod_denun_deba` INT NOT NULL AUTO_INCREMENT,
  `ind_visu_adm_denun_deba` CHAR(1) NOT NULL DEFAULT 'N',
  `status_denun_deba` CHAR(1) NOT NULL DEFAULT 'A',
  `motivo_denun_deba` LONGTEXT NOT NULL,
  `dataHora_denun_deba` DATETIME NOT NULL,
  `cod_usu` INT NOT NULL,
  `cod_deba` INT NOT NULL,
  PRIMARY KEY (`cod_denun_deba`),
  INDEX `fk_Denuncia_debate_Usuario1_idx` (`cod_usu` ASC),
  INDEX `fk_Denuncia_debate_Debate1_idx` (`cod_deba` ASC),
  CONSTRAINT `fk_Denuncia_debate_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Denuncia_debate_Debate1`
    FOREIGN KEY (`cod_deba`)
    REFERENCES `Reclama1`.`Debate` (`cod_deba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Mensagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Mensagem` (
  `cod_mensa` INT NOT NULL AUTO_INCREMENT,
  `texto_mensa` LONGTEXT NOT NULL,
  `status_mensa` CHAR(1) NOT NULL DEFAULT 'A',
  `dataHora_mensa` DATETIME NOT NULL,
  `cod_usu` INT NOT NULL,
  `cod_deba` INT NOT NULL,
  PRIMARY KEY (`cod_mensa`),
  INDEX `fk_Mensagem_Usuario1_idx` (`cod_usu` ASC),
  INDEX `fk_Mensagem_Debate1_idx` (`cod_deba` ASC),
  CONSTRAINT `fk_Mensagem_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mensagem_Debate1`
    FOREIGN KEY (`cod_deba`)
    REFERENCES `Reclama1`.`Debate` (`cod_deba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Mensagem_visualizacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Mensagem_visualizacao` (
  `cod_mensa` INT NOT NULL,
  `cod_usu` INT NOT NULL,
  PRIMARY KEY (`cod_mensa`, `cod_usu`),
  INDEX `fk_Mensagem_visualizacao_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Mensagem_visualizacao_Mensagem1`
    FOREIGN KEY (`cod_mensa`)
    REFERENCES `Reclama1`.`Mensagem` (`cod_mensa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mensagem_visualizacao_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Categoria` (
  `cod_cate` INT NOT NULL AUTO_INCREMENT,
  `descri_cate` VARCHAR(60) NOT NULL,
  `status_cate` CHAR(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_cate`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Bairro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Bairro` (
  `cod_bai` INT NOT NULL AUTO_INCREMENT,
  `nome_bai` VARCHAR(60) NOT NULL,
  `status_bai` CHAR(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_bai`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Logradouro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Logradouro` (
  `cep_logra` VARCHAR(8) NOT NULL,
  `endere_logra` VARCHAR(60) NOT NULL,
  `cod_bai` INT NOT NULL,
  INDEX `fk_Endereco_Bairro1_idx` (`cod_bai` ASC),
  PRIMARY KEY (`cep_logra`),
  CONSTRAINT `fk_Endereco_Bairro1`
    FOREIGN KEY (`cod_bai`)
    REFERENCES `Reclama1`.`Bairro` (`cod_bai`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Publicacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Publicacao` (
  `cod_publi` INT NOT NULL AUTO_INCREMENT,
  `status_publi` CHAR(1) NOT NULL DEFAULT 'A',
  `texto_publi` LONGTEXT NOT NULL,
  `img_publi` VARCHAR(100) NULL,
  `titulo_publi` VARCHAR(60) NOT NULL,
  `dataHora_publi` DATETIME NOT NULL,
  `cod_usu` INT NOT NULL,
  `cod_cate` INT NOT NULL,
  `cep_logra` VARCHAR(8) NOT NULL,
  PRIMARY KEY (`cod_publi`),
  INDEX `fk_Publicacao_Usuario1_idx` (`cod_usu` ASC),
  INDEX `fk_Publicacao_Categorias1_idx` (`cod_cate` ASC),
  INDEX `fk_Publicacao_Logradouro1_idx` (`cep_logra` ASC),
  CONSTRAINT `fk_Publicacao_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Publicacao_Categorias1`
    FOREIGN KEY (`cod_cate`)
    REFERENCES `Reclama1`.`Categoria` (`cod_cate`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Publicacao_Logradouro1`
    FOREIGN KEY (`cep_logra`)
    REFERENCES `Reclama1`.`Logradouro` (`cep_logra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Publicacao_salva`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Publicacao_salva` (
  `cod_usu` INT NOT NULL,
  `cod_publi` INT NOT NULL,
  `status_publi_sal` CHAR(1) NOT NULL DEFAULT 'A',
  `ind_visu_respos_prefei` CHAR(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`cod_usu`, `cod_publi`),
  INDEX `fk_Usuario_has_Publicacao_Publicacao1_idx` (`cod_publi` ASC),
  INDEX `fk_Usuario_has_Publicacao_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Usuario_has_Publicacao_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Publicacao_Publicacao1`
    FOREIGN KEY (`cod_publi`)
    REFERENCES `Reclama1`.`Publicacao` (`cod_publi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Publicacao_curtida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Publicacao_curtida` (
  `cod_usu` INT NOT NULL,
  `cod_publi` INT NOT NULL,
  `status_publi_curti` CHAR(1) NOT NULL DEFAULT 'A',
  `ind_visu_dono_publi` CHAR(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`cod_usu`, `cod_publi`),
  INDEX `fk_Usuario_has_Publicacao_Publicacao2_idx` (`cod_publi` ASC),
  INDEX `fk_Usuario_has_Publicacao_Usuario2_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Usuario_has_Publicacao_Usuario2`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Publicacao_Publicacao2`
    FOREIGN KEY (`cod_publi`)
    REFERENCES `Reclama1`.`Publicacao` (`cod_publi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Publi_Denun`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Publi_Denun` (
  `cod_denun_publi` INT NOT NULL AUTO_INCREMENT,
  `ind_visu_adm_denun_publi` CHAR(1) NOT NULL DEFAULT 'N',
  `motivo_denun_publi` LONGTEXT NOT NULL,
  `status_denun_publi` CHAR(1) NOT NULL DEFAULT 'A',
  `dataHora_denun_publi` DATETIME NOT NULL,
  `cod_usu` INT NOT NULL,
  `cod_publi` INT NOT NULL,
  INDEX `fk_Usuario_has_Publicacao_Publicacao3_idx` (`cod_publi` ASC),
  INDEX `fk_Usuario_has_Publicacao_Usuario3_idx` (`cod_usu` ASC),
  PRIMARY KEY (`cod_denun_publi`),
  CONSTRAINT `fk_Usuario_has_Publicacao_Usuario3`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Publicacao_Publicacao3`
    FOREIGN KEY (`cod_publi`)
    REFERENCES `Reclama1`.`Publicacao` (`cod_publi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Comentario` (
  `cod_comen` INT NOT NULL AUTO_INCREMENT,
  `texto_comen` LONGTEXT NOT NULL,
  `ind_visu_dono_publi` CHAR(1) NOT NULL DEFAULT 'N',
  `dataHora_comen` DATETIME NOT NULL,
  `status_comen` CHAR(1) NOT NULL DEFAULT 'A',
  `cod_usu` INT NOT NULL,
  `cod_publi` INT NOT NULL,
  PRIMARY KEY (`cod_comen`),
  INDEX `fk_Comentario_Usuario1_idx` (`cod_usu` ASC),
  INDEX `fk_Comentario_Publicacao1_idx` (`cod_publi` ASC),
  CONSTRAINT `fk_Comentario_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comentario_Publicacao1`
    FOREIGN KEY (`cod_publi`)
    REFERENCES `Reclama1`.`Publicacao` (`cod_publi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Comen_Denun`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Comen_Denun` (
  `cod_denun_comen` INT NOT NULL AUTO_INCREMENT,
  `dataHora_denun_comen` DATETIME NOT NULL,
  `status_denun_comen` CHAR(1) NOT NULL DEFAULT 'A',
  `motivo_denun_comen` LONGTEXT NOT NULL,
  `ind_visu_adm` CHAR(1) NOT NULL DEFAULT 'N',
  `cod_usu` INT NOT NULL,
  `cod_comen` INT NOT NULL,
  INDEX `fk_Usuario_has_Comentario_Comentario1_idx` (`cod_comen` ASC),
  INDEX `fk_Usuario_has_Comentario_Usuario1_idx` (`cod_usu` ASC),
  PRIMARY KEY (`cod_denun_comen`),
  CONSTRAINT `fk_Usuario_has_Comentario_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Comentario_Comentario1`
    FOREIGN KEY (`cod_comen`)
    REFERENCES `Reclama1`.`Comentario` (`cod_comen`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Reclama1`.`Comen_Curtida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reclama1`.`Comen_Curtida` (
  `cod_usu` INT NOT NULL,
  `cod_comen` INT NOT NULL,
  `status_curte` CHAR(1) NOT NULL DEFAULT 'A',
  `ind_visu_dono_publi` CHAR(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`cod_usu`, `cod_comen`),
  INDEX `fk_Usuario_has_Comentario1_Comentario1_idx` (`cod_comen` ASC),
  INDEX `fk_Usuario_has_Comentario1_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Usuario_has_Comentario1_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `Reclama1`.`Usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Comentario1_Comentario1`
    FOREIGN KEY (`cod_comen`)
    REFERENCES `Reclama1`.`Comentario` (`cod_comen`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
