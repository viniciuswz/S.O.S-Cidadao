-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema reclama1
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema reclama1
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `reclama1` DEFAULT CHARACTER SET latin1 ;
USE `reclama1` ;

-- -----------------------------------------------------
-- Table `reclama1`.`bairro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`bairro` (
  `cod_bai` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_bai` VARCHAR(60) NOT NULL,
  `status_bai` CHAR(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_bai`))
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`categoria` (
  `cod_cate` INT(11) NOT NULL AUTO_INCREMENT,
  `descri_cate` VARCHAR(60) NOT NULL,
  `status_cate` CHAR(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_cate`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`tipo_comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`tipo_comentario` (
  `cod_tipo_comen` INT(11) NOT NULL AUTO_INCREMENT,
  `status_tipo_comen` CHAR(1) NOT NULL DEFAULT 'A',
  `nome_tipo_comen` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`cod_tipo_comen`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`logradouro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`logradouro` (
  `cep_logra` VARCHAR(8) NOT NULL,
  `endere_logra` VARCHAR(60) NOT NULL,
  `cod_bai` INT(11) NOT NULL,
  PRIMARY KEY (`cep_logra`),
  INDEX `fk_Endereco_Bairro1_idx` (`cod_bai` ASC),
  CONSTRAINT `fk_Endereco_Bairro1`
    FOREIGN KEY (`cod_bai`)
    REFERENCES `reclama1`.`bairro` (`cod_bai`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`tipo_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`tipo_usuario` (
  `cod_tipo_usu` INT(11) NOT NULL AUTO_INCREMENT,
  `descri_tipo_usu` VARCHAR(45) NOT NULL,
  `status_tipo_usu` CHAR(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_tipo_usu`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`usuario` (
  `cod_usu` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_usu` VARCHAR(60) NOT NULL,
  `email_usu` VARCHAR(60) NOT NULL,
  `senha_usu` VARCHAR(60) NOT NULL,
  `img_capa_usu` VARCHAR(100) NOT NULL,
  `img_perfil_usu` VARCHAR(100) NOT NULL,
  `status_usu` CHAR(1) NOT NULL DEFAULT 'A',
  `cod_tipo_usu` INT(11) NOT NULL,
  `dataHora_cadastro_usu` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`cod_usu`),
  INDEX `fk_Usuario_Tipo_usuario_idx` (`cod_tipo_usu` ASC),
  CONSTRAINT `fk_Usuario_Tipo_usuario`
    FOREIGN KEY (`cod_tipo_usu`)
    REFERENCES `reclama1`.`tipo_usuario` (`cod_tipo_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 224
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`publicacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`publicacao` (
  `cod_publi` INT(11) NOT NULL AUTO_INCREMENT,
  `status_publi` CHAR(1) NOT NULL DEFAULT 'A',
  `texto_publi` LONGTEXT NOT NULL,
  `titulo_publi` VARCHAR(60) NOT NULL,
  `dataHora_publi` DATETIME NOT NULL,
  `cod_usu` INT(11) NOT NULL,
  `cod_cate` INT(11) NOT NULL,
  `cep_logra` VARCHAR(8) NOT NULL,
  `img_publi` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`cod_publi`),
  INDEX `fk_Publicacao_Usuario1_idx` (`cod_usu` ASC),
  INDEX `fk_Publicacao_Categorias1_idx` (`cod_cate` ASC),
  INDEX `fk_Publicacao_Logradouro1_idx` (`cep_logra` ASC),
  CONSTRAINT `fk_Publicacao_Categorias1`
    FOREIGN KEY (`cod_cate`)
    REFERENCES `reclama1`.`categoria` (`cod_cate`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Publicacao_Logradouro1`
    FOREIGN KEY (`cep_logra`)
    REFERENCES `reclama1`.`logradouro` (`cep_logra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Publicacao_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 52
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`comentario` (
  `cod_comen` INT(11) NOT NULL AUTO_INCREMENT,
  `texto_comen` LONGTEXT NOT NULL,
  `ind_visu_dono_publi` CHAR(1) NOT NULL DEFAULT 'N',
  `dataHora_comen` DATETIME NOT NULL,
  `status_comen` CHAR(1) NOT NULL DEFAULT 'A',
  `cod_usu` INT(11) NOT NULL,
  `cod_publi` INT(11) NOT NULL,
  `nota_resposta` VARCHAR(2) NULL DEFAULT NULL,
  `cod_tipo_comentario` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`cod_comen`),
  INDEX `fk_Comentario_Usuario1_idx` (`cod_usu` ASC),
  INDEX `fk_Comentario_Publicacao1_idx` (`cod_publi` ASC),
  INDEX `estrangeira_tipo_comen` (`cod_tipo_comentario` ASC),
  CONSTRAINT `estrangeira_tipo_comen`
    FOREIGN KEY (`cod_tipo_comentario`)
    REFERENCES `reclama1`.`tipo_comentario` (`cod_tipo_comen`),
  CONSTRAINT `fk_Comentario_Publicacao1`
    FOREIGN KEY (`cod_publi`)
    REFERENCES `reclama1`.`publicacao` (`cod_publi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comentario_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 304
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`comen_curtida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`comen_curtida` (
  `cod_usu` INT(11) NOT NULL,
  `cod_comen` INT(11) NOT NULL,
  `status_curte` CHAR(1) NOT NULL DEFAULT 'A',
  `ind_visu_dono_publi` CHAR(1) NOT NULL DEFAULT 'N',
  `dataHora_comen_curti` DATETIME NOT NULL,
  PRIMARY KEY (`cod_usu`, `cod_comen`),
  INDEX `fk_Usuario_has_Comentario1_Comentario1_idx` (`cod_comen` ASC),
  INDEX `fk_Usuario_has_Comentario1_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Usuario_has_Comentario1_Comentario1`
    FOREIGN KEY (`cod_comen`)
    REFERENCES `reclama1`.`comentario` (`cod_comen`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Comentario1_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`comen_denun`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`comen_denun` (
  `cod_denun_comen` INT(11) NOT NULL AUTO_INCREMENT,
  `dataHora_denun_comen` DATETIME NOT NULL,
  `status_denun_comen` CHAR(1) NOT NULL DEFAULT 'A',
  `motivo_denun_comen` LONGTEXT NOT NULL,
  `ind_visu_adm` CHAR(1) NOT NULL DEFAULT 'N',
  `cod_usu` INT(11) NOT NULL,
  `cod_comen` INT(11) NOT NULL,
  PRIMARY KEY (`cod_denun_comen`),
  INDEX `fk_Usuario_has_Comentario_Comentario1_idx` (`cod_comen` ASC),
  INDEX `fk_Usuario_has_Comentario_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Usuario_has_Comentario_Comentario1`
    FOREIGN KEY (`cod_comen`)
    REFERENCES `reclama1`.`comentario` (`cod_comen`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Comentario_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 59
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`debate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`debate` (
  `cod_deba` INT(11) NOT NULL AUTO_INCREMENT,
  `img_deba` VARCHAR(100) NOT NULL,
  `nome_deba` VARCHAR(45) NOT NULL,
  `dataHora_deba` DATETIME NOT NULL,
  `status_deba` CHAR(1) NOT NULL DEFAULT 'A',
  `tema_deba` VARCHAR(100) NOT NULL,
  `descri_deba` LONGTEXT NOT NULL,
  `cod_usu` INT(11) NOT NULL,
  PRIMARY KEY (`cod_deba`),
  INDEX `fk_Debate_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Debate_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 44
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`debate_denun`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`debate_denun` (
  `cod_denun_deba` INT(11) NOT NULL AUTO_INCREMENT,
  `ind_visu_adm_denun_deba` CHAR(1) NOT NULL DEFAULT 'N',
  `status_denun_deba` CHAR(1) NOT NULL DEFAULT 'A',
  `motivo_denun_deba` LONGTEXT NOT NULL,
  `dataHora_denun_deba` DATETIME NOT NULL,
  `cod_usu` INT(11) NOT NULL,
  `cod_deba` INT(11) NOT NULL,
  PRIMARY KEY (`cod_denun_deba`),
  INDEX `fk_Denuncia_debate_Usuario1_idx` (`cod_usu` ASC),
  INDEX `fk_Denuncia_debate_Debate1_idx` (`cod_deba` ASC),
  CONSTRAINT `fk_Denuncia_debate_Debate1`
    FOREIGN KEY (`cod_deba`)
    REFERENCES `reclama1`.`debate` (`cod_deba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Denuncia_debate_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 42
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`debate_participante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`debate_participante` (
  `cod_deba` INT(11) NOT NULL,
  `cod_usu` INT(11) NOT NULL,
  `data_inicio_lista` DATETIME NOT NULL,
  `data_fim_lista` DATETIME NULL DEFAULT NULL,
  `ind_visu_criador` CHAR(1) NOT NULL DEFAULT 'N',
  `status_lista` CHAR(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_deba`, `cod_usu`, `data_inicio_lista`),
  INDEX `fk_Participantes_debate_Debate1_idx` (`cod_deba` ASC),
  INDEX `fk_Participantes_debate_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Participantes_debate_Debate1`
    FOREIGN KEY (`cod_deba`)
    REFERENCES `reclama1`.`debate` (`cod_deba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Participantes_debate_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`mensagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`mensagem` (
  `cod_mensa` INT(11) NOT NULL AUTO_INCREMENT,
  `texto_mensa` LONGTEXT NOT NULL,
  `status_mensa` CHAR(1) NOT NULL DEFAULT 'A',
  `dataHora_mensa` DATETIME NOT NULL,
  `cod_usu` INT(11) NOT NULL,
  `cod_deba` INT(11) NOT NULL,
  PRIMARY KEY (`cod_mensa`),
  INDEX `fk_Mensagem_Usuario1_idx` (`cod_usu` ASC),
  INDEX `fk_Mensagem_Debate1_idx` (`cod_deba` ASC),
  CONSTRAINT `fk_Mensagem_Debate1`
    FOREIGN KEY (`cod_deba`)
    REFERENCES `reclama1`.`debate` (`cod_deba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mensagem_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1521
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`mensagem_visualizacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`mensagem_visualizacao` (
  `cod_mensa` INT(11) NOT NULL,
  `cod_usu` INT(11) NOT NULL,
  `dataHora_mensa_visu` DATETIME NOT NULL,
  `status_visu` CHAR(1) NULL DEFAULT NULL,
  PRIMARY KEY (`cod_mensa`, `cod_usu`),
  INDEX `fk_Mensagem_visualizacao_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Mensagem_visualizacao_Mensagem1`
    FOREIGN KEY (`cod_mensa`)
    REFERENCES `reclama1`.`mensagem` (`cod_mensa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mensagem_visualizacao_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`publi_denun`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`publi_denun` (
  `cod_denun_publi` INT(11) NOT NULL AUTO_INCREMENT,
  `ind_visu_adm_denun_publi` CHAR(1) NOT NULL DEFAULT 'N',
  `motivo_denun_publi` LONGTEXT NOT NULL,
  `status_denun_publi` CHAR(1) NOT NULL DEFAULT 'A',
  `dataHora_denun_publi` DATETIME NOT NULL,
  `cod_usu` INT(11) NOT NULL,
  `cod_publi` INT(11) NOT NULL,
  PRIMARY KEY (`cod_denun_publi`),
  INDEX `fk_Usuario_has_Publicacao_Publicacao3_idx` (`cod_publi` ASC),
  INDEX `fk_Usuario_has_Publicacao_Usuario3_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Usuario_has_Publicacao_Publicacao3`
    FOREIGN KEY (`cod_publi`)
    REFERENCES `reclama1`.`publicacao` (`cod_publi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Publicacao_Usuario3`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 98
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`publicacao_curtida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`publicacao_curtida` (
  `cod_usu` INT(11) NOT NULL,
  `cod_publi` INT(11) NOT NULL,
  `status_publi_curti` CHAR(1) NOT NULL DEFAULT 'A',
  `ind_visu_dono_publi` CHAR(1) NOT NULL DEFAULT 'N',
  `dataHora_publi_curti` DATETIME NOT NULL,
  PRIMARY KEY (`cod_usu`, `cod_publi`),
  INDEX `fk_Usuario_has_Publicacao_Publicacao2_idx` (`cod_publi` ASC),
  INDEX `fk_Usuario_has_Publicacao_Usuario2_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Usuario_has_Publicacao_Publicacao2`
    FOREIGN KEY (`cod_publi`)
    REFERENCES `reclama1`.`publicacao` (`cod_publi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Publicacao_Usuario2`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`publicacao_salva`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`publicacao_salva` (
  `cod_usu` INT(11) NOT NULL,
  `cod_publi` INT(11) NOT NULL,
  `status_publi_sal` CHAR(1) NOT NULL DEFAULT 'A',
  `ind_visu_respos_prefei` CHAR(1) NULL DEFAULT NULL,
  PRIMARY KEY (`cod_usu`, `cod_publi`),
  INDEX `fk_Usuario_has_Publicacao_Publicacao1_idx` (`cod_publi` ASC),
  INDEX `fk_Usuario_has_Publicacao_Usuario1_idx` (`cod_usu` ASC),
  CONSTRAINT `fk_Usuario_has_Publicacao_Publicacao1`
    FOREIGN KEY (`cod_publi`)
    REFERENCES `reclama1`.`publicacao` (`cod_publi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Publicacao_Usuario1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `reclama1`.`recuperar_senha`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reclama1`.`recuperar_senha` (
  `cod_recupe_senha` INT(11) NOT NULL AUTO_INCREMENT,
  `status_recuperar_senha` CHAR(1) NOT NULL,
  `data_hora_solicitacao` DATETIME NOT NULL,
  `cod_usu` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`cod_recupe_senha`),
  INDEX `cod_usu` (`cod_usu` ASC),
  CONSTRAINT `recuperar_senha_ibfk_1`
    FOREIGN KEY (`cod_usu`)
    REFERENCES `reclama1`.`usuario` (`cod_usu`))
ENGINE = InnoDB
AUTO_INCREMENT = 97
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
