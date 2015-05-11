CREATE DATABASE  IF NOT EXISTS `psueyetstore` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `psueyetstore`;
-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: us-cdbr-azure-east-b.cloudapp.net    Database: psueyetstore
-- ------------------------------------------------------
-- Server version	5.5.40-log

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
-- Table structure for table `looks`
--

DROP TABLE IF EXISTS `looks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `looks` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ts` varchar(30) COLLATE utf8_bin NOT NULL,
  `param_workerId` varchar(20) COLLATE utf8_bin NOT NULL,
  `param_hitId` varchar(35) COLLATE utf8_bin NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `looks`
--

LOCK TABLES `looks` WRITE;
/*!40000 ALTER TABLE `looks` DISABLE KEYS */;
/*!40000 ALTER TABLE `looks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Media ID',
  `media_type` int(11) NOT NULL COMMENT 'Media Type ID',
  `path` varchar(255) NOT NULL COMMENT 'Path to Media',
  `zip_path` varchar(255) DEFAULT NULL COMMENT 'Path to Downloadable Zip',
  `cover_path` varchar(255) DEFAULT NULL COMMENT 'Path to Cover (or preview)',
  `genre` varchar(255) DEFAULT NULL COMMENT 'Content Genre',
  `name` varchar(255) NOT NULL COMMENT 'Media Name',
  `author` varchar(255) DEFAULT NULL COMMENT 'Media Author',
  `description` text COMMENT 'Media Description (Really only useful for Book types)',
  PRIMARY KEY (`id`),
  KEY `CONTENT_MEDIA_TYPE_idx` (`media_type`),
  CONSTRAINT `CONTENT_MEDIA_TYPE` FOREIGN KEY (`media_type`) REFERENCES `media_types` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8 COMMENT='Contains information about all the media provided';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,1,'media/1.mp3','media/1.zip','media/1.jpg','Classical','First Sense','Pianochocolate',NULL),(11,1,'media/2.mp3','media/2.zip','media/2.jpg','Pop/Dance','All Rights Reserved','Anny Sky',NULL),(21,1,'media/3.mp3','media/3.zip','media/3.jpg','Rap','Shorty Wanna Ryde','LOKIXXIMO',NULL),(31,1,'media/4.mp3','media/4.zip','media/4.jpg','Folk','Let\'s Eat','Marc Reeves',NULL),(41,1,'media/5.mp3','media/5.zip','media/5.jpg','African/World','Savane','Jean Pierre Saussac',NULL),(51,1,'media/6.mp3','media/6.zip','media/6.jpg','Metal/Rock','Villian','Flytrap',NULL),(61,11,'media/about-bananas.mp4','media/about-bananas.mp4',NULL,NULL,'About Bananas',NULL,NULL),(71,11,'media/earth-in-hd.mp4','media/earth-in-hd.mp4',NULL,NULL,'Earth in HD',NULL,NULL),(81,11,'media/elephants-dream.mp4','media/elephants-dream.mp4',NULL,NULL,'Elephant\'s Dream',NULL,NULL),(91,11,'media/sintel.mp4','media/sintel.mp4',NULL,NULL,'Sintel',NULL,NULL),(101,11,'media/the-goat.mp4','media/the-goat.mp4',NULL,NULL,'The Goat',NULL,NULL),(121,21,'media/diary-of-a-uboat-commander.pdf','media/diary-of-a-uboat-commander.pdf','media/ebook.jpg',NULL,'Diary of a U-Boat Commander','Sir William Stephen King-Hall','The diary of a World War One U-Boat commander. As well as being a fascinating glimpse of life on the German U-boats during the intense submarine blockade, this also reminds us there were humans involved - on both sides of the action - as we read too of the intimate thoughts and intense love of a man longing for his sweetheart.'),(131,21,'media/free-culture.pdf','media/free-culture.pdf','media/ebook.jpg',NULL,'Free Culture','Lawrence Lessig','Lawrence Lessig, “the most important thinker on intellectual property in the Internet era” (The New Yorker), masterfully argues that never before in human history has the power to control creative progress been so concentrated in the hands of the powerful few, the so-called Big Media. Never before have the cultural powers- that-be been able to exert such control over what we can and can’t do with the culture around us. Our society defends free markets and free speech; why then does it permit such top-down control? To lose our long tradition of free culture, Lawrence Lessig shows us, is to lose our freedom to create, our freedom to build, and, ultimately, our freedom to imagine.'),(141,21,'media/i-robot.pdf','media/i-robot.pdf','media/ebook.jpg',NULL,'I, Robot','Cory Doctorow','\"I, Robot\" is a science-fiction short story by Cory Doctorow published in 2005. The story is set in the type of police state needed to ensure that only one company is allowed to make robots, and only one type of robot is allowed. The story follows single Father detective Arturo Icaza de Arana-Goldberg while he tries to track down his missing teenage daughter. The detective is a bit of an outcast because his wife defected to Eurasia, a rival Superpower.'),(151,21,'media/men-of-iron.pdf','media/men-of-iron.pdf','media/ebook.jpg',NULL,'Men of Iron','Howard Pyle','Men of Iron is an 1891 novel by the American author Howard Pyle, who also illustrated it. It is juvenile coming of age work in which the author has the reader experience the medieval entry into knighthood through the eyes of a young squire, Myles Falworth. In Chapter 24 the knighthood ceremony is presented and described as it would be in a non-fiction work on knighthood and chivalry. Descriptions of training equipment are also given throughout. It was made into a film in 1954, The Black Shield of Falworth.'),(161,21,'media/stranger-things-happen.pdf','media/stranger-things-happen.pdf','media/ebook.jpg',NULL,'Stranger Things Happen','Kelly Link','This first collection by award-winning author Kelly Link, takes fairy tales and cautionary tales, dictators and extraterrestrials, amnesiacs and honeymooners, revenants and readers alike, on a voyage into new, strange, and wonderful territory. The girl detective must go to the underworld to solve the case of the tap-dancing bank robbers. A librarian falls in love with a girl whose father collects artificial noses. A dead man posts letters home to his estranged wife. Two women named Louise begin a series of consecutive love affairs with a string of cellists. A newly married couple become participants in an apocalyptic beauty pageant. Sexy blond aliens invade New York City. A young girl learns how to make herself disappear.'),(171,21,'media/the-woman-in-white.pdf','media/the-woman-in-white.pdf','media/ebook.jpg',NULL,'The Woman in White','Wilkie Collins','The Woman in White is a novel written by Wilkie Collins in 1859. It is considered to be among the first mystery novels and is widely regarded as one of the first (and finest) in the genre of \'sensation novels\'. The first episode appeared on 29 November 1859, following Charles Dickens\'s own A Tale of Two Cities in Dickens\'s magazine All the Year Round in England, and Harper\'s Magazine in America. It caused an immediate sensation. Julian Symons (in his 1974 introduction to the Penguin edition) reports that \"queues formed outside the offices to buy the next installment. Bonnets, perfumes, waltzes and quadrilles were called by the book\'s title.\"');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_types`
--

DROP TABLE IF EXISTS `media_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Media Type ID',
  `name` varchar(255) NOT NULL COMMENT 'Media Type Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='Media Types';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_types`
--

LOCK TABLES `media_types` WRITE;
/*!40000 ALTER TABLE `media_types` DISABLE KEYS */;
INSERT INTO `media_types` VALUES (1,'Music'),(11,'Video'),(21,'Book');
/*!40000 ALTER TABLE `media_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_event`
--

DROP TABLE IF EXISTS `page_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_event` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `session_id` int(20) NOT NULL,
  `page_name` varchar(25) COLLATE utf8_bin NOT NULL,
  `subject_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `event_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `ts` varchar(30) COLLATE utf8_bin NOT NULL,
  `ts_ms` varchar(15) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `page_event_ibfk_3` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_event`
--

LOCK TABLES `page_event` WRITE;
/*!40000 ALTER TABLE `page_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `page_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `param_hitId` varchar(35) COLLATE utf8_bin NOT NULL,
  `param_workerId` varchar(20) COLLATE utf8_bin NOT NULL,
  `treatment_id` int(20) NOT NULL,
  `pre_info` longtext COLLATE utf8_bin,
  `email_sent` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT 'undef',
  `consent` varchar(5) COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `pre_mturk_id` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'undef',
  `pre_email` varchar(300) COLLATE utf8_bin NOT NULL DEFAULT 'undef',
  `post_info` longtext COLLATE utf8_bin,
  `post_email` varchar(300) COLLATE utf8_bin NOT NULL DEFAULT 'undef',
  `transaction` int(11) NOT NULL DEFAULT '1',
  `group_num` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `treatment_id` (`treatment_id`),
  CONSTRAINT `session_ibfk_1` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `name` varchar(45) NOT NULL,
  `value` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains user-configured settings';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('CURRENT_GROUP','1','2015-05-10 21:58:01');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `treatment`
--

DROP TABLE IF EXISTS `treatment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `treatment` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `group_num` int(11) NOT NULL DEFAULT '0',
  `sequence` int(11) NOT NULL COMMENT 'Order',
  `media_type` int(11) NOT NULL,
  `opt` varchar(3) COLLATE utf8_bin NOT NULL,
  `pre-pop` varchar(10) COLLATE utf8_bin NOT NULL,
  `active` int(1) NOT NULL,
  `description` longtext COLLATE utf8_bin NOT NULL,
  `warning_type` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT 'none',
  `warning_msg` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `TREATMENT_MEDIA_TYPE_idx` (`media_type`),
  CONSTRAINT `TREATMENT_MEDIA_TYPE` FOREIGN KEY (`media_type`) REFERENCES `media_types` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treatment`
--

LOCK TABLES `treatment` WRITE;
/*!40000 ALTER TABLE `treatment` DISABLE KEYS */;
INSERT INTO `treatment` VALUES (1,1,1,1,'in','yes',1,'1','none',''),(11,1,2,1,'out','yes',1,'1','none',''),(21,1,3,1,'in','yes',1,'1','none',''),(31,1,4,1,'out','yes',1,'1','none',''),(41,1,5,11,'in','yes',1,'1','none',''),(51,1,6,11,'out','yes',1,'1','none',''),(61,1,7,11,'in','yes',1,'1','none',''),(71,1,8,11,'out','yes',1,'1','none',''),(81,1,9,21,'in','yes',1,'1','none',''),(91,1,10,21,'out','yes',1,'1','none',''),(101,1,11,21,'in','yes',1,'1','none',''),(111,1,12,21,'out','yes',1,'1','none','');
/*!40000 ALTER TABLE `treatment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `treatment_selections`
--

DROP TABLE IF EXISTS `treatment_selections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `treatment_selections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(20) NOT NULL COMMENT 'Session ID',
  `treatment_id` int(11) NOT NULL,
  `action` tinyint(1) NOT NULL COMMENT 'Action (0 for ''No Thanks'', 1 for Accept-Opt In or Out)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Treatment Selection Data';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treatment_selections`
--

LOCK TABLES `treatment_selections` WRITE;
/*!40000 ALTER TABLE `treatment_selections` DISABLE KEYS */;
/*!40000 ALTER TABLE `treatment_selections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'psueyetstore'
--

--
-- Dumping routines for database 'psueyetstore'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-11 11:49:06
