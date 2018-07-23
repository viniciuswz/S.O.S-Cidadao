-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: reclama1
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.25-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bairro`
--

DROP TABLE IF EXISTS `bairro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bairro` (
  `cod_bai` int(11) NOT NULL AUTO_INCREMENT,
  `nome_bai` varchar(60) NOT NULL,
  `status_bai` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_bai`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bairro`
--

LOCK TABLES `bairro` WRITE;
/*!40000 ALTER TABLE `bairro` DISABLE KEYS */;
INSERT INTO `bairro` VALUES (1,'Engenho Novo','A'),(2,'Jardim Belval','A'),(3,'Jardim Silveira','A'),(5,'Parque Santana II','A'),(6,'Bairro do funk','A'),(7,'Bairro da jaca','A');
/*!40000 ALTER TABLE `bairro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `cod_cate` int(11) NOT NULL AUTO_INCREMENT,
  `descri_cate` varchar(60) NOT NULL,
  `status_cate` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_cate`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Saúde','A'),(2,'Segurança','A'),(3,'Transporte','A'),(4,'Educação','A'),(5,'Meio Ambiente','A');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comen_curtida`
--

DROP TABLE IF EXISTS `comen_curtida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comen_curtida` (
  `cod_usu` int(11) NOT NULL,
  `cod_comen` int(11) NOT NULL,
  `status_curte` char(1) NOT NULL DEFAULT 'A',
  `ind_visu_dono_publi` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`cod_usu`,`cod_comen`),
  KEY `fk_Usuario_has_Comentario1_Comentario1_idx` (`cod_comen`),
  KEY `fk_Usuario_has_Comentario1_Usuario1_idx` (`cod_usu`),
  CONSTRAINT `fk_Usuario_has_Comentario1_Comentario1` FOREIGN KEY (`cod_comen`) REFERENCES `comentario` (`cod_comen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Comentario1_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comen_curtida`
--

LOCK TABLES `comen_curtida` WRITE;
/*!40000 ALTER TABLE `comen_curtida` DISABLE KEYS */;
/*!40000 ALTER TABLE `comen_curtida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comen_denun`
--

DROP TABLE IF EXISTS `comen_denun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comen_denun` (
  `cod_denun_comen` int(11) NOT NULL AUTO_INCREMENT,
  `dataHora_denun_comen` datetime NOT NULL,
  `status_denun_comen` char(1) NOT NULL DEFAULT 'A',
  `motivo_denun_comen` longtext NOT NULL,
  `ind_visu_adm` char(1) NOT NULL DEFAULT 'N',
  `cod_usu` int(11) NOT NULL,
  `cod_comen` int(11) NOT NULL,
  PRIMARY KEY (`cod_denun_comen`),
  KEY `fk_Usuario_has_Comentario_Comentario1_idx` (`cod_comen`),
  KEY `fk_Usuario_has_Comentario_Usuario1_idx` (`cod_usu`),
  CONSTRAINT `fk_Usuario_has_Comentario_Comentario1` FOREIGN KEY (`cod_comen`) REFERENCES `comentario` (`cod_comen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Comentario_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comen_denun`
--

LOCK TABLES `comen_denun` WRITE;
/*!40000 ALTER TABLE `comen_denun` DISABLE KEYS */;
/*!40000 ALTER TABLE `comen_denun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentario`
--

DROP TABLE IF EXISTS `comentario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentario` (
  `cod_comen` int(11) NOT NULL AUTO_INCREMENT,
  `texto_comen` longtext NOT NULL,
  `ind_visu_dono_publi` char(1) NOT NULL DEFAULT 'N',
  `dataHora_comen` datetime NOT NULL,
  `status_comen` char(1) NOT NULL DEFAULT 'A',
  `cod_usu` int(11) NOT NULL,
  `cod_publi` int(11) NOT NULL,
  PRIMARY KEY (`cod_comen`),
  KEY `fk_Comentario_Usuario1_idx` (`cod_usu`),
  KEY `fk_Comentario_Publicacao1_idx` (`cod_publi`),
  CONSTRAINT `fk_Comentario_Publicacao1` FOREIGN KEY (`cod_publi`) REFERENCES `publicacao` (`cod_publi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comentario_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentario`
--

LOCK TABLES `comentario` WRITE;
/*!40000 ALTER TABLE `comentario` DISABLE KEYS */;
INSERT INTO `comentario` VALUES (1,'Comen1','I','2012-05-08 08:00:00','A',1,1),(3,'Comen2','N','2012-05-08 08:00:00','A',2,1),(4,'Comen3','N','2012-05-08 08:00:00','A',2,2),(5,'Comen4','N','2012-05-08 08:00:00','A',2,3),(6,'5','N','2012-05-08 08:00:00','A',3,1),(7,'6','N','2012-05-08 08:00:00','A',3,2),(8,'7','N','2012-05-08 08:00:00','A',3,3),(9,'9','N','2012-05-08 08:00:00','A',3,4),(10,'10','N','0000-00-00 00:00:00','A',4,5),(11,'11','N','0000-00-00 00:00:00','A',5,1);
/*!40000 ALTER TABLE `comentario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debate`
--

DROP TABLE IF EXISTS `debate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `debate` (
  `cod_deba` int(11) NOT NULL AUTO_INCREMENT,
  `img_deba` varchar(100) NOT NULL,
  `nome_deba` varchar(45) NOT NULL,
  `dataHora_deba` datetime NOT NULL,
  `status_deba` char(1) NOT NULL DEFAULT 'A',
  `tema_deba` varchar(100) NOT NULL,
  `descri_deba` longtext NOT NULL,
  `cod_usu` int(11) NOT NULL,
  PRIMARY KEY (`cod_deba`),
  KEY `fk_Debate_Usuario1_idx` (`cod_usu`),
  CONSTRAINT `fk_Debate_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debate`
--

LOCK TABLES `debate` WRITE;
/*!40000 ALTER TABLE `debate` DISABLE KEYS */;
/*!40000 ALTER TABLE `debate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debate_denun`
--

DROP TABLE IF EXISTS `debate_denun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `debate_denun` (
  `cod_denun_deba` int(11) NOT NULL AUTO_INCREMENT,
  `ind_visu_adm_denun_deba` char(1) NOT NULL DEFAULT 'N',
  `status_denun_deba` char(1) NOT NULL DEFAULT 'A',
  `motivo_denun_deba` longtext NOT NULL,
  `dataHora_denun_deba` datetime NOT NULL,
  `cod_usu` int(11) NOT NULL,
  `cod_deba` int(11) NOT NULL,
  PRIMARY KEY (`cod_denun_deba`),
  KEY `fk_Denuncia_debate_Usuario1_idx` (`cod_usu`),
  KEY `fk_Denuncia_debate_Debate1_idx` (`cod_deba`),
  CONSTRAINT `fk_Denuncia_debate_Debate1` FOREIGN KEY (`cod_deba`) REFERENCES `debate` (`cod_deba`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Denuncia_debate_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debate_denun`
--

LOCK TABLES `debate_denun` WRITE;
/*!40000 ALTER TABLE `debate_denun` DISABLE KEYS */;
/*!40000 ALTER TABLE `debate_denun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debate_participante`
--

DROP TABLE IF EXISTS `debate_participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `debate_participante` (
  `cod_deba` int(11) NOT NULL,
  `cod_usu` int(11) NOT NULL,
  `data_inicio_lista` datetime NOT NULL,
  `data_fim_lista` datetime DEFAULT NULL,
  `ind_visu_criador` char(1) NOT NULL DEFAULT 'N',
  `status_lista` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_deba`,`cod_usu`,`data_inicio_lista`),
  KEY `fk_Participantes_debate_Debate1_idx` (`cod_deba`),
  KEY `fk_Participantes_debate_Usuario1_idx` (`cod_usu`),
  CONSTRAINT `fk_Participantes_debate_Debate1` FOREIGN KEY (`cod_deba`) REFERENCES `debate` (`cod_deba`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Participantes_debate_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debate_participante`
--

LOCK TABLES `debate_participante` WRITE;
/*!40000 ALTER TABLE `debate_participante` DISABLE KEYS */;
/*!40000 ALTER TABLE `debate_participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logradouro`
--

DROP TABLE IF EXISTS `logradouro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logradouro` (
  `cep_logra` int(11) NOT NULL,
  `endere_logra` varchar(60) NOT NULL,
  `cod_bai` int(11) NOT NULL,
  PRIMARY KEY (`cep_logra`),
  KEY `fk_Endereco_Bairro1_idx` (`cod_bai`),
  CONSTRAINT `fk_Endereco_Bairro1` FOREIGN KEY (`cod_bai`) REFERENCES `bairro` (`cod_bai`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logradouro`
--

LOCK TABLES `logradouro` WRITE;
/*!40000 ALTER TABLE `logradouro` DISABLE KEYS */;
INSERT INTO `logradouro` VALUES (12,'Rua da Jaca',1),(45,'Rua do Gol',2),(78,'Rua do Brasil',3),(123,'Rua da Uva',1),(456,'Rua do Camario',2),(789,'Rua da Dinamarca',3),(1478,'Rua do funk',6),(897564,'Rua do crai',7),(6420150,'Avenida Grupo Bandeirantes',2),(6515045,'Rua das Mangueiras',5),(12345678,'Rua das Mangueiras',5);
/*!40000 ALTER TABLE `logradouro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensagem`
--

DROP TABLE IF EXISTS `mensagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensagem` (
  `cod_mensa` int(11) NOT NULL AUTO_INCREMENT,
  `texto_mensa` longtext NOT NULL,
  `status_mensa` char(1) NOT NULL DEFAULT 'A',
  `dataHora_mensa` datetime NOT NULL,
  `cod_usu` int(11) NOT NULL,
  `cod_deba` int(11) NOT NULL,
  PRIMARY KEY (`cod_mensa`),
  KEY `fk_Mensagem_Usuario1_idx` (`cod_usu`),
  KEY `fk_Mensagem_Debate1_idx` (`cod_deba`),
  CONSTRAINT `fk_Mensagem_Debate1` FOREIGN KEY (`cod_deba`) REFERENCES `debate` (`cod_deba`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mensagem_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensagem`
--

LOCK TABLES `mensagem` WRITE;
/*!40000 ALTER TABLE `mensagem` DISABLE KEYS */;
/*!40000 ALTER TABLE `mensagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensagem_visualizacao`
--

DROP TABLE IF EXISTS `mensagem_visualizacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensagem_visualizacao` (
  `cod_mensa` int(11) NOT NULL,
  `cod_usu` int(11) NOT NULL,
  PRIMARY KEY (`cod_mensa`,`cod_usu`),
  KEY `fk_Mensagem_visualizacao_Usuario1_idx` (`cod_usu`),
  CONSTRAINT `fk_Mensagem_visualizacao_Mensagem1` FOREIGN KEY (`cod_mensa`) REFERENCES `mensagem` (`cod_mensa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mensagem_visualizacao_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensagem_visualizacao`
--

LOCK TABLES `mensagem_visualizacao` WRITE;
/*!40000 ALTER TABLE `mensagem_visualizacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `mensagem_visualizacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publi_denun`
--

DROP TABLE IF EXISTS `publi_denun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publi_denun` (
  `cod_denun_publi` int(11) NOT NULL AUTO_INCREMENT,
  `ind_visu_adm_denun_publi` char(1) NOT NULL DEFAULT 'N',
  `motivo_denun_publi` longtext NOT NULL,
  `status_denun_publi` char(1) NOT NULL DEFAULT 'A',
  `dataHora_denun_publi` datetime NOT NULL,
  `cod_usu` int(11) NOT NULL,
  `cod_publi` int(11) NOT NULL,
  PRIMARY KEY (`cod_denun_publi`),
  KEY `fk_Usuario_has_Publicacao_Publicacao3_idx` (`cod_publi`),
  KEY `fk_Usuario_has_Publicacao_Usuario3_idx` (`cod_usu`),
  CONSTRAINT `fk_Usuario_has_Publicacao_Publicacao3` FOREIGN KEY (`cod_publi`) REFERENCES `publicacao` (`cod_publi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Publicacao_Usuario3` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publi_denun`
--

LOCK TABLES `publi_denun` WRITE;
/*!40000 ALTER TABLE `publi_denun` DISABLE KEYS */;
/*!40000 ALTER TABLE `publi_denun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicacao`
--

DROP TABLE IF EXISTS `publicacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicacao` (
  `cod_publi` int(11) NOT NULL AUTO_INCREMENT,
  `status_publi` char(1) NOT NULL DEFAULT 'A',
  `texto_publi` longtext NOT NULL,
  `titulo_publi` varchar(60) NOT NULL,
  `dataHora_publi` datetime NOT NULL,
  `cod_usu` int(11) NOT NULL,
  `cod_cate` int(11) NOT NULL,
  `cep_logra` int(11) NOT NULL,
  `img_publi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod_publi`),
  KEY `fk_Publicacao_Usuario1_idx` (`cod_usu`),
  KEY `fk_Publicacao_Categorias1_idx` (`cod_cate`),
  KEY `fk_Publicacao_Logradouro1_idx` (`cep_logra`),
  CONSTRAINT `fk_Publicacao_Categorias1` FOREIGN KEY (`cod_cate`) REFERENCES `categoria` (`cod_cate`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Publicacao_Logradouro1` FOREIGN KEY (`cep_logra`) REFERENCES `logradouro` (`cep_logra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Publicacao_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicacao`
--

LOCK TABLES `publicacao` WRITE;
/*!40000 ALTER TABLE `publicacao` DISABLE KEYS */;
INSERT INTO `publicacao` VALUES (1,'A','Texto1','Titulo1','2012-05-08 08:00:00',1,1,12,NULL),(2,'A','Texto2','Titulo2','2012-05-08 08:00:00',1,1,123,NULL),(3,'A','Texto3','Titulo3','2012-05-08 08:00:00',1,1,123,NULL),(4,'A','Texto4','Titulo4','2012-05-08 08:00:00',2,2,45,NULL),(5,'A','Texto5','Titulo5','2012-05-08 08:00:00',2,2,456,NULL),(6,'A','Texto6','Titulo6','2012-05-08 08:00:00',2,2,456,NULL),(7,'A','Texto7','Titulo7','2012-05-08 08:00:00',2,2,45,NULL),(8,'A','Texto8','Titulo8','2012-05-08 08:00:00',1,1,12,NULL),(9,'A','adasdas','Titulo1','2018-07-21 21:49:09',1,1,6515045,''),(10,'A','dasdadasdasd\r\ndasd\r\nas\r\nd\r\nasd\r\n','Titulo1','2018-07-21 21:49:35',1,2,6515045,'0c03cd62c0aa101e231c97108e1575d3.png'),(11,'A','dsadasd','Titulo1','2018-07-21 22:01:21',1,1,6515045,'0447e46d3710ecf5af641b68994bd044.08.31.jpeg'),(12,'A','dasdasdas','Titulo1','2018-07-21 22:02:46',1,1,6515045,'982aea1948ed1365a5adf252831ef14a.jpeg'),(13,'A','dasdasd','Titulo1','2018-07-21 22:05:13',2,1,897564,'c91bdb565fd2c93aae027c537c51d605.jpeg'),(15,'A','dasdasdas','Titulo1','2018-07-21 22:06:55',2,4,897564,'b89fe512f39658168628dc176617d130.jpeg'),(16,'A','Esse itb ta uma poha\r\nta um cu\r\noloco meu\r\n','Titulo1','2018-07-22 12:16:30',1,4,6420150,'6f3aafbcc90e1bbaef18dd131119e3b9.jpeg');
/*!40000 ALTER TABLE `publicacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicacao_curtida`
--

DROP TABLE IF EXISTS `publicacao_curtida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicacao_curtida` (
  `cod_usu` int(11) NOT NULL,
  `cod_publi` int(11) NOT NULL,
  `status_publi_curti` char(1) NOT NULL DEFAULT 'A',
  `ind_visu_dono_publi` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`cod_usu`,`cod_publi`),
  KEY `fk_Usuario_has_Publicacao_Publicacao2_idx` (`cod_publi`),
  KEY `fk_Usuario_has_Publicacao_Usuario2_idx` (`cod_usu`),
  CONSTRAINT `fk_Usuario_has_Publicacao_Publicacao2` FOREIGN KEY (`cod_publi`) REFERENCES `publicacao` (`cod_publi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Publicacao_Usuario2` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicacao_curtida`
--

LOCK TABLES `publicacao_curtida` WRITE;
/*!40000 ALTER TABLE `publicacao_curtida` DISABLE KEYS */;
INSERT INTO `publicacao_curtida` VALUES (1,1,'A','I'),(1,2,'A','I'),(1,3,'A','I'),(1,8,'A','I'),(2,4,'A','I'),(2,5,'A','I'),(2,6,'A','I'),(2,7,'A','I'),(3,1,'A','N'),(3,2,'A','N'),(3,3,'A','N'),(3,4,'A','N'),(3,5,'A','N'),(3,6,'A','N'),(3,7,'A','N'),(3,8,'A','N'),(4,1,'A','N'),(4,2,'A','N'),(4,3,'A','N'),(4,4,'A','N'),(4,5,'A','N'),(4,6,'A','N'),(4,7,'A','N'),(4,8,'A','N'),(5,1,'A','N'),(5,2,'A','N'),(5,3,'A','N'),(5,4,'A','N'),(5,5,'A','N'),(5,6,'A','N'),(5,7,'A','N'),(5,8,'A','N'),(6,1,'A','N'),(6,2,'A','N'),(6,3,'A','N'),(6,4,'A','N'),(6,5,'A','N'),(6,6,'A','N'),(6,7,'A','N'),(6,8,'A','N');
/*!40000 ALTER TABLE `publicacao_curtida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicacao_salva`
--

DROP TABLE IF EXISTS `publicacao_salva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicacao_salva` (
  `cod_usu` int(11) NOT NULL,
  `cod_publi` int(11) NOT NULL,
  `status_publi_sal` char(1) NOT NULL DEFAULT 'A',
  `ind_visu_respos_prefei` char(1) DEFAULT NULL,
  PRIMARY KEY (`cod_usu`,`cod_publi`),
  KEY `fk_Usuario_has_Publicacao_Publicacao1_idx` (`cod_publi`),
  KEY `fk_Usuario_has_Publicacao_Usuario1_idx` (`cod_usu`),
  CONSTRAINT `fk_Usuario_has_Publicacao_Publicacao1` FOREIGN KEY (`cod_publi`) REFERENCES `publicacao` (`cod_publi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Publicacao_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicacao_salva`
--

LOCK TABLES `publicacao_salva` WRITE;
/*!40000 ALTER TABLE `publicacao_salva` DISABLE KEYS */;
INSERT INTO `publicacao_salva` VALUES (1,4,'A','N'),(1,5,'A','N'),(1,6,'A','N'),(1,7,'A','N'),(2,1,'A','N'),(2,2,'A','N'),(2,3,'A','N'),(2,8,'A','N'),(3,1,'A','N'),(3,2,'A','N'),(3,3,'A','N'),(3,4,'A','N'),(3,5,'A','N'),(3,6,'A','N'),(3,7,'A','N'),(3,8,'A','N'),(4,1,'A','N'),(4,2,'A','N'),(4,3,'A','N'),(4,4,'A','N'),(4,5,'A','N'),(4,6,'A','N'),(4,7,'A','N'),(4,8,'A','N'),(5,1,'A','N'),(5,2,'A','N'),(5,3,'A','N'),(5,4,'A','N'),(5,5,'A','N'),(5,6,'A','N'),(5,7,'A','N'),(5,8,'A','N'),(6,1,'A','N'),(6,2,'A','N'),(6,3,'A','N'),(6,4,'A','N'),(6,5,'A','N'),(6,6,'A','N'),(6,7,'A','N'),(6,8,'A','N');
/*!40000 ALTER TABLE `publicacao_salva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `cod_tipo_usu` int(11) NOT NULL AUTO_INCREMENT,
  `descri_tipo_usu` varchar(45) NOT NULL,
  `status_tipo_usu` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_tipo_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Adm','A'),(2,'Moderador','A'),(3,'Prefeitura','A'),(4,'Funcionario','A'),(5,'Comum','A');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `cod_usu` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usu` varchar(60) NOT NULL,
  `email_usu` varchar(60) NOT NULL,
  `senha_usu` varchar(60) NOT NULL,
  `img_capa_usu` varchar(100) NOT NULL,
  `img_perfil_usu` varchar(100) NOT NULL,
  `status_usu` char(1) NOT NULL DEFAULT 'A',
  `cod_tipo_usu` int(11) NOT NULL,
  `dataHora_cadastro_usu` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_usu`),
  KEY `fk_Usuario_Tipo_usuario_idx` (`cod_tipo_usu`),
  CONSTRAINT `fk_Usuario_Tipo_usuario` FOREIGN KEY (`cod_tipo_usu`) REFERENCES `tipo_usuario` (`cod_tipo_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Aldo Churros','aldochurros@churros.com','$2y$12$xwwy4aXq0Jhs0UhVJwRSOuRllOoAJ4Ml89y/6yYipz.pTpA0ygIuG','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',5,NULL),(2,'Maria Homem','mariahomem@homem.com','$2y$12$ErOsVajdlgb7bOVnUSbL0.wSFlY5LYZiY4JJafzYTGgBTwlyVjlxi','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',5,NULL),(3,'Vinicius Cara','viniciuscara@cara.com','$2y$12$obwkAoOpuoLitpl/csykt.Kaq7YeroeEVWSwp5ftk0guMFowJpe7a','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',4,NULL),(4,'Leandro Branco','leandrobranco@branco.com','$2y$12$LzqC/cavubrrlKhV6aAwveCzIcCMYbMxIuOAcvlWudvvCpeYh0jsq','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',3,NULL),(5,'Daniel Lindo','daniellindo@lindo.com','$2y$12$VYSV7TePgQfwO5U5yT62Duo9skhVYnq2QXJWd9F1el5uFfNHLi7fK','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',2,NULL),(6,'Bruno Mole','brunomole@mole.com','$2y$12$ApV0V7vKybW/JPTULC48beUTOa2bo4tb1TviHtgShefLiiB6V75bi','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',1,NULL),(95,'Dada','dada@dada.com','$2y$12$q.BZJz7QSigB1jVyYmjAf.Xc8vVLF23kBw5ZMCGh9.A0LPCTukDyG','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',5,'2018-07-18 16:28:41'),(96,'jaquinha','jaca@jaca.com','$2y$12$UviZkC2BRq1bXeG7jbV4l.dsQ0zFGtpI2XoJw7.SbfA4z8Kzg7uEO','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',5,'2018-07-18 16:30:40'),(97,'Faustao','faus@faus.com','$2y$12$Y1a1C.4UoG89kxV9QjaWHeRjvIwD6I8ROd7E/yy3D/3TWUCIMAeR6','imgcapapadrao.jpg','imgperfilpadrao.jpg','I',5,'2018-07-19 19:11:51');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-23 15:34:21
