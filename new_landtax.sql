-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: new_landtax
-- ------------------------------------------------------
-- Server version	5.7.19-log

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
-- Table structure for table `audit_trail`
--

DROP TABLE IF EXISTS `audit_trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `what` varchar(45) DEFAULT NULL,
  `module` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_trail`
--

LOCK TABLES `audit_trail` WRITE;
/*!40000 ALTER TABLE `audit_trail` DISABLE KEYS */;
INSERT INTO `audit_trail` VALUES (1,'itadminpylon','Add','User juan02',NULL,'2020-02-12 06:20:07'),(2,'itadminpylon','Update','User itadminpylon',NULL,'2020-03-02 09:16:32');
/*!40000 ALTER TABLE `audit_trail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barangay`
--

DROP TABLE IF EXISTS `barangay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barangay` (
  `location_barangay_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `barangay_name` varchar(128) NOT NULL,
  `barangay_code` varchar(16) NOT NULL,
  `district_code` varchar(16) NOT NULL,
  PRIMARY KEY (`location_barangay_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barangay`
--

LOCK TABLES `barangay` WRITE;
/*!40000 ALTER TABLE `barangay` DISABLE KEYS */;
INSERT INTO `barangay` VALUES (1,'I-A','01','01'),(2,'I-B','02','01'),(3,'I-C','03','01'),(4,'II-A','04','01'),(5,'II-B','05','01'),(6,'II-C','06','01'),(7,'II-D','07','01'),(8,'II-E','08','01'),(9,'II-F','09','01'),(10,'III-A','010','01'),(11,'III-B','011','01'),(12,'III-C','012','01'),(13,'III-D','013','01'),(14,'III-E','014','01'),(15,'III-F','015','01'),(16,'IV-A','016','01'),(17,'IV-B','017','01'),(18,'IV-C','018','01'),(19,'V-A','019','01'),(20,'V-B','020','01'),(21,'V-C','021','01'),(22,'V-D','022','01'),(23,'VI-A','023','01'),(24,'VI-B','024','01'),(25,'VI-C','025','01'),(26,'VI-D','026','01'),(27,'VI-E','027','01'),(28,'VII-A','028','01'),(29,'VII-B','029','01'),(30,'VII-C','030','01'),(31,'VII-D','031','01'),(32,'VII-E','032','01'),(33,'STA. ANA','033','07'),(34,'STO. ANGEL','034','02'),(35,'SAN ANTONIO I','035','07'),(36,'SAN ANTONIO II','036','07'),(37,'SAN BARTOLOME','037','04'),(38,'BAUTISTA','038','04'),(39,'SAN BUENAVENTURA','039','02'),(40,'STA. CATALINA','040','02'),(41,'CONCEPCION','041','02'),(42,'SAN CRISPIN','042','05'),(43,'STO. CRISTO','043','07'),(44,'SAN CRISTOBAL','044','03'),(45,'STA. CRUZ','045','07'),(46,'DEL REMEDIO','046','05'),(47,'SAN DIEGO','047','02'),(48,'DOLORES','048','02'),(49,'STA. ELENA','049','03'),(50,'STA. FILOMENA','050','05'),(51,'SAN FRANCISCO','051','07'),(52,'SAN GABRIEL','052','06'),(53,'SAN GREGORIO','053','07'),(54,'STA. ISABEL','054','02'),(55,'SAN IGNACIO','055','07'),(56,'SAN ISIDRO','056','07'),(57,'SAN JOAQUIN','057','07'),(58,'SAN JOSE','058','07'),(59,'SAN JUAN','059','05'),(60,'SAN LORENZO','060','02'),(61,'SAN LUCAS I','061','05'),(62,'SAN LUCAS II','062','05'),(63,'SAN MARCOS','063','05'),(64,'STA. MARIA','064','06'),(65,'STA. MA. MAGDALENA','065','05'),(66,'SAN MATEO','066','05'),(67,'SAN MIGUEL','067','06'),(68,'STA. MONICA','068','04'),(69,'SAN NICOLAS','069','05'),(70,'STO. NIÑO','070','03'),(71,'SAN PEDRO','071','02'),(72,'SAN RAFAEL','072','05'),(73,'SAN ROQUE','073','04'),(74,'STO. ROSARIO','074','06'),(75,'SANTIAGO I','075','04'),(76,'SANTIAGO II','076','04'),(77,'SOLEDAD','077','06'),(78,'STA. VERONICA','078','04'),(79,'SAN VICENTE','079','07');
/*!40000 ALTER TABLE `barangay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `building`
--

DROP TABLE IF EXISTS `building`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `building` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building_pin` varchar(45) DEFAULT NULL,
  `assessed_value` varchar(45) DEFAULT NULL,
  `land_id` varchar(45) DEFAULT NULL,
  `tax_dec_no` varchar(45) DEFAULT NULL,
  `last_paid_assessed` varchar(45) DEFAULT NULL,
  `last_payment_assessed` varchar(45) DEFAULT NULL,
  `building_status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `building`
--

LOCK TABLES `building` WRITE;
/*!40000 ALTER TABLE `building` DISABLE KEYS */;
INSERT INTO `building` VALUES (1,'3001','50000.00','1','25-46584','2019',NULL,'TAXABLE'),(2,'4001','350000.00','3','88-55555','2018',NULL,'TAXABLE');
/*!40000 ALTER TABLE `building` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `building_owner`
--

DROP TABLE IF EXISTS `building_owner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `building_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `building_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `building_owner`
--

LOCK TABLES `building_owner` WRITE;
/*!40000 ALTER TABLE `building_owner` DISABLE KEYS */;
INSERT INTO `building_owner` VALUES (1,'Marco Rafael ','Eseo','Tolentino','1'),(2,'Miguel Luigi','Eseo','Tolentino','2');
/*!40000 ALTER TABLE `building_owner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `check_payment`
--

DROP TABLE IF EXISTS `check_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `check_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank` varchar(45) DEFAULT NULL,
  `check_number` varchar(45) DEFAULT NULL,
  `check_amount` varchar(45) DEFAULT NULL,
  `check_date` varchar(45) DEFAULT NULL,
  `or_number` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `check_payment`
--

LOCK TABLES `check_payment` WRITE;
/*!40000 ALTER TABLE `check_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `check_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compromise`
--

DROP TABLE IF EXISTS `compromise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compromise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payor_name` varchar(255) DEFAULT NULL,
  `due_basic` varchar(45) DEFAULT NULL,
  `due_sef` varchar(45) DEFAULT NULL,
  `due_total` varchar(45) DEFAULT NULL,
  `cash_rec` varchar(45) DEFAULT NULL,
  `check_rec` varchar(45) DEFAULT NULL,
  `total_rec` varchar(45) DEFAULT NULL,
  `tax_year` varchar(45) DEFAULT NULL,
  `payment_no` varchar(45) DEFAULT NULL,
  `payment_status` varchar(45) DEFAULT NULL,
  `tax_order_id` varchar(45) DEFAULT NULL,
  `or_pool_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compromise`
--

LOCK TABLES `compromise` WRITE;
/*!40000 ALTER TABLE `compromise` DISABLE KEYS */;
/*!40000 ALTER TABLE `compromise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `land`
--

DROP TABLE IF EXISTS `land`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `land` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pin_city` varchar(45) DEFAULT NULL,
  `pin_district` varchar(45) DEFAULT NULL,
  `pin_barangay` varchar(45) DEFAULT NULL,
  `pin_section` varchar(45) DEFAULT NULL,
  `pin_parcel` varchar(45) DEFAULT NULL,
  `arp_no` varchar(255) DEFAULT NULL,
  `tax_dec_no` varchar(45) DEFAULT NULL,
  `lot_no` varchar(45) DEFAULT NULL,
  `block_no` varchar(45) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  `subdivision` varchar(45) DEFAULT NULL,
  `barangay` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `province` varchar(45) DEFAULT NULL,
  `class` varchar(45) DEFAULT NULL,
  `sub_class` varchar(45) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  `land_use` varchar(45) DEFAULT NULL,
  `assessed_value` varchar(45) DEFAULT NULL,
  `land_status` varchar(45) DEFAULT NULL,
  `last_paid_assessed` varchar(45) DEFAULT NULL,
  `last_payment_assessed` varchar(45) DEFAULT NULL,
  `rpt_year_assessed` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `land`
--

LOCK TABLES `land` WRITE;
/*!40000 ALTER TABLE `land` DISABLE KEYS */;
INSERT INTO `land` VALUES (1,'130','02','041','02','0048',NULL,'88-11871','1','1','','','CONCEPCION','San Pablo','Laguna','RESIDENTIAL','',NULL,NULL,'540000','TAXABLE','2017',NULL,NULL),(2,'130','02','041','02','043',NULL,'88-88888','1','1','','','CONCEPCION','San Pablo','Laguna','RESIDENTIAL','',NULL,NULL,'300000','TAXABLE','2017',NULL,NULL),(3,'130','04','038','02','042',NULL,'11-23541','1','1','','','BAUTISTA','San Pablo','Laguna','RESIDENTIAL','',NULL,NULL,'423000','TAXABLE','2018',NULL,NULL),(4,'130','01','023','02','039',NULL,'11-45321','1','1','','','VI-A','San Pablo','Laguna','RESIDENTIAL','',NULL,NULL,'500000','TAXABLE','2019',NULL,NULL),(5,'130','01','021','002','048',NULL,'45-65821','1','1','','','V-C','San Pablo','Laguna','RESIDENTIAL','',NULL,NULL,'250000.00','TAXABLE','2019',NULL,NULL),(6,'130','07','033','01','0008',NULL,'07-0033-00059','9','25','','','STA. ANA','San Pablo','Laguna','RESIDENTIAL','',NULL,NULL,'500000.00','TAXABLE','2019',NULL,NULL),(7,'130','07','079','123','123',NULL,'123467','','','','228','SAN VICENTE','San Pablo','Laguna','RESIDENTIAL','R-3',NULL,NULL,'108000.00','TAXABLE','2018',NULL,NULL),(8,'130','02','041','01','01',NULL,'132154','','','','','CONCEPCION','San Pablo','Laguna','RESIDENTIAL','',NULL,NULL,'500000.00','TAXABLE','2014',NULL,NULL);
/*!40000 ALTER TABLE `land` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `land_owner`
--

DROP TABLE IF EXISTS `land_owner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `land_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `suffix_name` varchar(45) DEFAULT NULL,
  `land_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `land_owner`
--

LOCK TABLES `land_owner` WRITE;
/*!40000 ALTER TABLE `land_owner` DISABLE KEYS */;
INSERT INTO `land_owner` VALUES (1,'Marco Rafael','Eseo','Tolentino',NULL,'1'),(2,'Miggy ','Eseo','Tolentino',NULL,'1'),(3,'Marco Rafael','Eseo','Tolentino',NULL,'2'),(4,'Joseph ','BonBon','Bonilla',NULL,'3'),(5,'Marco Rafael','Eseo','Tolentino',NULL,'4'),(11,'Joana','K','Manlangit',NULL,'5'),(12,'Juan','Ramos','Dela Cruz',NULL,'6'),(13,'clientako','ni ','marco',NULL,'7'),(14,'Marco Rafael','Eseo','Tolentino',NULL,'8');
/*!40000 ALTER TABLE `land_owner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `or_pool`
--

DROP TABLE IF EXISTS `or_pool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `or_pool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `or_number` varchar(45) DEFAULT NULL,
  `or_date` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `or_pool`
--

LOCK TABLES `or_pool` WRITE;
/*!40000 ALTER TABLE `or_pool` DISABLE KEYS */;
/*!40000 ALTER TABLE `or_pool` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payor_name` varchar(225) DEFAULT NULL,
  `start_date` varchar(45) DEFAULT NULL,
  `due_date` varchar(45) DEFAULT NULL,
  `due_basic` varchar(255) DEFAULT NULL,
  `due_sef` varchar(255) DEFAULT NULL,
  `due_penalty` varchar(255) DEFAULT NULL,
  `due_discount` varchar(255) DEFAULT NULL,
  `due_total` varchar(225) DEFAULT NULL,
  `tax_year` varchar(255) DEFAULT NULL,
  `cash_rec` varchar(255) DEFAULT NULL,
  `check_rec` varchar(255) DEFAULT NULL,
  `total_rec` varchar(255) DEFAULT NULL,
  `payment_no` varchar(45) DEFAULT NULL,
  `payment_status` varchar(45) DEFAULT NULL,
  `tax_order_id` varchar(45) DEFAULT NULL,
  `or_pool_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subdivisions`
--

DROP TABLE IF EXISTS `subdivisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subdivisions` (
  `location_subdivision_id` int(11) NOT NULL AUTO_INCREMENT,
  `subdivision_name` varchar(128) NOT NULL,
  `sub_class` varchar(32) NOT NULL,
  `location_barangay_id` mediumint(9) NOT NULL,
  PRIMARY KEY (`location_subdivision_id`),
  KEY `location_barangay_id` (`location_barangay_id`),
  CONSTRAINT `subdivisions_ibfk_1` FOREIGN KEY (`location_barangay_id`) REFERENCES `location_barangays` (`location_barangay_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subdivisions`
--

LOCK TABLES `subdivisions` WRITE;
/*!40000 ALTER TABLE `subdivisions` DISABLE KEYS */;
INSERT INTO `subdivisions` VALUES (1,'MAGLALANG SUBD.','R-1',2),(2,'RIVERSIDE SUBD.','R-1',2),(3,'ORILLAZA SUBD.','R-1',2),(4,'JUANITO ANGELES','R-1',3),(5,'METROPOLIS','R-1',3),(6,'NHA','R-3',3),(7,'CRISPINA PARK SUBD.','R-1',3),(8,'AZORES COURT SUBD.','R-1',3),(9,'GUADALUPE SUBD.','R-2',4),(10,'GUADALUPE SUBD.','R-2',5),(11,'VILLA ANTONIO SUBD.','R-2',9),(12,'ALCANTARA SUBD.','R-1',13),(13,'VESCO SUBD.','R-1',14),(14,'LOZADA SUBD.','R-1',14),(15,'EFARCA VILLAGE','R-1',16),(16,'NEFORTVILLE','R-1',26),(17,'LAKESIDE PARK SUBD.','R-1',26),(18,'POOK KASIYAHAN','R-1',26),(19,'STA ANA HOMES','R-2',33),(20,'DIONISIO ELOMINA','R-3(3-C)',33),(21,'IRENEO REYES','R-3(3-C)',33),(22,'JOSELITO YAP','R-3(3-C)',33),(23,'JESUSA, MANILO & DIANA AZORES','R-3',34),(24,'NHA','R-3',34),(25,'JEANSVILLE (JEAN MALICSI)','R-3(3-C)',34),(26,'ANGELITO TICZON','R-3(3-C)',34),(27,'SOLITA TICZON','R-3(3-C)',34),(28,'JOCELYN CORTEZ','R-3(3-C)',35),(29,'ROSALINDA CORTEZ','R-3(3-C)',35),(30,'ISRAEL BUILDERS','R-3',35),(31,'DR. WILLIE CORTEZ','R-3(3-C)',35),(32,'ROLANDO FULE','R-3(3-C)',35),(33,'JULIA CORTEZ','R-3(3-C)',35),(34,'EDGARDO & ELIZA GAMO','R-3(3-C)',35),(35,'ALFONSO FARCON','R-3',36),(36,'TERESITA ANINGALAN','R-3(3-C)',37),(37,'ROWENA DELA CRUZ','R-3(3-C)',37),(38,'MONICO FLORES & ANITA PANERGAYO','R-3(3-C)',37),(39,'JUANITO GERARD BANAAD','R-3(3-C)',37),(40,'RENE, MARIO & SARI BRION','R-3',38),(41,'IMPERIAL HOMES CORP.','R-2',39),(42,'EMPEMANO CPD','R-3',39),(43,'SOLITA TICZON','R-3(3-C)',40),(44,'CRISANTO & CORAZON VILLAMIN','R-2',41),(45,'SANTIAGO RAMOS','R-3',41),(46,'TROPICAL PARK SUBD.','R-3',41),(47,'IMACULADA CONCEPCION','R-2',41),(48,'JEAN MALICSI','R-3(3-C)',41),(49,'DOÑA EUSEBIA SUBD.','R-2',41),(50,'SAMPALOC LAKE COURT SUBD.','R-2',41),(51,'POPE PIOUS SUBD.','R-2',41),(52,'CLIFFVIEW','R-1',41),(53,'MARIA GLORIA ABRIL','R-3(3-C)',41),(54,'MUNOZ CPD','R-3(3-C)',41),(55,'MERCEDES ESGUERRA','R-3(3-C)',41),(56,'ZACARIAS TOLENTINO/SEVERINO VILLAMAYOR','R-3(3-C)',41),(57,'ANA FAJARDO','R-3(3-C)',41),(58,'LAKEVIEW SUBDIVISION','R-2',41),(59,'ARMANDO BONDAD','R-3(3-C)',42),(60,'ANNI CARANDANG','R-3(3-C)',42),(61,'ST. MATHEW','R-2',42),(62,'MAGCASEVILLE','R-2',43),(63,'JAIME DILAG','R-3(3-C)',43),(64,'VALBUENA SUBD.','R-2',43),(65,'VILLA ROMANA','R-3',44),(66,'ARCADA GAPANGADA','R-3(3-C)',44),(67,'VENUS AVANZADO','R-3(3-C)',44),(68,'RUFINO ANDAL','R-2',46),(69,'PATRIA VILLAGE','R-2',46),(70,'ADB SUBD.','R-2',46),(71,'PAMELA PARK SUBD','R-2',46),(72,'STA. BARBARA','R-3',46),(73,'GUTIERREZ SUBD.','R-3(3-C)',46),(74,'LEONILA PARK SUBD.','R-2',46),(75,'DOÃA EUSEBIA SUBD.','R-2',46),(76,'SAMAHANG ANAK BAYAN','R-3',46),(77,'RUEL DE LOS REYES','R-3(3-C)',46),(78,'COCOLAND VILLAGE','R-1',46),(79,'ASHLEY COMPOUND','R-3(3-C)',46),(80,'MARIFLOR SUBD.','R-2',46),(81,'CARDIL VILLAGE','R-2',46),(82,'GUEVARRA SUBD.','R-2',46),(83,'ANNA MARIE GONDA','R-3(3-C)',46),(84,'ANTONIO AGUILAR','R-3',46),(85,'RAFAEL DEQUINA','R-3(3-C)',46),(86,'ROMMEL REYES','R-3(3-C)',47),(87,'SANTIAGO RAMOS','R-3(3-C)',47),(88,'LILY ILAW','R-3(3-C)',47),(89,'LEONISE & RICARDO KALAW','R-3(3-C)',47),(90,'MONTELAGO','R-1',49),(91,'LUCAS ALVERO','R-3(3-C)',49),(92,'VINTAGE ORCHARD INC.','R-3(3-C)',49),(93,'JAIME DILAG','R-2',51),(94,'SAN FRANCISCO TERRACE','R-2',51),(95,'GREEN VALLEY SUBD','R-2',51),(96,'RICHWOOD PARK SUBD.','R-1',51),(97,'BAÃAGALE SUBD.','R-2',51),(98,'MEDEX SUBD.','R-2',51),(99,'MAHARLIKA SUBD.','R-1',51),(100,'MARY HELP SUBD.','R-2',51),(101,'FARCONVILLE SUBD.','R-2',51),(102,'ST. FRANCIS SUBD.','R-2',51),(103,'TOWN AND COUNTRY SUBD.','R-2',51),(104,'KINGS ROW SUBD.','R-3',51),(105,'MANHATTAN SUBD.','R-1',51),(106,'MANUEL SY','R-3(3-C)',51),(107,'CRISJORVILLE','R-2',51),(108,'CARINA & CONCEPCION TUAZON','R-2',51),(109,'ABBET REALTY','R-2',51),(110,'SONIA BAUTISTA','R-3(3-C)',51),(111,'MARGARITO TICZON','R-3(3-C)',51),(112,'TEOMORA SUBD.','R-1',52),(113,'METROPOLIS SUBD.','R-1',52),(114,'DIOSCORO ESMERA','R-3(3-C)',52),(115,'LIZA PAGTAKHAN','R-3(3-C)',52),(116,'DANILO DAYAN','R-3(3-C)',52),(117,'MANHATTAN SUBD.','R-1',53),(118,'SAN GREGORIO HOMES','R-2',53),(119,'ROGELIO DIVINAGRACIA','R-2',53),(120,'LILIA DILAG','R-3(3-C)',53),(121,'MEDY ALGENIO','R-2',53),(122,'CORAZON MARINO','R-2',53),(123,'ROSARIO BUNCAYO','R-3',54),(124,'CECILIA COSICO & MERCEDES GUIA','R-3',54),(125,'MAXIMO GALVEZ','R-3(3-C)',54),(126,'DIOSCORO ESMENA','R-3(3-C)',54),(127,'ARIZANDRO ESMENA','R-3(3-C)',54),(128,'ISABEL TICZON','R-3(3-C)',56),(129,'ISIDRO ANINGALAN','R-3(3-C)',56),(130,'PAUL TEODORE STALDEN','R-3(3-C)',56),(131,'RENMAR SUBD.','R-2',55),(132,'EL REY REALTY INC.','R-3',55),(133,'EL COCO GRANDE','R-2',55),(134,'DANILO DEVEZA','R-3(3-C)',55),(135,'EMELITA AVANZADO','R-3(3-C)',55),(136,'IRENEO MUÃOZ','R-3(3-C)',55),(137,'RACHEL EVANGELISTA','R-3(3-C)',55),(138,'FANNY CALAYAG','R-3(3-C)',55),(139,'ARANVILLE SUBD.','R-1',58),(140,'NHA','R-3',58),(141,'STARVILLE','R-2',58),(142,'GABRIEL TIMOTHY','R-3',58),(143,'MACARIO MONTEJO','R-3(3-C)',58),(144,'RUENA JUMADIAO','R-3(3-C)',58),(145,'ST. JOHN SUBD.','R-3',59),(146,'CRESENCIA AVORQUE','R-3(3-C)',59),(147,'LEOPOLDO BELEN','R-3(3-C)',59),(148,'DIOSCORO ESMENA','R-3(3-C)',57),(149,'EDWIN CALAMPIANO','R-3(3-C)',57),(150,'VIRGINIA RUBIALES','R-3(3-C)',57),(151,'GONZALO ALIMAGNO','R-3(3-C)',57),(152,'CREEKSIDE SUBD.','R-2',61),(153,'ELEUTERIO CORTEZ','R-3',61),(154,'MARIÃO SUBD.','R-2',61),(155,'ENEIDA RAMOS','R-3(3-C)',61),(156,'APB REALTY CORP.','R-2',61),(157,'SOFRONIO AVENIDO','R-2',61),(158,'RAMOS CPD','R-3',61),(159,'LUZ CORDERO','R-3',61),(160,'EUGENIO CORDERO','R-2',61),(161,'CARIDAD SORIANO','R-3(3-C)',60),(162,'EMMANUEL TICZON','R-3(3-C)',60),(163,'MERALCO SUBD.','R-2',62),(164,'C.G. BRION SUBD.','R-2',62),(165,'RUBY REYES','R-3(3-C)',62),(166,'EUGENIO CORDERO','R-3',62),(167,'SOFRONIO AVENIDO','R-2',62),(168,'CONRADO BRION','R-2',62),(169,'CARMELITA LAROZA','R-3(3-C)',62),(170,'NATIVIDAD DUYAC','R-3(3-C)',62),(171,'TEODORO DE LOS REYES','R-3(3-C)',63),(172,'CRISANTO DELOS REYES','R-3(3-C)',63),(173,'COCOVILLA SUBD.','R-3',67),(174,'EMMANUEL TICZON','R-3(3-C)',67),(175,'RURAL BANK OF RIZAL','R-3(3-C)',67),(176,'PHILIP ESTIVA','R-3(3-C)',67),(177,'MANUEL DELGADO','R-3(3-C)',68),(178,'LAURO & AMADO COSICO','R-2',68),(179,'ERLINDA DIOSO','R-3(3-C)',68),(180,'PATRICIA AGRA','R-3(3-C)',68),(181,'EVELYN ALINIOS','R-3(3-C)',68),(182,'LYNVILLE REALTY','R-2',68),(183,'CESAR FULE','R-3(3-C)',68),(184,'SOFRONIO EXCONDE','R-3(3-C)',68),(185,'AARON MEDALLA','R-3(3-C)',68),(186,'ROSITA LEONOR BUNO','R-3(3-C)',68),(187,'POLICARPIO BUNYI','R-3(3-C)',68),(188,'EMMA BICOMONG','R-3(3-C)',68),(189,'PILAR GONZALVO','R-3(3-C)',64),(190,'EMMANUEL TICZON','R-3(3-C)',64),(191,'LOLITA ISIP','R-3(3-C)',65),(192,'CLAPSON REALTY & DEV\'T CORP.','R-3',69),(193,'HERMINIGILDO DEVEZA','R-3(3-C)',69),(194,'LEONCIO MACAHIYA','R-3(3-C)',69),(195,'NENA MALLARI','R-3(3-C)',69),(196,'ROMEO DIZON','R-3(3-C)',69),(197,'HERMINIGILDO DEVEZA','R-3(3-C)',69),(198,'ESTER DIZON','R-3(3-C)',69),(199,'RODRIGO SUPENA','R-3(3-C)',69),(200,'BUESER CPD','R-3(3-C)',75),(201,'MELICIO BALITAAN','R-3(3-C)',76),(202,'SERGIO GESMUNDO','R-3(3-C)',76),(203,'ALCARAZ SUBD.','R-3',70),(204,'OPEN DOOR SUBD.','R-3',70),(205,'STO. NIÃO HOMES','R-2',70),(206,'BUNCAYO SUBD.','R-3',70),(207,'STO. NINO NURPA HOMEOWNERS ASSOCIATION','R-3',70),(208,'CLARITO TICZON','R-3(3-C)',70),(209,'MA. CELESTE TICZON','R-3(3-C)',70),(210,'EDUARDO PALIS','R-3(3-C)',70),(211,'LUISA GUTIERREZ','R-3(3-C)',71),(212,'RIVERINA','R-1',72),(213,'LAUREL VILLAGE','R-2',72),(214,'JOEL TOWN VILLAGE','R-2',72),(215,'TEACHER\'S VILLAGE','R-2',72),(216,'COCOLAND SUBD.','R-1',72),(217,'PEÃAFRANCIA SUBD.','R-2',72),(218,'ALIJANDRO YU','R-2',72),(219,'COCOLAND SUBD.','R-1',73),(220,'BUNCAYO PARK SUBD.','R-2',73),(221,'SOUTHEAST MEADOW SUBD.','R-2',73),(222,'BLACKBALL CORP.','R-3',73),(223,'RUFINO VILLAGE','R-3',73),(224,'BENITO GAW & JEFFREY GAW','R-2',77),(225,'LEOPOLIO ARANGUREN','R-2',77),(226,'VIOLETA CARENCIA','R-3(3-C)',77),(227,'DR. CESAR FULE','R-3(3-C)',78),(228,'MARYLAND SUBD.','R-3',79),(229,'ALFONSO FARCON','R-3(3-C)',79),(230,'IRENE DALENA','R-3(3-C)',79),(231,'LOURDES ALIMARIO','R-3(3-C)',74),(232,'NENITA BRUTO','R-3(3-C)',74),(233,'LUCENA PASCO','R-3(3-C)',74),(234,'RUFINA YAP','R-3(3-C)',74),(235,'MELCHOR MENDOZA','R-3(3-C)',74);
/*!40000 ALTER TABLE `subdivisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_clearance_payment`
--

DROP TABLE IF EXISTS `tax_clearance_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tax_clearance_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `land_id` varchar(45) DEFAULT NULL,
  `payor_name` varchar(255) DEFAULT NULL,
  `payment` varchar(225) DEFAULT NULL,
  `print` varchar(45) DEFAULT NULL,
  `or_pool_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_clearance_payment`
--

LOCK TABLES `tax_clearance_payment` WRITE;
/*!40000 ALTER TABLE `tax_clearance_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_clearance_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_order`
--

DROP TABLE IF EXISTS `tax_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tax_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `basic` varchar(255) DEFAULT NULL,
  `sef` varchar(255) DEFAULT NULL,
  `garbage_fee` varchar(255) DEFAULT NULL,
  `penalty` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `total` varchar(45) DEFAULT NULL,
  `balance` varchar(45) DEFAULT NULL,
  `mode_of_payment` varchar(45) DEFAULT NULL,
  `year_assessed` varchar(45) DEFAULT NULL,
  `year_of_effectivity` varchar(45) DEFAULT NULL,
  `payment_status` varchar(45) DEFAULT NULL,
  `land_id` varchar(45) DEFAULT NULL,
  `building_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_order`
--

LOCK TABLES `tax_order` WRITE;
/*!40000 ALTER TABLE `tax_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `suffix_name` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'itadminpylon','123pasok','Mcoy','E','Tolentino','',NULL,'0999338867','Admin'),(2,'landtaxemp1','emp123','Joseph','Estayan','Bonilla','',NULL,'0999338867','Employee'),(3,'juan02','mypassword','Juan','Ramos','Dela Cruz','',NULL,'09754119392','Employee');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-17  9:07:57
