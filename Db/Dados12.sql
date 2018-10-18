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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bairro`
--

LOCK TABLES `bairro` WRITE;
/*!40000 ALTER TABLE `bairro` DISABLE KEYS */;
INSERT INTO `bairro` VALUES (1,'Engenho Novo','A'),(2,'Jardim Belval','A'),(3,'Jardim Silveira','A'),(5,'Parque Santana II','A'),(6,'Bairro do funk','A'),(7,'Bairro da jaca','A'),(8,'Fudeu','A'),(9,'jgsdj','A');
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
  `dataHora_comen_curti` datetime NOT NULL,
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
INSERT INTO `comen_curtida` VALUES (1,3,'A','B','2018-08-08 15:47:05'),(1,6,'A','N','2018-08-08 15:47:05'),(1,39,'I','B','2018-08-10 16:10:16'),(1,47,'I','B','2018-08-10 16:10:21'),(1,48,'A','N','2018-08-08 15:47:05'),(1,50,'I','B','2018-08-10 16:10:09'),(1,52,'I','B','2018-08-10 16:10:45'),(1,53,'I','B','2018-08-10 16:10:11'),(1,54,'I','B','2018-08-10 16:10:40'),(1,55,'I','B','2018-08-08 15:47:05'),(1,56,'I','B','2018-08-08 15:47:05'),(1,58,'I','B','2018-08-08 15:47:05'),(1,59,'I','B','2018-08-08 15:47:05'),(1,60,'I','B','2018-08-08 15:47:05'),(1,61,'I','B','2018-08-08 15:47:05'),(1,62,'I','B','2018-08-08 15:47:05'),(1,63,'I','B','2018-08-08 15:47:05'),(1,67,'I','N','2018-08-08 15:47:05'),(1,68,'I','B','2018-08-08 15:47:05'),(1,70,'I','B','2018-08-08 15:47:05'),(1,81,'I','N','2018-08-08 15:47:05'),(1,84,'A','N','2018-08-08 15:47:05'),(1,86,'I','N','2018-08-08 15:47:05'),(1,104,'I','N','2018-08-11 18:34:21'),(2,56,'A','B','2018-08-08 15:47:05'),(2,63,'A','B','2018-08-08 15:47:05'),(2,70,'I','B','2018-08-08 15:47:05'),(2,84,'A','N','2018-08-08 15:47:05'),(2,85,'I','B','2018-08-08 15:47:05'),(2,101,'A','I','2018-08-08 15:47:05'),(2,106,'A','B','2018-08-11 18:35:35'),(3,84,'A','N','2018-08-08 15:47:05'),(3,87,'A','B','2018-08-08 15:47:05'),(6,1,'A','B','2018-08-08 15:47:05'),(6,77,'A','N','2018-08-08 15:47:05'),(6,85,'A','B','2018-08-08 15:47:05'),(6,89,'A','B','2018-08-08 15:47:05'),(95,84,'A','I','0000-00-00 00:00:00'),(95,86,'A','N','0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comen_denun`
--

LOCK TABLES `comen_denun` WRITE;
/*!40000 ALTER TABLE `comen_denun` DISABLE KEYS */;
INSERT INTO `comen_denun` VALUES (1,'0000-00-00 00:00:00','A','dsadasdasA','N',1,68),(2,'0000-00-00 00:00:00','A','dadasdsB','N',1,67),(3,'2018-08-04 18:22:23','A','vacaC','N',1,78),(4,'2018-08-05 15:10:22','A','dasdasD','N',1,6),(5,'2018-08-05 15:16:54','A','dasdasE','N',1,3),(6,'2018-08-05 16:56:22','A','Nova Denuncia','N',1,64),(7,'2018-08-05 16:57:28','A','caralho','N',2,76),(8,'2018-08-05 17:18:35','A','adsadasdasdasdasd','N',2,75),(9,'2018-08-05 20:24:31','A','Vagabundo\r\n','N',1,84);
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
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentario`
--

LOCK TABLES `comentario` WRITE;
/*!40000 ALTER TABLE `comentario` DISABLE KEYS */;
INSERT INTO `comentario` VALUES (1,'Comen1','I','2012-05-08 08:00:00','A',1,1),(3,'Comen2','B','2012-05-08 08:00:00','A',2,1),(4,'Comen3','N','2012-05-08 08:00:00','A',2,2),(5,'Comen4','N','2012-05-08 08:00:00','A',2,3),(6,'5','B','2012-05-08 08:00:00','A',3,1),(7,'6','N','2012-05-08 08:00:00','A',3,2),(8,'7','N','2012-05-08 08:00:00','A',3,3),(9,'9','V','2012-05-08 08:00:00','A',3,4),(10,'10','B','2018-08-08 15:47:05','A',4,5),(11,'11','B','2018-08-08 15:47:05','A',5,1),(39,'JACA23','I','2018-07-25 20:29:02','A',1,17),(47,'JACA22','I','2018-07-25 20:31:45','A',1,17),(48,'Essa é a resposta da prefeitura','B','2018-07-25 20:31:45','A',3,17),(49,'JACA21','I','2018-07-25 20:32:11','A',1,17),(50,'JACA20','I','2018-07-25 20:32:11','A',1,17),(51,'JACA19','I','2018-07-25 20:32:11','A',1,17),(52,'JACA18','I','2018-07-25 20:32:12','A',1,17),(53,'JACA17','I','2018-07-25 20:32:19','A',1,17),(54,'JACA16','I','2018-07-25 20:32:20','A',1,17),(55,'JACA15','I','2018-07-25 20:32:20','A',1,17),(56,'JACA14','I','2018-07-25 20:32:20','A',1,17),(57,'JACA13','I','2018-07-25 20:32:30','A',1,17),(58,'JACA12','I','2018-07-25 20:32:31','A',1,17),(59,'JACA11','I','2018-07-25 20:32:31','A',1,17),(60,'JACA10','I','2018-07-25 20:32:31','A',1,17),(61,'JACA8','I','2018-07-25 20:32:58','A',1,17),(62,'JACA7','I','2018-07-25 20:33:17','A',1,17),(63,'JACA6','I','2018-07-25 20:35:02','A',1,17),(64,'JACA5','N','2018-07-25 20:35:29','I',2,17),(65,'JACA4','N','2018-07-25 20:35:30','I',2,17),(66,'JACA3','N','2018-07-25 20:39:35','I',2,17),(67,'JACA2','N','2018-07-25 20:39:53','I',2,17),(68,'JACA1','N','2018-07-25 20:40:12','I',2,17),(70,'Dasdasdsa\r\ndas\r\nd\r\nas\r\nd\r\nas\r\n','I','2018-07-27 14:31:07','A',1,17),(71,'Esse é um teste oloco meu \r\nd\r\nas\r\ndas\r\nd\r\n','B','2018-07-27 14:36:16','A',1,20),(72,'Essa é minha publicacao','I','2018-07-27 14:37:30','A',2,13),(73,'Lakdsjdljkasldhjaskld\r\nprefeiura','B','2018-07-27 14:41:15','A',3,15),(74,'Kdkljasd\r\nprefeitura','B','2018-07-27 14:59:20','A',3,20),(75,'Teste da hora 15\r\ndasdas\r\n','N','2018-07-27 15:00:59','I',1,20),(76,'Teste Novamente','B','2018-07-27 15:01:35','A',1,20),(77,'Não acredito nisso.......\r\nEntraremos em contato\r\nFique tranquila\r\n\r\nbeijos','B','2018-07-27 15:05:14','A',3,7),(78,'Ok ficarei no aguardo','I','2018-07-27 15:06:53','A',2,7),(79,'Kdbasdkhaksjdhkjashkdjasd\r\ndasd\r\nas\r\nd\r\na\r\nsd\r\nsa','B','2018-07-27 15:41:35','A',1,20),(80,'Dsadasdas','B','2018-07-27 16:00:14','A',1,20),(81,'Vcs estao no mar????\r\n\r\nhahahha\r\naqui é a prefeitura seus trouxas\r\n','N','2018-07-27 16:11:10','A',3,21),(82,'Comentario 24','B','2018-07-29 12:34:36','A',1,24),(83,'Comentario 25','B','2018-07-29 12:34:51','A',1,24),(84,'Comentario do odandkaspodaps dono','I','2018-07-29 12:35:11','I',95,24),(85,'Comeajrjajdlkja 2 lçkadjlksjdklasdsa \r\ndas\r\nd\r\nas\r\nda\r\ns','N','2018-07-29 12:36:47','A',2,24),(86,'Resposta da prefeitura\r\n','N','2018-07-29 12:37:58','A',3,24),(87,'Dsadasdasdasd','B','2018-07-29 12:45:48','A',1,24),(88,'Estou respondendo a publicacao','B','2018-07-29 12:53:47','A',3,16),(89,'','I','2018-08-03 16:02:47','A',1,23),(90,'Dsadasdasdasds','B','2018-08-04 14:13:30','A',3,8),(99,'Vou responder esta poha','B','2018-08-04 15:36:28','A',3,9),(100,'Maria homaasdsadasd','B','2018-08-10 15:52:29','A',2,17),(101,'Jaca\r\n','B','2018-08-10 16:09:05','A',2,23),(102,'TEste123123123123','B','2018-08-11 18:19:09','A',2,16),(103,'Dsadasdasdasd','B','2018-08-11 18:24:55','A',2,16),(104,'Novo TEste\r\n','I','2018-08-11 18:33:31','A',2,20),(105,'Jaca','N','2018-08-11 18:34:02','A',1,20),(106,'Dsadasdasdasdasd','N','2018-08-11 18:34:50','A',1,15),(107,'Comentario hahahahhaha','B','2018-08-12 16:15:27','A',2,12),(108,'Resposta da prefeitura hahahahahah','B','2018-08-12 16:16:09','A',3,10);
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debate`
--

LOCK TABLES `debate` WRITE;
/*!40000 ALTER TABLE `debate` DISABLE KEYS */;
INSERT INTO `debate` VALUES (1,'6802390285b5ccd24db0581.23735850.jpeg','Titulo1','2018-07-28 17:08:04','I','Tema1','O Brasil, a Lua demorou para aparecer. Por volta das 18h, quando o céu ficou mais escuro por aqui, os primeiros registros foram feitos. Foi o eclipse mais longo do século, com melhor visibilidade na Europa e na África. Sol, Terra e Lua se alinharam, e milhares de pessoas conseguiram acompanhar pelo mundo. ',1),(2,'15685508315b5ccde0330624.72623462.jpeg','Titulo2','2018-07-28 17:11:12','A','Tema2','O Brasil, a Lua demorou para aparecer. Por volta das 18h, quando o céu ficou mais escuro por aqui, os primeiros registros foram feitos. Foi o eclipse mais longo do século, com melhor visibilidade na Europa e na África. Sol, Terra e Lua se alinharam, e milhares de pessoas conseguiram acompanhar pelo mundo. ',1),(6,'17260795155b5f7039697760.53574087.jpeg','Titulo3','2018-07-30 17:08:25','I','Tema3','Dasdasdasdmnlfdsg\r\ndfg\r\ndh\r\nfghfghfghfgh\r\nfgh\r\nfg\r\nhfg\r\nh\r\nfghfghfghfgh\r\n\r\nhfghfghfgh',2),(7,'15412471415b634b78d6f438.80662608.jpg','Novo Teste','2018-08-02 15:20:40','A','Teste','Dsadasjdaslkdjaklsdjklasjdlkasjldkjaskdlkasd\r\nfgsgjdsfjgldfjsgljldfjfdjglj\r\ngdçldfjgkjdfgjdfkgkdjfgkjdfkgjkdfgdfg\r\ndlgkjfdkjgdkjfkjfdkjgdkjkjdfskjsdgkjkjsdiqaw vroijnjfn lgfjuhewujrarueijhg',1),(8,'17874108135b634ce49f6250.82056001.png','Novo Teste2','2018-08-02 15:26:44','I','Teste2','Adsasdasiodhajkfdhkjs fdsjkah jkshgkj hfdskjg hdksfjg kjsdhfgj khkjfsdg kjsdg kjhdfskgj hdskjfgh kjdsf\r\n igfdjg jdslkg gkdsj klfdsjgjdsg g kdslfgjkfdsgj klgk lsjkgd \r\n',1),(9,'14510540505b634ce88b5ee5.03941712.png','Novo Teste2','2018-08-02 15:26:48','A','Teste2','Adsasdasiodhajkfdhkjs fdsjkah jkshgkj hfdskjg hdksfjg kjsdhfgj khkjfsdg kjsdg kjhdfskgj hdskjfgh kjdsf\r\n igfdjg jdslkg gkdsj klfdsjgjdsg g kdslfgjkfdsgj klgk lsjkgd \r\n',1),(14,'3782531955b634e6ac6d7b0.47994861.png','Novo Teste2','2018-08-02 15:33:14','A','Teste2','Dasfadksjfldsjfsda\r\nf\r\ndsafsdafjaslkdfjsdjgldsgjds\r\ng\r\nfdgjsdlkgfdjgdsfjgjdsfg',1),(15,'463582805b634e841b4ed6.74097297.png','Novo Teste2','2018-08-02 15:33:40','I','Teste2','Dasfadksjfldsjfsda\r\nf\r\ndsafsdafjaslkdfjsdjgldsgjds\r\ng\r\nfdgjsdlkgfdjgdsfjgjdsfg',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debate_denun`
--

LOCK TABLES `debate_denun` WRITE;
/*!40000 ALTER TABLE `debate_denun` DISABLE KEYS */;
INSERT INTO `debate_denun` VALUES (1,'N','A','vaca\r\n','2018-08-04 18:22:06',1,6),(2,'N','A','TEste 24\r\n','2018-08-06 15:05:19',3,14),(3,'N','A','Quero denunciar esta poha, sou a prefeitura','2018-08-06 16:05:18',3,9),(4,'N','A','Novamente vou denunciar esta parada\r\n','2018-08-06 16:06:15',3,7);
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
INSERT INTO `debate_participante` VALUES (1,1,'2018-07-28 17:11:12',NULL,'I','A'),(1,2,'2018-07-28 17:11:12',NULL,'N','A'),(1,95,'2018-07-28 17:11:12',NULL,'N','A'),(2,1,'2018-07-28 17:11:12',NULL,'N','A'),(6,2,'2018-07-30 17:08:25',NULL,'I','A'),(7,1,'2018-08-02 15:20:41',NULL,'I','A'),(8,1,'2018-08-02 15:26:44',NULL,'I','A'),(9,1,'2018-08-02 15:26:48',NULL,'I','A'),(14,1,'2018-08-02 15:33:14',NULL,'I','A'),(15,1,'2018-08-02 15:33:40',NULL,'I','A');
/*!40000 ALTER TABLE `debate_participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logradouro`
--

DROP TABLE IF EXISTS `logradouro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logradouro` (
  `cep_logra` varchar(8) NOT NULL,
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
INSERT INTO `logradouro` VALUES ('01313000','Rua Nove de Julho',5),('01407000','Avenida 14 de Juhlo',3),('06420150','Avenida Grupo Bandeirantes',2),('06515045','Rua das Mangueiras',5),('12','Rua da Jaca',1),('123','Rua da Uva',1),('1234567','Rua das Mangueiras',5),('1478','Rua do funk',6),('17670-00','Avenida Fudeu agora',8),('24120196','Rua daklsjd',9),('45','Rua do Gol',2),('456','Rua do Camario',2),('78','Rua do Brasil',3),('789','Rua da Dinamarca',3),('897564','Rua do crai',7);
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
  `dataHora_mensa_visu` datetime NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publi_denun`
--

LOCK TABLES `publi_denun` WRITE;
/*!40000 ALTER TABLE `publi_denun` DISABLE KEYS */;
INSERT INTO `publi_denun` VALUES (21,'N','Quero denunciar esta poha','I','2018-08-03 14:59:01',1,24),(22,'N','saASDASD','A','2018-08-03 15:11:47',1,13),(24,'N','Quero denunciar esta poha','A','2018-08-03 15:50:42',1,20),(25,'N','oloko meu','A','2018-08-03 15:56:37',1,15),(26,'N','dasdsadas','A','2018-08-03 15:57:48',3,24),(27,'N','dsadasdasd','A','2018-08-04 16:42:38',1,6);
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
  `cep_logra` varchar(8) NOT NULL,
  `img_publi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod_publi`),
  KEY `fk_Publicacao_Usuario1_idx` (`cod_usu`),
  KEY `fk_Publicacao_Categorias1_idx` (`cod_cate`),
  KEY `fk_Publicacao_Logradouro1_idx` (`cep_logra`),
  CONSTRAINT `fk_Publicacao_Categorias1` FOREIGN KEY (`cod_cate`) REFERENCES `categoria` (`cod_cate`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Publicacao_Logradouro1` FOREIGN KEY (`cep_logra`) REFERENCES `logradouro` (`cep_logra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Publicacao_Usuario1` FOREIGN KEY (`cod_usu`) REFERENCES `usuario` (`cod_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicacao`
--

LOCK TABLES `publicacao` WRITE;
/*!40000 ALTER TABLE `publicacao` DISABLE KEYS */;
INSERT INTO `publicacao` VALUES (1,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo1','2012-05-08 08:00:00',1,1,'06515045',NULL),(2,'I','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo2','2012-05-08 08:00:00',1,1,'06515045',NULL),(3,'I','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo3','2012-05-08 08:00:00',1,1,'06515045',NULL),(4,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo4','2012-05-08 08:00:00',2,2,'01313000',NULL),(5,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo5','2012-05-08 08:00:00',2,2,'01313000',NULL),(6,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo6','2012-05-08 08:00:00',2,2,'01313000',NULL),(7,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo7','2012-05-08 08:00:00',2,2,'01407000',NULL),(8,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo8','2012-05-08 08:00:00',1,1,'01407000',NULL),(9,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo1','2018-07-21 21:49:09',1,1,'06515045',''),(10,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo1','2018-07-21 21:49:35',1,2,'06515045','0c03cd62c0aa101e231c97108e1575d3.png'),(11,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo1','2018-07-21 22:01:21',1,1,'06515045','0447e46d3710ecf5af641b68994bd044.08.31.jpeg'),(12,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo1','2018-07-21 22:02:46',1,1,'06515045','982aea1948ed1365a5adf252831ef14a.jpeg'),(13,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo1','2018-07-21 22:05:13',2,1,'06515045','c91bdb565fd2c93aae027c537c51d605.jpeg'),(15,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo1','2018-07-21 22:06:55',2,4,'06515045','b89fe512f39658168628dc176617d130.jpeg'),(16,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Titulo1','2018-07-22 12:16:30',1,4,'06420150','6f3aafbcc90e1bbaef18dd131119e3b9.jpeg'),(17,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Estudantes sendo escravizados','2018-07-24 14:41:14',1,1,'06515045','6373643755b565c1e7095d9.30678218.jpeg'),(20,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Falta de Merenda no colégio','2018-07-25 19:44:21',2,4,'06420150','8918513285b58fd453602a9.76229848.jpeg'),(21,'I','Dasçdlkjasd\r\nasd\r\na\r\nsd\r\nasd\r\nas\r\nd\r\nasd\r\na','Asjdhjkas','2018-07-27 16:05:28',1,3,'24120196','16030106325b5b6cf8a1be76.07112197.jpeg'),(23,'A','Dsadasdsa\r\nd\r\nasd\r\n\r\nasd\r\nas\r\nd\r\nas\r\nd\r\nasd','FudeuMuito','2018-07-27 16:36:01',1,2,'06515045','4022223835b5b7421b01460.95465948.png'),(24,'A','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.','Teste 24','2018-07-29 12:30:28',95,5,'06515045','8753355365b5ddd9454b221.82374961.jpeg');
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
  `dataHora_publi_curti` datetime NOT NULL,
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
INSERT INTO `publicacao_curtida` VALUES (1,1,'I','B','2018-08-10 16:11:27'),(1,2,'A','I','2018-08-08 15:47:05'),(1,3,'A','I','2018-08-08 15:47:05'),(1,4,'I','B','2018-08-08 15:47:05'),(1,7,'I','B','2018-08-08 15:47:05'),(1,8,'I','B','2018-08-10 16:11:28'),(1,9,'I','B','2018-08-08 15:47:05'),(1,10,'I','B','2018-08-10 16:11:24'),(1,11,'I','B','2018-08-10 16:11:23'),(1,12,'I','B','2018-08-10 16:11:22'),(1,13,'I','N','2018-08-10 16:11:21'),(1,15,'A','N','2018-08-11 18:34:42'),(1,16,'I','B','2018-08-08 15:47:05'),(1,17,'I','B','2018-08-09 19:49:09'),(1,20,'I','N','2018-08-10 16:11:16'),(1,21,'I','I','2018-08-08 15:47:05'),(1,23,'A','I','2018-08-12 16:12:51'),(1,24,'I','N','2018-08-10 16:11:12'),(2,4,'A','B','2018-08-08 15:47:05'),(2,5,'A','B','2018-08-08 15:47:05'),(2,6,'A','B','2018-08-08 15:47:05'),(2,7,'A','B','2018-08-08 15:47:05'),(2,8,'A','B','2018-08-11 18:14:58'),(2,12,'A','B','2018-08-12 16:15:12'),(2,13,'A','B','2018-08-08 15:47:05'),(2,15,'A','I','2018-08-11 18:35:09'),(2,16,'A','B','2018-08-11 18:14:17'),(2,17,'A','B','2018-08-08 15:47:05'),(2,20,'I','B','2018-08-08 15:47:05'),(2,21,'I','N','2018-08-08 15:47:05'),(2,23,'A','B','2018-08-12 16:14:46'),(2,24,'A','N','2018-08-11 18:14:00'),(3,1,'A','B','2018-08-08 15:47:05'),(3,2,'A','N','2018-08-08 15:47:05'),(3,3,'A','N','2018-08-08 15:47:05'),(3,4,'I','B','2018-08-08 15:48:38'),(3,5,'A','B','2018-08-08 15:48:38'),(3,6,'A','B','2018-08-08 15:48:38'),(3,7,'A','B','2018-08-08 15:48:38'),(3,8,'A','B','2018-08-08 15:48:38'),(3,10,'A','B','2018-08-12 16:15:56'),(3,24,'I','N','2018-08-08 15:48:38'),(4,1,'A','B','2018-08-08 15:47:05'),(4,2,'A','N','2018-08-08 15:47:05'),(4,3,'A','N','2018-08-08 15:47:05'),(4,4,'A','B','2018-08-08 15:47:05'),(4,5,'I','B','2018-08-08 15:47:05'),(4,6,'A','B','2018-08-08 15:47:05'),(4,7,'A','B','2018-08-08 15:47:05'),(4,8,'A','B','2018-08-08 15:47:05'),(5,1,'A','B','2018-08-08 15:47:05'),(5,2,'A','N','2018-08-08 15:47:05'),(5,3,'A','N','2018-08-08 15:47:05'),(5,4,'A','B','2018-08-08 15:47:05'),(5,5,'I','B','2018-08-08 15:47:05'),(5,6,'A','B','2018-08-08 15:47:05'),(5,7,'I','B','2018-08-08 15:47:05'),(5,8,'A','B','2018-08-08 15:47:05'),(6,1,'A','B','2018-08-08 15:47:05'),(6,2,'A','N','2018-08-08 15:47:05'),(6,3,'A','N','2018-08-08 15:47:05'),(6,4,'A','B','2018-08-08 15:48:38'),(6,5,'I','B','2018-08-08 15:48:38'),(6,6,'A','B','2018-08-08 15:48:38'),(6,8,'A','B','2018-08-08 15:48:38'),(6,23,'A','B','2018-08-08 15:48:38'),(95,24,'A','I','2018-08-08 15:48:38');
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
INSERT INTO `publicacao_salva` VALUES (1,4,'A','B'),(1,5,'A','B'),(1,6,'A','B'),(1,7,'A','B'),(2,1,'A','B'),(2,2,'A','B'),(2,3,'A','B'),(2,8,'A','B'),(3,1,'A','N'),(3,2,'A','N'),(3,3,'A','N'),(3,4,'A','N'),(3,5,'A','N'),(3,6,'A','N'),(3,7,'A','N'),(3,8,'A','N'),(4,1,'A','N'),(4,2,'A','N'),(4,3,'A','N'),(4,4,'A','N'),(4,5,'A','N'),(4,6,'A','N'),(4,7,'A','N'),(4,8,'A','N'),(5,1,'A','N'),(5,2,'A','N'),(5,3,'A','N'),(5,4,'A','N'),(5,5,'A','N'),(5,6,'A','N'),(5,7,'A','N'),(5,8,'A','N'),(6,1,'A','N'),(6,2,'A','N'),(6,3,'A','N'),(6,4,'A','N'),(6,5,'A','N'),(6,6,'A','N'),(6,7,'A','N'),(6,8,'A','N');
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
INSERT INTO `usuario` VALUES (1,'Aldo Churros','aldochurros@churros.com','$2y$12$xwwy4aXq0Jhs0UhVJwRSOuRllOoAJ4Ml89y/6yYipz.pTpA0ygIuG','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',5,'2018-07-18 16:28:41'),(2,'Maria Homem','mariahomem@homem.com','$2y$12$ErOsVajdlgb7bOVnUSbL0.wSFlY5LYZiY4JJafzYTGgBTwlyVjlxi','mulher-maravilha1.jpg','mulher-maravilha1.jpg','A',5,'2018-07-18 16:30:40'),(3,'Vinicius Cara','viniciuscara@cara.com','$2y$12$xmRT5Z4P3W1bwnS6OJu0Mul/9QEKFRYdR3krz1Bz1gebJj19W7gF.','imgcapapadrao.jpg','concursobarueri4.jpg','A',4,'2018-07-18 16:28:41'),(4,'Leandro Branco','leandrobranco@branco.com','$2y$12$LzqC/cavubrrlKhV6aAwveCzIcCMYbMxIuOAcvlWudvvCpeYh0jsq','imgcapapadrao.jpg','concursobarueri4.jpg','A',3,'2018-07-18 16:30:40'),(5,'Daniel Lindo','daniellindo@lindo.com','$2y$12$VYSV7TePgQfwO5U5yT62Duo9skhVYnq2QXJWd9F1el5uFfNHLi7fK','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',2,'2018-07-19 19:11:51'),(6,'Bruno Mole','brunomole@mole.com','$2y$12$ApV0V7vKybW/JPTULC48beUTOa2bo4tb1TviHtgShefLiiB6V75bi','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',1,'2018-07-19 19:11:51'),(95,'Dada','dada@dada.com','$2y$12$q.BZJz7QSigB1jVyYmjAf.Xc8vVLF23kBw5ZMCGh9.A0LPCTukDyG','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',5,'2018-07-18 16:28:41'),(96,'jaquinha','jaca@jaca.com','$2y$12$UviZkC2BRq1bXeG7jbV4l.dsQ0zFGtpI2XoJw7.SbfA4z8Kzg7uEO','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',5,'2018-07-18 16:30:40'),(97,'Faustao','faus@faus.com','$2y$12$Y1a1C.4UoG89kxV9QjaWHeRjvIwD6I8ROd7E/yy3D/3TWUCIMAeR6','imgcapapadrao.jpg','imgperfilpadrao.jpg','A',5,'2018-07-19 19:11:51');
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

-- Dump completed on 2018-08-12 16:55:49
