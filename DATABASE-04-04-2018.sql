/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.39-cll-lve : Database - imprecof_fact
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`imprecof_fact` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `imprecof_fact`;

/*Table structure for table `antecedente` */

DROP TABLE IF EXISTS `antecedente`;

CREATE TABLE `antecedente` (
  `id_antecedente` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id del antecedente',
  `nombre` varchar(65) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del antecedente',
  `yn_activo` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'EAactivo(1: Si; 2: No)',
  PRIMARY KEY (`id_antecedente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `antecedente` */

/*Table structure for table `auditoria` */

DROP TABLE IF EXISTS `auditoria`;

CREATE TABLE `auditoria` (
  `id_auditoria` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id de la auditoría',
  `id_usuario` int(11) unsigned NOT NULL COMMENT 'Id del usuario',
  `direccion_ip` varchar(65) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Dirección ip',
  `instruccion` smallint(1) unsigned NOT NULL COMMENT 'EInstruccion(1: Insert; 2: Update; 3: Delete; Replace)',
  `nombre_tabla` varchar(65) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre tabla',
  `id_registro` int(11) unsigned DEFAULT NULL COMMENT 'Id del registro tabla',
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción de la auditoría',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro',
  PRIMARY KEY (`id_auditoria`),
  KEY `id_usuario_auditoria_idx` (`id_usuario`),
  CONSTRAINT `id_usuario_auditoria_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auditoria` */

insert  into `auditoria`(`id_auditoria`,`id_usuario`,`direccion_ip`,`instruccion`,`nombre_tabla`,`id_registro`,`descripcion`,`fecha_registro`) values (1,1,'190.240.28.144',2,'persona',2,'Update persona data:array (\n  \'email\' => \'oscar.carvajal@imprecof.com\',\n  \'movil\' => \'3303215655\',\n  \'genero\' => \'2\',\n  \'barrio\' => NULL,\n  \'telefono\' => NULL,\n  \'direccion\' => NULL,\n  \'foto_perfil\' => \'12135815646.jpg\',\n  \'primer_nombre\' => \'OSCAR\',\n  \'segundo_nombre\' => \'IVAN\',\n  \'primer_apellido\' => \'CARVAJAL\',\n  \'segundo_apellido\' => \'MANCILLA\',\n  \'fecha_nacimiento\' => \'2018-01-17\',\n  \'tipo_identificacion\' => \'2\',\n  \'ciudad\' => NULL,\n  \'numero_identificacion\' => \'12135815646\',\n)','2018-04-03 06:27:00'),(2,1,'190.240.28.144',3,'rh_representante_cargo',1,'Delete rh_representante_cargo data:row(1)','2018-04-03 06:27:00'),(3,1,'190.240.28.144',1,'rh_representante_cargo',NULL,'Insert rh_representante_cargo data:array (\n  \'id_representante\' => \'1\',\n  \'id_cargo\' => \'6\',\n  \'yn_Activo\' => 1,\n)','2018-04-03 06:27:00'),(4,1,'190.240.28.144',1,'rh_representante_cargo',NULL,'Insert rh_representante_cargo data:array (\n  \'id_representante\' => \'1\',\n  \'id_cargo\' => \'7\',\n  \'yn_Activo\' => 1,\n)','2018-04-03 06:27:00'),(5,1,'170.80.9.51',1,'equipo_marca',1,'Insert equipo_marca data:array (\n  \'nombre\' => \'RICOH\',\n)','2018-04-04 15:54:40'),(6,1,'170.80.9.51',1,'equipo_modelo',1,'Insert equipo_modelo data:array (\n  \'id_marca\' => \'1\',\n  \'descripcion\' => NULL,\n  \'modelo\' => \'RICOH  2551\',\n  \'estilo\' => \'2\',\n  \'tipo\' => \'2\',\n  \'fecha_registro\' => \'2018-04-04 17:54:40\',\n)','2018-04-04 15:54:40'),(7,1,'170.80.9.51',1,'equipo',1,'Insert equipo data:array (\n  \'contador_inicial_scanner\' => \'1\',\n  \'contador_inicial_copia\' => \'1\',\n  \'serial_equipo\' => \'V9824900737\',\n  \'descripcion\' => NULL,\n  \'id_modelo\' => \'1\',\n  \'estado\' => \'1\',\n  \'id_usuario_registro\' => \'1\',\n  \'fecha_registro\' => \'2018-04-04 17:55:12\',\n)','2018-04-04 15:55:12'),(8,1,'170.80.9.51',1,'ciudad',2,'Insert ciudad data:array (\n  \'nombre_ciudad\' => \'BARRANCABERMEJA\',\n)','2018-04-04 16:03:06'),(9,1,'170.80.9.51',1,'cliente',1,'Insert cliente data:array (\n  \'id_ciudad\' => \'2\',\n  \'nombre_empresa\' => \'UNION TEMPORAL OBTC COLOMBIA\',\n  \'razon_social\' => \'UNION TEMPORAL OBTC COLOMBIA\',\n  \'nit\' => \'900.656.467-6\',\n  \'telefono\' => \'6113963\',\n  \'movil\' => \'3165269490\',\n  \'email\' => \'manuel@obtc.com\',\n  \'tipo_cliente\' => \'2\',\n  \'observacion\' => NULL,\n  \'contacto\' => \'Manuel \',\n  \'direcion\' => \'CALLE 73 # 29 - 50\',\n  \'descuento_scanner\' => NULL,\n  \'yn_activo\' => 1,\n  \'id_usuario_registro\' => \'1\',\n  \'fecha_registro\' => \'2018-04-04 18:03:06\',\n)','2018-04-04 16:03:06'),(10,1,'170.80.9.51',1,'cliente_sede',1,'Insert cliente_sede data:array (\n  \'id_cliente\' => \'1\',\n  \'nombre\' => \'Principal\',\n  \'direccion\' => \'\',\n  \'telefono\' => \'\',\n)','2018-04-04 16:03:06'),(11,1,'170.80.9.51',2,'equipo',1,'Update equipo data:array (\n  \'contador_inicial_scanner\' => \'1\',\n  \'contador_inicial_copia\' => \'1\',\n  \'serial_equipo\' => \'V9824900737\',\n  \'descripcion\' => NULL,\n  \'id_modelo\' => \'1\',\n  \'estado\' => \'2\',\n  \'id_usuario_modifica\' => \'1\',\n  \'fecha_modificacion\' => \'2018-04-04 18:03:38\',\n)','2018-04-04 16:03:38'),(12,1,'170.80.9.51',2,'equipo',1,'Update equipo data:array (\n  \'contador_inicial_scanner\' => \'1\',\n  \'contador_inicial_copia\' => \'1\',\n  \'serial_equipo\' => \'V9824900737\',\n  \'descripcion\' => NULL,\n  \'id_modelo\' => \'1\',\n  \'estado\' => \'1\',\n  \'id_usuario_modifica\' => \'1\',\n  \'fecha_modificacion\' => \'2018-04-04 18:04:45\',\n)','2018-04-04 16:04:45');

/*Table structure for table `ciudad` */

DROP TABLE IF EXISTS `ciudad`;

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id de la ciudad',
  `nombre_ciudad` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre ciudad',
  PRIMARY KEY (`id_ciudad`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ciudad` */

insert  into `ciudad`(`id_ciudad`,`nombre_ciudad`) values (1,'prueba'),(2,'BARRANCABERMEJA');

/*Table structure for table `clase` */

DROP TABLE IF EXISTS `clase`;

CREATE TABLE `clase` (
  `id_clase` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id de la tabla',
  `id_representante` int(11) unsigned NOT NULL COMMENT 'id del representante',
  `nombre` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'nombre de la clase',
  `cupo` smallint(2) unsigned NOT NULL DEFAULT '2' COMMENT 'cupo maximo de personas en la clase',
  `hora_inicio` time NOT NULL COMMENT 'hora de inicio',
  `hora_fin` time NOT NULL COMMENT 'hora fin',
  `yn_activo` smallint(1) DEFAULT '1' COMMENT 'EsiNo( 1:si; 2:no)',
  `fecha_registro` datetime NOT NULL COMMENT 'fecha de creacion de la clase',
  `fecha_modificacion` datetime DEFAULT NULL COMMENT 'fecha de modificacion',
  PRIMARY KEY (`id_clase`),
  KEY `id_representante_clase_idx` (`id_representante`),
  CONSTRAINT `id_representante_clase_fk` FOREIGN KEY (`id_representante`) REFERENCES `rh_representante` (`id_representante`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `clase` */

/*Table structure for table `clase_dia` */

DROP TABLE IF EXISTS `clase_dia`;

CREATE TABLE `clase_dia` (
  `id_clase_dia` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id de la tabla',
  `id_clase` int(11) unsigned NOT NULL COMMENT 'id de la clase',
  `dia` smallint(1) DEFAULT NULL COMMENT 'EDiasSemana()',
  PRIMARY KEY (`id_clase_dia`),
  KEY `id_clase_dia_idx` (`id_clase`),
  CONSTRAINT `id_clase_dia_fk` FOREIGN KEY (`id_clase`) REFERENCES `clase` (`id_clase`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `clase_dia` */

/*Table structure for table `class_icon` */

DROP TABLE IF EXISTS `class_icon`;

CREATE TABLE `class_icon` (
  `id_class` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(45) NOT NULL,
  PRIMARY KEY (`id_class`)
) ENGINE=InnoDB AUTO_INCREMENT=978 DEFAULT CHARSET=utf8;

/*Data for the table `class_icon` */

insert  into `class_icon`(`id_class`,`class`) values (1,'fa fa-address-book'),(2,'fa fa-address-book-o'),(3,'fa fa-address-card'),(4,'fa fa-address-card-o'),(5,'fa fa-bandcamp'),(6,'fa fa-bath'),(7,'fa fa-bathtub'),(8,'fa fa-drivers-license'),(9,'fa fa-drivers-license-o'),(10,'fa fa-eercast'),(11,'fa fa-envelope-open'),(12,'fa fa-envelope-open-o'),(13,'fa fa-etsy'),(14,'fa fa-free-code-camp'),(15,'fa fa-grav'),(16,'fa fa-handshake-o'),(17,'fa fa-id-badge'),(18,'fa fa-id-card'),(19,'fa fa-id-card-o'),(20,'fa fa-imdb'),(21,'fa fa-linode'),(22,'fa fa-meetup'),(23,'fa fa-microchip'),(24,'fa fa-podcast'),(25,'fa fa-quora'),(26,'fa fa-ravelry'),(27,'fa fa-s15'),(28,'fa fa-shower'),(29,'fa fa-snowflake-o'),(30,'fa fa-superpowers'),(31,'fa fa-telegram'),(32,'fa fa-thermometer'),(33,'fa fa-thermometer-0'),(34,'fa fa-thermometer-1'),(35,'fa fa-thermometer-2'),(36,'fa fa-thermometer-3'),(37,'fa fa-thermometer-4'),(38,'fa fa-thermometer-empty'),(39,'fa fa-thermometer-full'),(40,'fa fa-thermometer-half'),(41,'fa fa-thermometer-quarter'),(42,'fa fa-thermometer-three-quarters'),(43,'fa fa-times-rectangle'),(44,'fa fa-times-rectangle-o'),(45,'fa fa-user-circle'),(46,'fa fa-user-circle-o'),(47,'fa fa-user-o'),(48,'fa fa-vcard'),(49,'fa fa-vcard-o'),(50,'fa fa-window-close'),(51,'fa fa-window-close-o'),(52,'fa fa-window-maximize'),(53,'fa fa-window-minimize'),(54,'fa fa-window-restore'),(55,'fa fa-wpexplorer'),(56,'fa fa-address-book'),(57,'fa fa-address-book-o'),(58,'fa fa-address-card'),(59,'fa fa-address-card-o'),(60,'fa fa-adjust'),(61,'fa fa-american-sign-language-interpreting'),(62,'fa fa-anchor'),(63,'fa fa-archive'),(64,'fa fa-area-chart'),(65,'fa fa-arrows'),(66,'fa fa-arrows-h'),(67,'fa fa-arrows-v'),(68,'fa fa-asl-interpreting'),(69,'fa fa-assistive-listening-systems'),(70,'fa fa-asterisk'),(71,'fa fa-at'),(72,'fa fa-audio-description'),(73,'fa fa-automobile'),(74,'fa fa-balance-scale'),(75,'fa fa-ban'),(76,'fa fa-bank'),(77,'fa fa-bar-chart'),(78,'fa fa-bar-chart-o'),(79,'fa fa-barcode'),(80,'fa fa-bars'),(81,'fa fa-bath'),(82,'fa fa-bathtub'),(83,'fa fa-battery'),(84,'fa fa-battery-0'),(85,'fa fa-battery-1'),(86,'fa fa-battery-2'),(87,'fa fa-battery-3'),(88,'fa fa-battery-4'),(89,'fa fa-battery-empty'),(90,'fa fa-battery-full'),(91,'fa fa-battery-half'),(92,'fa fa-battery-quarter'),(93,'fa fa-battery-three-quarters'),(94,'fa fa-bed'),(95,'fa fa-beer'),(96,'fa fa-bell'),(97,'fa fa-bell-o'),(98,'fa fa-bell-slash'),(99,'fa fa-bell-slash-o'),(100,'fa fa-bicycle'),(101,'fa fa-binoculars'),(102,'fa fa-birthday-cake'),(103,'fa fa-blind'),(104,'fa fa-bluetooth'),(105,'fa fa-bluetooth-b'),(106,'fa fa-bolt'),(107,'fa fa-bomb'),(108,'fa fa-book'),(109,'fa fa-bookmark'),(110,'fa fa-bookmark-o'),(111,'fa fa-braille'),(112,'fa fa-briefcase'),(113,'fa fa-bug'),(114,'fa fa-building'),(115,'fa fa-building-o'),(116,'fa fa-bullhorn'),(117,'fa fa-bullseye'),(118,'fa fa-bus'),(119,'fa fa-cab'),(120,'fa fa-calculator'),(121,'fa fa-calendar'),(122,'fa fa-calendar-check-o'),(123,'fa fa-calendar-minus-o'),(124,'fa fa-calendar-o'),(125,'fa fa-calendar-plus-o'),(126,'fa fa-calendar-times-o'),(127,'fa fa-camera'),(128,'fa fa-camera-retro'),(129,'fa fa-car'),(130,'fa fa-caret-square-o-down'),(131,'fa fa-caret-square-o-left'),(132,'fa fa-caret-square-o-right'),(133,'fa fa-caret-square-o-up'),(134,'fa fa-cart-arrow-down'),(135,'fa fa-cart-plus'),(136,'fa fa-cc'),(137,'fa fa-certificate'),(138,'fa fa-check'),(139,'fa fa-check-circle'),(140,'fa fa-check-circle-o'),(141,'fa fa-check-square'),(142,'fa fa-check-square-o'),(143,'fa fa-child'),(144,'fa fa-circle'),(145,'fa fa-circle-o'),(146,'fa fa-circle-o-notch'),(147,'fa fa-circle-thin'),(148,'fa fa-clock-o'),(149,'fa fa-clone'),(150,'fa fa-close'),(151,'fa fa-cloud'),(152,'fa fa-cloud-download'),(153,'fa fa-cloud-upload'),(154,'fa fa-code'),(155,'fa fa-code-fork'),(156,'fa fa-coffee'),(157,'fa fa-cog'),(158,'fa fa-cogs'),(159,'fa fa-comment'),(160,'fa fa-comment-o'),(161,'fa fa-commenting'),(162,'fa fa-commenting-o'),(163,'fa fa-comments'),(164,'fa fa-comments-o'),(165,'fa fa-compass'),(166,'fa fa-copyright'),(167,'fa fa-creative-commons'),(168,'fa fa-credit-card'),(169,'fa fa-credit-card-alt'),(170,'fa fa-crop'),(171,'fa fa-crosshairs'),(172,'fa fa-cube'),(173,'fa fa-cubes'),(174,'fa fa-cutlery'),(175,'fa fa-dashboard'),(176,'fa fa-database'),(177,'fa fa-deaf'),(178,'fa fa-deafness'),(179,'fa fa-desktop'),(180,'fa fa-diamond'),(181,'fa fa-dot-circle-o'),(182,'fa fa-download'),(183,'fa fa-drivers-license'),(184,'fa fa-drivers-license-o'),(185,'fa fa-edit'),(186,'fa fa-ellipsis-h'),(187,'fa fa-ellipsis-v'),(188,'fa fa-envelope'),(189,'fa fa-envelope-o'),(190,'fa fa-envelope-open'),(191,'fa fa-envelope-open-o'),(192,'fa fa-envelope-square'),(193,'fa fa-eraser'),(194,'fa fa-exchange'),(195,'fa fa-exclamation'),(196,'fa fa-exclamation-circle'),(197,'fa fa-exclamation-triangle'),(198,'fa fa-external-link'),(199,'fa fa-external-link-square'),(200,'fa fa-eye'),(201,'fa fa-eye-slash'),(202,'fa fa-eyedropper'),(203,'fa fa-fax'),(204,'fa fa-feed'),(205,'fa fa-female'),(206,'fa fa-fighter-jet'),(207,'fa fa-file-archive-o'),(208,'fa fa-file-audio-o'),(209,'fa fa-file-code-o'),(210,'fa fa-file-excel-o'),(211,'fa fa-file-image-o'),(212,'fa fa-file-movie-o'),(213,'fa fa-file-pdf-o'),(214,'fa fa-file-photo-o'),(215,'fa fa-file-picture-o'),(216,'fa fa-file-powerpoint-o'),(217,'fa fa-file-sound-o'),(218,'fa fa-file-video-o'),(219,'fa fa-file-word-o'),(220,'fa fa-file-zip-o'),(221,'fa fa-film'),(222,'fa fa-filter'),(223,'fa fa-fire'),(224,'fa fa-fire-extinguisher'),(225,'fa fa-flag'),(226,'fa fa-flag-checkered'),(227,'fa fa-flag-o'),(228,'fa fa-flash'),(229,'fa fa-flask'),(230,'fa fa-folder'),(231,'fa fa-folder-o'),(232,'fa fa-folder-open'),(233,'fa fa-folder-open-o'),(234,'fa fa-frown-o'),(235,'fa fa-futbol-o'),(236,'fa fa-gamepad'),(237,'fa fa-gavel'),(238,'fa fa-gear'),(239,'fa fa-gears'),(240,'fa fa-gift'),(241,'fa fa-glass'),(242,'fa fa-globe'),(243,'fa fa-graduation-cap'),(244,'fa fa-group'),(245,'fa fa-hand-grab-o'),(246,'fa fa-hand-lizard-o'),(247,'fa fa-hand-paper-o'),(248,'fa fa-hand-peace-o'),(249,'fa fa-hand-pointer-o'),(250,'fa fa-hand-rock-o'),(251,'fa fa-hand-scissors-o'),(252,'fa fa-hand-spock-o'),(253,'fa fa-hand-stop-o'),(254,'fa fa-handshake-o'),(255,'fa fa-hard-of-hearing'),(256,'fa fa-hashtag'),(257,'fa fa-hdd-o'),(258,'fa fa-headphones'),(259,'fa fa-heart'),(260,'fa fa-heart-o'),(261,'fa fa-heartbeat'),(262,'fa fa-history'),(263,'fa fa-home'),(264,'fa fa-hotel'),(265,'fa fa-hourglass'),(266,'fa fa-hourglass-1'),(267,'fa fa-hourglass-2'),(268,'fa fa-hourglass-3'),(269,'fa fa-hourglass-end'),(270,'fa fa-hourglass-half'),(271,'fa fa-hourglass-o'),(272,'fa fa-hourglass-start'),(273,'fa fa-i-cursor'),(274,'fa fa-id-badge'),(275,'fa fa-id-card'),(276,'fa fa-id-card-o'),(277,'fa fa-image'),(278,'fa fa-inbox'),(279,'fa fa-industry'),(280,'fa fa-info'),(281,'fa fa-info-circle'),(282,'fa fa-institution'),(283,'fa fa-key'),(284,'fa fa-keyboard-o'),(285,'fa fa-language'),(286,'fa fa-laptop'),(287,'fa fa-leaf'),(288,'fa fa-legal'),(289,'fa fa-lemon-o'),(290,'fa fa-level-down'),(291,'fa fa-level-up'),(292,'fa fa-life-bouy'),(293,'fa fa-life-buoy'),(294,'fa fa-life-ring'),(295,'fa fa-life-saver'),(296,'fa fa-lightbulb-o'),(297,'fa fa-line-chart'),(298,'fa fa-location-arrow'),(299,'fa fa-lock'),(300,'fa fa-low-vision'),(301,'fa fa-magic'),(302,'fa fa-magnet'),(303,'fa fa-mail-forward'),(304,'fa fa-mail-reply'),(305,'fa fa-mail-reply-all'),(306,'fa fa-male'),(307,'fa fa-map'),(308,'fa fa-map-marker'),(309,'fa fa-map-o'),(310,'fa fa-map-pin'),(311,'fa fa-map-signs'),(312,'fa fa-meh-o'),(313,'fa fa-microchip'),(314,'fa fa-microphone'),(315,'fa fa-microphone-slash'),(316,'fa fa-minus'),(317,'fa fa-minus-circle'),(318,'fa fa-minus-square'),(319,'fa fa-minus-square-o'),(320,'fa fa-mobile'),(321,'fa fa-mobile-phone'),(322,'fa fa-money'),(323,'fa fa-moon-o'),(324,'fa fa-mortar-board'),(325,'fa fa-motorcycle'),(326,'fa fa-mouse-pointer'),(327,'fa fa-music'),(328,'fa fa-navicon'),(329,'fa fa-newspaper-o'),(330,'fa fa-object-group'),(331,'fa fa-object-ungroup'),(332,'fa fa-paint-brush'),(333,'fa fa-paper-plane'),(334,'fa fa-paper-plane-o'),(335,'fa fa-paw'),(336,'fa fa-pencil'),(337,'fa fa-pencil-square'),(338,'fa fa-pencil-square-o'),(339,'fa fa-percent'),(340,'fa fa-phone'),(341,'fa fa-phone-square'),(342,'fa fa-photo'),(343,'fa fa-picture-o'),(344,'fa fa-pie-chart'),(345,'fa fa-plane'),(346,'fa fa-plug'),(347,'fa fa-plus'),(348,'fa fa-plus-circle'),(349,'fa fa-plus-square'),(350,'fa fa-plus-square-o'),(351,'fa fa-podcast'),(352,'fa fa-power-off'),(353,'fa fa-print'),(354,'fa fa-puzzle-piece'),(355,'fa fa-qrcode'),(356,'fa fa-question'),(357,'fa fa-question-circle'),(358,'fa fa-question-circle-o'),(359,'fa fa-quote-left'),(360,'fa fa-quote-right'),(361,'fa fa-random'),(362,'fa fa-recycle'),(363,'fa fa-refresh'),(364,'fa fa-registered'),(365,'fa fa-remove'),(366,'fa fa-reorder'),(367,'fa fa-reply'),(368,'fa fa-reply-all'),(369,'fa fa-retweet'),(370,'fa fa-road'),(371,'fa fa-rocket'),(372,'fa fa-rss'),(373,'fa fa-rss-square'),(374,'fa fa-s15'),(375,'fa fa-search'),(376,'fa fa-search-minus'),(377,'fa fa-search-plus'),(378,'fa fa-send'),(379,'fa fa-send-o'),(380,'fa fa-server'),(381,'fa fa-share'),(382,'fa fa-share-alt'),(383,'fa fa-share-alt-square'),(384,'fa fa-share-square'),(385,'fa fa-share-square-o'),(386,'fa fa-shield'),(387,'fa fa-ship'),(388,'fa fa-shopping-bag'),(389,'fa fa-shopping-basket'),(390,'fa fa-shopping-cart'),(391,'fa fa-shower'),(392,'fa fa-sign-in'),(393,'fa fa-sign-language'),(394,'fa fa-sign-out'),(395,'fa fa-signal'),(396,'fa fa-signing'),(397,'fa fa-sitemap'),(398,'fa fa-sliders'),(399,'fa fa-smile-o'),(400,'fa fa-snowflake-o'),(401,'fa fa-soccer-ball-o'),(402,'fa fa-sort'),(403,'fa fa-sort-alpha-asc'),(404,'fa fa-sort-alpha-desc'),(405,'fa fa-sort-amount-asc'),(406,'fa fa-sort-amount-desc'),(407,'fa fa-sort-asc'),(408,'fa fa-sort-desc'),(409,'fa fa-sort-down'),(410,'fa fa-sort-numeric-asc'),(411,'fa fa-sort-numeric-desc'),(412,'fa fa-sort-up'),(413,'fa fa-space-shuttle'),(414,'fa fa-spinner'),(415,'fa fa-spoon'),(416,'fa fa-square'),(417,'fa fa-square-o'),(418,'fa fa-star'),(419,'fa fa-star-half'),(420,'fa fa-star-half-empty'),(421,'fa fa-star-half-full'),(422,'fa fa-star-half-o'),(423,'fa fa-star-o'),(424,'fa fa-sticky-note'),(425,'fa fa-sticky-note-o'),(426,'fa fa-street-view'),(427,'fa fa-suitcase'),(428,'fa fa-sun-o'),(429,'fa fa-support'),(430,'fa fa-tablet'),(431,'fa fa-tachometer'),(432,'fa fa-tag'),(433,'fa fa-tags'),(434,'fa fa-tasks'),(435,'fa fa-taxi'),(436,'fa fa-television'),(437,'fa fa-terminal'),(438,'fa fa-thermometer'),(439,'fa fa-thermometer-0'),(440,'fa fa-thermometer-1'),(441,'fa fa-thermometer-2'),(442,'fa fa-thermometer-3'),(443,'fa fa-thermometer-4'),(444,'fa fa-thermometer-empty'),(445,'fa fa-thermometer-full'),(446,'fa fa-thermometer-half'),(447,'fa fa-thermometer-quarter'),(448,'fa fa-thermometer-three-quarters'),(449,'fa fa-thumb-tack'),(450,'fa fa-thumbs-down'),(451,'fa fa-thumbs-o-down'),(452,'fa fa-thumbs-o-up'),(453,'fa fa-thumbs-up'),(454,'fa fa-ticket'),(455,'fa fa-times'),(456,'fa fa-times-circle'),(457,'fa fa-times-circle-o'),(458,'fa fa-times-rectangle'),(459,'fa fa-times-rectangle-o'),(460,'fa fa-tint'),(461,'fa fa-toggle-down'),(462,'fa fa-toggle-left'),(463,'fa fa-toggle-off'),(464,'fa fa-toggle-on'),(465,'fa fa-toggle-right'),(466,'fa fa-toggle-up'),(467,'fa fa-trademark'),(468,'fa fa-trash'),(469,'fa fa-trash-o'),(470,'fa fa-tree'),(471,'fa fa-trophy'),(472,'fa fa-truck'),(473,'fa fa-tty'),(474,'fa fa-tv'),(475,'fa fa-umbrella'),(476,'fa fa-universal-access'),(477,'fa fa-university'),(478,'fa fa-unlock'),(479,'fa fa-unlock-alt'),(480,'fa fa-unsorted'),(481,'fa fa-upload'),(482,'fa fa-user'),(483,'fa fa-user-circle'),(484,'fa fa-user-circle-o'),(485,'fa fa-user-o'),(486,'fa fa-user-plus'),(487,'fa fa-user-secret'),(488,'fa fa-user-times'),(489,'fa fa-users'),(490,'fa fa-vcard'),(491,'fa fa-vcard-o'),(492,'fa fa-video-camera'),(493,'fa fa-volume-control-phone'),(494,'fa fa-volume-down'),(495,'fa fa-volume-off'),(496,'fa fa-volume-up'),(497,'fa fa-warning'),(498,'fa fa-wheelchair'),(499,'fa fa-wheelchair-alt'),(500,'fa fa-wifi'),(501,'fa fa-window-close'),(502,'fa fa-window-close-o'),(503,'fa fa-window-maximize'),(504,'fa fa-window-minimize'),(505,'fa fa-window-restore'),(506,'fa fa-wrench'),(507,'fa fa-american-sign-language-interpreting'),(508,'fa fa-asl-interpreting'),(509,'fa fa-assistive-listening-systems'),(510,'fa fa-audio-description'),(511,'fa fa-blind'),(512,'fa fa-braille'),(513,'fa fa-cc'),(514,'fa fa-deaf'),(515,'fa fa-deafness'),(516,'fa fa-hard-of-hearing'),(517,'fa fa-low-vision'),(518,'fa fa-question-circle-o'),(519,'fa fa-sign-language'),(520,'fa fa-signing'),(521,'fa fa-tty'),(522,'fa fa-universal-access'),(523,'fa fa-volume-control-phone'),(524,'fa fa-wheelchair'),(525,'fa fa-wheelchair-alt'),(526,'fa fa-hand-grab-o'),(527,'fa fa-hand-lizard-o'),(528,'fa fa-hand-o-down'),(529,'fa fa-hand-o-left'),(530,'fa fa-hand-o-right'),(531,'fa fa-hand-o-up'),(532,'fa fa-hand-paper-o'),(533,'fa fa-hand-peace-o'),(534,'fa fa-hand-pointer-o'),(535,'fa fa-hand-rock-o'),(536,'fa fa-hand-scissors-o'),(537,'fa fa-hand-spock-o'),(538,'fa fa-hand-stop-o'),(539,'fa fa-thumbs-down'),(540,'fa fa-thumbs-o-down'),(541,'fa fa-thumbs-o-up'),(542,'fa fa-thumbs-up'),(543,'fa fa-ambulance'),(544,'fa fa-automobile'),(545,'fa fa-bicycle'),(546,'fa fa-bus'),(547,'fa fa-cab'),(548,'fa fa-car'),(549,'fa fa-fighter-jet'),(550,'fa fa-motorcycle'),(551,'fa fa-plane'),(552,'fa fa-rocket'),(553,'fa fa-ship'),(554,'fa fa-space-shuttle'),(555,'fa fa-subway'),(556,'fa fa-taxi'),(557,'fa fa-train'),(558,'fa fa-truck'),(559,'fa fa-wheelchair'),(560,'fa fa-wheelchair-alt'),(561,'fa fa-genderless'),(562,'fa fa-intersex'),(563,'fa fa-mars'),(564,'fa fa-mars-double'),(565,'fa fa-mars-stroke'),(566,'fa fa-mars-stroke-h'),(567,'fa fa-mars-stroke-v'),(568,'fa fa-mercury'),(569,'fa fa-neuter'),(570,'fa fa-transgender'),(571,'fa fa-transgender-alt'),(572,'fa fa-venus'),(573,'fa fa-venus-double'),(574,'fa fa-venus-mars'),(575,'fa fa-file'),(576,'fa fa-file-archive-o'),(577,'fa fa-file-audio-o'),(578,'fa fa-file-code-o'),(579,'fa fa-file-excel-o'),(580,'fa fa-file-image-o'),(581,'fa fa-file-movie-o'),(582,'fa fa-file-o'),(583,'fa fa-file-pdf-o'),(584,'fa fa-file-photo-o'),(585,'fa fa-file-picture-o'),(586,'fa fa-file-powerpoint-o'),(587,'fa fa-file-sound-o'),(588,'fa fa-file-text'),(589,'fa fa-file-text-o'),(590,'fa fa-file-video-o'),(591,'fa fa-file-word-o'),(592,'fa fa-file-zip-o'),(593,'fa fa-info-circle fa-lg fa-li'),(594,'fa fa-circle-o-notch'),(595,'fa fa-cog'),(596,'fa fa-gear'),(597,'fa fa-refresh'),(598,'fa fa-spinner'),(599,'fa fa-check-square'),(600,'fa fa-check-square-o'),(601,'fa fa-circle'),(602,'fa fa-circle-o'),(603,'fa fa-dot-circle-o'),(604,'fa fa-minus-square'),(605,'fa fa-minus-square-o'),(606,'fa fa-plus-square'),(607,'fa fa-plus-square-o'),(608,'fa fa-square'),(609,'fa fa-square-o'),(610,'fa fa-cc-amex'),(611,'fa fa-cc-diners-club'),(612,'fa fa-cc-discover'),(613,'fa fa-cc-jcb'),(614,'fa fa-cc-mastercard'),(615,'fa fa-cc-paypal'),(616,'fa fa-cc-stripe'),(617,'fa fa-cc-visa'),(618,'fa fa-credit-card'),(619,'fa fa-credit-card-alt'),(620,'fa fa-google-wallet'),(621,'fa fa-paypal'),(622,'fa fa-area-chart'),(623,'fa fa-bar-chart'),(624,'fa fa-bar-chart-o'),(625,'fa fa-line-chart'),(626,'fa fa-pie-chart'),(627,'fa fa-bitcoin'),(628,'fa fa-btc'),(629,'fa fa-cny'),(630,'fa fa-dollar'),(631,'fa fa-eur'),(632,'fa fa-euro'),(633,'fa fa-gbp'),(634,'fa fa-gg'),(635,'fa fa-gg-circle'),(636,'fa fa-ils'),(637,'fa fa-inr'),(638,'fa fa-jpy'),(639,'fa fa-krw'),(640,'fa fa-money'),(641,'fa fa-rmb'),(642,'fa fa-rouble'),(643,'fa fa-rub'),(644,'fa fa-ruble'),(645,'fa fa-rupee'),(646,'fa fa-shekel'),(647,'fa fa-sheqel'),(648,'fa fa-try'),(649,'fa fa-turkish-lira'),(650,'fa fa-usd'),(651,'fa fa-won'),(652,'fa fa-yen'),(653,'fa fa-align-center'),(654,'fa fa-align-justify'),(655,'fa fa-align-left'),(656,'fa fa-align-right'),(657,'fa fa-bold'),(658,'fa fa-chain'),(659,'fa fa-chain-broken'),(660,'fa fa-clipboard'),(661,'fa fa-columns'),(662,'fa fa-copy'),(663,'fa fa-cut'),(664,'fa fa-dedent'),(665,'fa fa-eraser'),(666,'fa fa-file'),(667,'fa fa-file-o'),(668,'fa fa-file-text'),(669,'fa fa-file-text-o'),(670,'fa fa-files-o'),(671,'fa fa-floppy-o'),(672,'fa fa-font'),(673,'fa fa-header'),(674,'fa fa-indent'),(675,'fa fa-italic'),(676,'fa fa-link'),(677,'fa fa-list'),(678,'fa fa-list-alt'),(679,'fa fa-list-ol'),(680,'fa fa-list-ul'),(681,'fa fa-outdent'),(682,'fa fa-paperclip'),(683,'fa fa-paragraph'),(684,'fa fa-paste'),(685,'fa fa-repeat'),(686,'fa fa-rotate-left'),(687,'fa fa-rotate-right'),(688,'fa fa-save'),(689,'fa fa-scissors'),(690,'fa fa-strikethrough'),(691,'fa fa-subscript'),(692,'fa fa-superscript'),(693,'fa fa-table'),(694,'fa fa-text-height'),(695,'fa fa-text-width'),(696,'fa fa-th'),(697,'fa fa-th-large'),(698,'fa fa-th-list'),(699,'fa fa-underline'),(700,'fa fa-undo'),(701,'fa fa-unlink'),(702,'fa fa-angle-double-down'),(703,'fa fa-angle-double-left'),(704,'fa fa-angle-double-right'),(705,'fa fa-angle-double-up'),(706,'fa fa-angle-down'),(707,'fa fa-angle-left'),(708,'fa fa-angle-right'),(709,'fa fa-angle-up'),(710,'fa fa-arrow-circle-down'),(711,'fa fa-arrow-circle-left'),(712,'fa fa-arrow-circle-o-down'),(713,'fa fa-arrow-circle-o-left'),(714,'fa fa-arrow-circle-o-right'),(715,'fa fa-arrow-circle-o-up'),(716,'fa fa-arrow-circle-right'),(717,'fa fa-arrow-circle-up'),(718,'fa fa-arrow-down'),(719,'fa fa-arrow-left'),(720,'fa fa-arrow-right'),(721,'fa fa-arrow-up'),(722,'fa fa-arrows'),(723,'fa fa-arrows-alt'),(724,'fa fa-arrows-h'),(725,'fa fa-arrows-v'),(726,'fa fa-caret-down'),(727,'fa fa-caret-left'),(728,'fa fa-caret-right'),(729,'fa fa-caret-square-o-down'),(730,'fa fa-caret-square-o-left'),(731,'fa fa-caret-square-o-right'),(732,'fa fa-caret-square-o-up'),(733,'fa fa-caret-up'),(734,'fa fa-chevron-circle-down'),(735,'fa fa-chevron-circle-left'),(736,'fa fa-chevron-circle-right'),(737,'fa fa-chevron-circle-up'),(738,'fa fa-chevron-down'),(739,'fa fa-chevron-left'),(740,'fa fa-chevron-right'),(741,'fa fa-chevron-up'),(742,'fa fa-exchange'),(743,'fa fa-hand-o-down'),(744,'fa fa-hand-o-left'),(745,'fa fa-hand-o-right'),(746,'fa fa-hand-o-up'),(747,'fa fa-long-arrow-down'),(748,'fa fa-long-arrow-left'),(749,'fa fa-long-arrow-right'),(750,'fa fa-long-arrow-up'),(751,'fa fa-toggle-down'),(752,'fa fa-toggle-left'),(753,'fa fa-toggle-right'),(754,'fa fa-toggle-up'),(755,'fa fa-arrows-alt'),(756,'fa fa-backward'),(757,'fa fa-compress'),(758,'fa fa-eject'),(759,'fa fa-expand'),(760,'fa fa-fast-backward'),(761,'fa fa-fast-forward'),(762,'fa fa-forward'),(763,'fa fa-pause'),(764,'fa fa-pause-circle'),(765,'fa fa-pause-circle-o'),(766,'fa fa-play'),(767,'fa fa-play-circle'),(768,'fa fa-play-circle-o'),(769,'fa fa-random'),(770,'fa fa-step-backward'),(771,'fa fa-step-forward'),(772,'fa fa-stop'),(773,'fa fa-stop-circle'),(774,'fa fa-stop-circle-o'),(775,'fa fa-youtube-play'),(776,'fa fa-500px'),(777,'fa fa-adn'),(778,'fa fa-amazon'),(779,'fa fa-android'),(780,'fa fa-angellist'),(781,'fa fa-apple'),(782,'fa fa-bandcamp'),(783,'fa fa-behance'),(784,'fa fa-behance-square'),(785,'fa fa-bitbucket'),(786,'fa fa-bitbucket-square'),(787,'fa fa-bitcoin'),(788,'fa fa-black-tie'),(789,'fa fa-bluetooth'),(790,'fa fa-bluetooth-b'),(791,'fa fa-btc'),(792,'fa fa-buysellads'),(793,'fa fa-cc-amex'),(794,'fa fa-cc-diners-club'),(795,'fa fa-cc-discover'),(796,'fa fa-cc-jcb'),(797,'fa fa-cc-mastercard'),(798,'fa fa-cc-paypal'),(799,'fa fa-cc-stripe'),(800,'fa fa-cc-visa'),(801,'fa fa-chrome'),(802,'fa fa-codepen'),(803,'fa fa-codiepie'),(804,'fa fa-connectdevelop'),(805,'fa fa-contao'),(806,'fa fa-css3'),(807,'fa fa-dashcube'),(808,'fa fa-delicious'),(809,'fa fa-deviantart'),(810,'fa fa-digg'),(811,'fa fa-dribbble'),(812,'fa fa-dropbox'),(813,'fa fa-drupal'),(814,'fa fa-edge'),(815,'fa fa-eercast'),(816,'fa fa-empire'),(817,'fa fa-envira'),(818,'fa fa-etsy'),(819,'fa fa-expeditedssl'),(820,'fa fa-fa'),(821,'fa fa-facebook'),(822,'fa fa-facebook-f'),(823,'fa fa-facebook-official'),(824,'fa fa-facebook-square'),(825,'fa fa-firefox'),(826,'fa fa-first-order'),(827,'fa fa-flickr'),(828,'fa fa-font-awesome'),(829,'fa fa-fonticons'),(830,'fa fa-fort-awesome'),(831,'fa fa-forumbee'),(832,'fa fa-foursquare'),(833,'fa fa-free-code-camp'),(834,'fa fa-ge'),(835,'fa fa-get-pocket'),(836,'fa fa-gg'),(837,'fa fa-gg-circle'),(838,'fa fa-git'),(839,'fa fa-git-square'),(840,'fa fa-github'),(841,'fa fa-github-alt'),(842,'fa fa-github-square'),(843,'fa fa-gitlab'),(844,'fa fa-gittip'),(845,'fa fa-glide'),(846,'fa fa-glide-g'),(847,'fa fa-google'),(848,'fa fa-google-plus'),(849,'fa fa-google-plus-circle'),(850,'fa fa-google-plus-official'),(851,'fa fa-google-plus-square'),(852,'fa fa-google-wallet'),(853,'fa fa-gratipay'),(854,'fa fa-grav'),(855,'fa fa-hacker-news'),(856,'fa fa-houzz'),(857,'fa fa-html5'),(858,'fa fa-imdb'),(859,'fa fa-instagram'),(860,'fa fa-internet-explorer'),(861,'fa fa-ioxhost'),(862,'fa fa-joomla'),(863,'fa fa-jsfiddle'),(864,'fa fa-lastfm'),(865,'fa fa-lastfm-square'),(866,'fa fa-leanpub'),(867,'fa fa-linkedin'),(868,'fa fa-linkedin-square'),(869,'fa fa-linode'),(870,'fa fa-linux'),(871,'fa fa-maxcdn'),(872,'fa fa-meanpath'),(873,'fa fa-medium'),(874,'fa fa-meetup'),(875,'fa fa-mixcloud'),(876,'fa fa-modx'),(877,'fa fa-odnoklassniki'),(878,'fa fa-odnoklassniki-square'),(879,'fa fa-opencart'),(880,'fa fa-openid'),(881,'fa fa-opera'),(882,'fa fa-optin-monster'),(883,'fa fa-pagelines'),(884,'fa fa-paypal'),(885,'fa fa-pied-piper'),(886,'fa fa-pied-piper-alt'),(887,'fa fa-pied-piper-pp'),(888,'fa fa-pinterest'),(889,'fa fa-pinterest-p'),(890,'fa fa-pinterest-square'),(891,'fa fa-product-hunt'),(892,'fa fa-qq'),(893,'fa fa-quora'),(894,'fa fa-ra'),(895,'fa fa-ravelry'),(896,'fa fa-rebel'),(897,'fa fa-reddit'),(898,'fa fa-reddit-alien'),(899,'fa fa-reddit-square'),(900,'fa fa-renren'),(901,'fa fa-resistance'),(902,'fa fa-safari'),(903,'fa fa-scribd'),(904,'fa fa-sellsy'),(905,'fa fa-share-alt'),(906,'fa fa-share-alt-square'),(907,'fa fa-shirtsinbulk'),(908,'fa fa-simplybuilt'),(909,'fa fa-skyatlas'),(910,'fa fa-skype'),(911,'fa fa-slack'),(912,'fa fa-slideshare'),(913,'fa fa-snapchat'),(914,'fa fa-snapchat-ghost'),(915,'fa fa-snapchat-square'),(916,'fa fa-soundcloud'),(917,'fa fa-spotify'),(918,'fa fa-stack-exchange'),(919,'fa fa-stack-overflow'),(920,'fa fa-steam'),(921,'fa fa-steam-square'),(922,'fa fa-stumbleupon'),(923,'fa fa-stumbleupon-circle'),(924,'fa fa-superpowers'),(925,'fa fa-telegram'),(926,'fa fa-tencent-weibo'),(927,'fa fa-themeisle'),(928,'fa fa-trello'),(929,'fa fa-tripadvisor'),(930,'fa fa-tumblr'),(931,'fa fa-tumblr-square'),(932,'fa fa-twitch'),(933,'fa fa-twitter'),(934,'fa fa-twitter-square'),(935,'fa fa-usb'),(936,'fa fa-viacoin'),(937,'fa fa-viadeo'),(938,'fa fa-viadeo-square'),(939,'fa fa-vimeo'),(940,'fa fa-vimeo-square'),(941,'fa fa-vine'),(942,'fa fa-vk'),(943,'fa fa-wechat'),(944,'fa fa-weibo'),(945,'fa fa-weixin'),(946,'fa fa-whatsapp'),(947,'fa fa-wikipedia-w'),(948,'fa fa-windows'),(949,'fa fa-wordpress'),(950,'fa fa-wpbeginner'),(951,'fa fa-wpexplorer'),(952,'fa fa-wpforms'),(953,'fa fa-xing'),(954,'fa fa-xing-square'),(955,'fa fa-y-combinator'),(956,'fa fa-y-combinator-square'),(957,'fa fa-yahoo'),(958,'fa fa-yc'),(959,'fa fa-yc-square'),(960,'fa fa-yelp'),(961,'fa fa-yoast'),(962,'fa fa-youtube'),(963,'fa fa-youtube-play'),(964,'fa fa-youtube-square'),(965,'fa fa-warning'),(966,'fa fa-ambulance'),(967,'fa fa-h-square'),(968,'fa fa-heart'),(969,'fa fa-heart-o'),(970,'fa fa-heartbeat'),(971,'fa fa-hospital-o'),(972,'fa fa-medkit'),(973,'fa fa-plus-square'),(974,'fa fa-stethoscope'),(975,'fa fa-user-md'),(976,'fa fa-wheelchair'),(977,'fa fa-wheelchair-alt');

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `id_cliente` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id del cliente',
  `nombre_empresa` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre empresa',
  `razon_social` text COLLATE utf8_unicode_ci COMMENT 'Razon social',
  `nit` varchar(156) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nit',
  `telefono` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Telefono',
  `movil` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Movil',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Email',
  `tipo_cliente` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'ETipoCliente(1:Persona Natural; 2:Empresa)',
  `observacion` text COLLATE utf8_unicode_ci COMMENT 'Observación acerca del cliente',
  `contacto` text COLLATE utf8_unicode_ci COMMENT 'Persona de contacto',
  `id_ciudad` int(11) unsigned DEFAULT NULL COMMENT 'Id ciudad',
  `direcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Direccion',
  `descuento_scanner` int(9) unsigned DEFAULT NULL COMMENT 'Numero de scanner par descontar',
  `yn_activo` smallint(1) unsigned DEFAULT '1' COMMENT 'ESiNo(1:si; 2:No)',
  `fecha_registro` datetime NOT NULL COMMENT 'Fecha de registro del cliente',
  `id_usuario_registro` int(11) unsigned NOT NULL COMMENT 'Id usuario registra',
  `fecha_modificacion` datetime DEFAULT NULL COMMENT 'Fecha modificacion',
  `id_usuario_modifica` int(11) unsigned DEFAULT NULL COMMENT 'Id usuario modifica',
  PRIMARY KEY (`id_cliente`),
  KEY `id_ciudad_cliente_fk` (`id_ciudad`),
  KEY `id_usuario_modifica_cliente_fk` (`id_usuario_modifica`),
  KEY `id_usuario_registra_cliente_fk` (`id_usuario_registro`),
  CONSTRAINT `id_ciudad_cliente_fk` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario_modifica_cliente_fk` FOREIGN KEY (`id_usuario_modifica`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario_registra_cliente_fk` FOREIGN KEY (`id_usuario_registro`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cliente` */

insert  into `cliente`(`id_cliente`,`nombre_empresa`,`razon_social`,`nit`,`telefono`,`movil`,`email`,`tipo_cliente`,`observacion`,`contacto`,`id_ciudad`,`direcion`,`descuento_scanner`,`yn_activo`,`fecha_registro`,`id_usuario_registro`,`fecha_modificacion`,`id_usuario_modifica`) values (1,'UNION TEMPORAL OBTC COLOMBIA','UNION TEMPORAL OBTC COLOMBIA','900.656.467-6','6113963','3165269490','manuel@obtc.com',2,NULL,'Manuel ',2,'CALLE 73 # 29 - 50',NULL,1,'2018-04-04 18:03:06',1,NULL,NULL);

/*Table structure for table `cliente_sede` */

DROP TABLE IF EXISTS `cliente_sede`;

CREATE TABLE `cliente_sede` (
  `id_cliente_sede` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id de la tabla',
  `id_cliente` bigint(20) unsigned NOT NULL COMMENT 'Id del cliente',
  `nombre` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre',
  `direccion` text COLLATE utf8_unicode_ci COMMENT 'Direccion',
  `telefono` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Telefono',
  PRIMARY KEY (`id_cliente_sede`),
  KEY `id_cliente_sede_fk` (`id_cliente`),
  CONSTRAINT `id_cliente_sede_fk` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cliente_sede` */

insert  into `cliente_sede`(`id_cliente_sede`,`id_cliente`,`nombre`,`direccion`,`telefono`) values (1,1,'Principal','','');

/*Table structure for table `cliente_sede_equipo` */

DROP TABLE IF EXISTS `cliente_sede_equipo`;

CREATE TABLE `cliente_sede_equipo` (
  `id_cliente_sede_equipo` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id de la tabla',
  `id_cliente_sede` bigint(20) unsigned NOT NULL COMMENT 'Id cliente_sede',
  `id_equipo` bigint(20) unsigned NOT NULL COMMENT 'Id equipo',
  `plan_minimo` int(11) unsigned DEFAULT NULL COMMENT 'Numero de copias Minimo a cobrar',
  `incluir_scanner` smallint(1) unsigned NOT NULL DEFAULT '2' COMMENT 'ESiNo(1:Si; 2: No)',
  `separar_copia_impresion` smallint(1) unsigned NOT NULL DEFAULT '2' COMMENT 'ESiNo(1:Si; 2:No)',
  `contador_copia_bn` int(20) unsigned DEFAULT NULL COMMENT 'Contador copia blanco y negr',
  `contador_impresion_bn` int(20) unsigned DEFAULT NULL COMMENT 'Contador impresion blanco y negr',
  `costo_impresion_bn` decimal(5,2) unsigned DEFAULT NULL COMMENT 'Costo de impresion o copia bn',
  `contador_copia_color` int(20) unsigned DEFAULT NULL COMMENT 'Contador copia color',
  `contador_impresion_color` int(20) unsigned DEFAULT NULL COMMENT 'Contador impresion color',
  `costo_impresion_color` decimal(5,2) unsigned DEFAULT NULL COMMENT 'Costo de impresion o copia color',
  `contador_scanner` int(20) DEFAULT NULL COMMENT 'Contador scanner',
  `costo_scanner` decimal(5,2) unsigned DEFAULT NULL COMMENT 'Costo de scanner',
  `id_usuario_registro` int(11) unsigned NOT NULL COMMENT 'Id usuario registra',
  `fecha_registro` datetime NOT NULL COMMENT 'Fecha registro',
  PRIMARY KEY (`id_cliente_sede_equipo`),
  KEY `id_cliente_sede_equipo_fk` (`id_cliente_sede`),
  KEY `id_equipo_cliente_sede_fk` (`id_equipo`),
  KEY `id_usuario_cliente_sede_fk` (`id_usuario_registro`),
  CONSTRAINT `id_cliente_sede_equipo_fk` FOREIGN KEY (`id_cliente_sede`) REFERENCES `cliente_sede` (`id_cliente_sede`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_equipo_cliente_sede_fk` FOREIGN KEY (`id_equipo`) REFERENCES `equipo` (`id_equipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario_cliente_sede_fk` FOREIGN KEY (`id_usuario_registro`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cliente_sede_equipo` */

/*Table structure for table `equipo` */

DROP TABLE IF EXISTS `equipo`;

CREATE TABLE `equipo` (
  `id_equipo` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id equipo',
  `id_modelo` bigint(20) unsigned NOT NULL COMMENT 'Id modelo',
  `serial_equipo` varchar(152) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Serial',
  `descripcion` text COLLATE utf8_unicode_ci COMMENT 'Descripcion',
  `estado` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'EEstadoEquipo(1: Activo; 2: Reparacion; 3:Inactivo)',
  `fecha_registro` datetime NOT NULL COMMENT 'Fecha registro',
  `id_usuario_registro` int(11) unsigned NOT NULL COMMENT 'Id usuario registra',
  `fecha_modificacion` datetime DEFAULT NULL COMMENT 'Fecha modificacion',
  `id_usuario_modifica` int(11) unsigned DEFAULT NULL COMMENT 'Id usuario modifica',
  `contador_inicial_copia` bigint(20) unsigned NOT NULL COMMENT 'Contador copias',
  `contador_inicial_scanner` bigint(20) unsigned DEFAULT NULL COMMENT 'Contador scanner',
  PRIMARY KEY (`id_equipo`),
  KEY `id_modelo_equipo_fk` (`id_modelo`),
  KEY `id_usuario_modifica_equipo_fk` (`id_usuario_modifica`),
  KEY `id_usuario_registro_equipo_fk` (`id_usuario_registro`),
  CONSTRAINT `id_modelo_equipo_fk` FOREIGN KEY (`id_modelo`) REFERENCES `equipo_modelo` (`id_modelo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario_modifica_equipo_fk` FOREIGN KEY (`id_usuario_modifica`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario_registro_equipo_fk` FOREIGN KEY (`id_usuario_registro`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `equipo` */

insert  into `equipo`(`id_equipo`,`id_modelo`,`serial_equipo`,`descripcion`,`estado`,`fecha_registro`,`id_usuario_registro`,`fecha_modificacion`,`id_usuario_modifica`,`contador_inicial_copia`,`contador_inicial_scanner`) values (1,1,'V9824900737',NULL,1,'2018-04-04 17:55:12',1,'2018-04-04 18:04:45',1,1,1);

/*Table structure for table `equipo_marca` */

DROP TABLE IF EXISTS `equipo_marca`;

CREATE TABLE `equipo_marca` (
  `id_marca` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id proveedor',
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre',
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `equipo_marca` */

insert  into `equipo_marca`(`id_marca`,`nombre`) values (1,'RICOH');

/*Table structure for table `equipo_modelo` */

DROP TABLE IF EXISTS `equipo_modelo`;

CREATE TABLE `equipo_modelo` (
  `id_modelo` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id modelo',
  `id_marca` int(3) unsigned NOT NULL COMMENT 'Id marca',
  `tipo` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'ETipoEquipo(1:Impresora; 2:Multifuncion)',
  `estilo` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'EEstilo(1:Blanco y Negro; 2:Color)',
  `modelo` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Modelo',
  `descripcion` text COLLATE utf8_unicode_ci COMMENT 'Descripcion',
  `fecha_registro` datetime NOT NULL COMMENT 'Fecha registro',
  PRIMARY KEY (`id_modelo`),
  KEY `id_marca_fk` (`id_marca`),
  CONSTRAINT `id_marca_fk` FOREIGN KEY (`id_marca`) REFERENCES `equipo_marca` (`id_marca`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `equipo_modelo` */

insert  into `equipo_modelo`(`id_modelo`,`id_marca`,`tipo`,`estilo`,`modelo`,`descripcion`,`fecha_registro`) values (1,1,2,2,'RICOH  2551',NULL,'2018-04-04 17:54:40');

/*Table structure for table `gasto` */

DROP TABLE IF EXISTS `gasto`;

CREATE TABLE `gasto` (
  `id_gasto` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id de la tabla',
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'descripcion del gasto',
  `valor` decimal(10,2) NOT NULL COMMENT 'valor del gasto',
  `fecha` date NOT NULL COMMENT 'fecha de registro',
  `fecha_modificacion` date DEFAULT NULL COMMENT 'fecha modificacion',
  PRIMARY KEY (`id_gasto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `gasto` */

/*Table structure for table `persona` */

DROP TABLE IF EXISTS `persona`;

CREATE TABLE `persona` (
  `id_persona` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id de la persona',
  `primer_nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Primer nombre',
  `segundo_nombre` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Segundo Nombre',
  `primer_apellido` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Primer apellido',
  `segundo_apellido` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Segundo apellido',
  `tipo_identificacion` smallint(1) unsigned DEFAULT NULL COMMENT 'Tipo de identificación',
  `numero_identificacion` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Número de identificación',
  `genero` smallint(1) unsigned DEFAULT NULL COMMENT 'EGenero(1: Masculino; 2: Femenino)',
  `fecha_nacimiento` date DEFAULT NULL COMMENT 'Fecha de nacimiento',
  `direccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Direción domicilio ',
  `barrio` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Barrio domicilio',
  `ciudad` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Ciudad de expedición',
  `telefono` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Teléfono domicilio',
  `movil` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Numero móvil o celular',
  `email` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Correo electrónico',
  `foto_perfil` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Foto del perfil',
  `fecha_registro` datetime NOT NULL COMMENT 'Fecha registro',
  `fecha_modificacion` datetime DEFAULT NULL COMMENT 'Fecha de modificación',
  PRIMARY KEY (`id_persona`),
  KEY `id_ciudad_documento_persona_fk_idx` (`ciudad`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabla que representa las personas que intervienen en el sistema';

/*Data for the table `persona` */

insert  into `persona`(`id_persona`,`primer_nombre`,`segundo_nombre`,`primer_apellido`,`segundo_apellido`,`tipo_identificacion`,`numero_identificacion`,`genero`,`fecha_nacimiento`,`direccion`,`barrio`,`ciudad`,`telefono`,`movil`,`email`,`foto_perfil`,`fecha_registro`,`fecha_modificacion`) values (1,'Rodolfo',NULL,'perez','gomez',2,'1102362325',2,'1990-12-01','CALLE 55A # 1W - 24','MUTIS','BUCARAMANGA','6397000','3215810507','pipo6280@gmail.com','1102362325.jpg','2015-11-02 08:51:23','2017-02-25 10:35:14'),(2,'OSCAR','IVAN','CARVAJAL','MANCILLA',2,'12135815646',2,'2018-01-17',NULL,NULL,NULL,NULL,'3303215655','oscar.carvajal@imprecof.com','12135815646.jpg','2018-01-17 10:01:36',NULL);

/*Table structure for table `rh_cargo` */

DROP TABLE IF EXISTS `rh_cargo`;

CREATE TABLE `rh_cargo` (
  `id_cargo` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id del cargo',
  `nombre` varchar(45) NOT NULL COMMENT 'Nombre del cargo',
  `yn_activo` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'EActivo(1: Si; 2: No)',
  `fecha_creacion` datetime DEFAULT NULL COMMENT 'Fecha de creación',
  `id_usuario_creacion` int(11) unsigned DEFAULT NULL COMMENT 'Id del usuario de creación',
  `fecha_modificacion` datetime DEFAULT NULL COMMENT 'Fecha de modificación',
  `id_usuario_modificacion` int(11) unsigned DEFAULT NULL COMMENT 'Id del usuario de modificación',
  PRIMARY KEY (`id_cargo`),
  KEY `id_usuario_modificacion_cargo_idx` (`id_usuario_modificacion`),
  KEY `id_usuario_creacion_cargo_idx` (`id_usuario_creacion`),
  CONSTRAINT `id_usuario_creacion_cargo_fk` FOREIGN KEY (`id_usuario_creacion`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario_modificacion_cargo_fk` FOREIGN KEY (`id_usuario_modificacion`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Recurso Humano: Cargos';

/*Data for the table `rh_cargo` */

insert  into `rh_cargo`(`id_cargo`,`nombre`,`yn_activo`,`fecha_creacion`,`id_usuario_creacion`,`fecha_modificacion`,`id_usuario_modificacion`) values (2,'TECNICO',1,'2016-11-26 08:10:34',1,'2016-11-26 20:25:02',1),(5,'ADMINISTRADOR',1,NULL,NULL,NULL,NULL),(6,'CARTERA',1,NULL,NULL,NULL,NULL),(7,'FACTURACION',1,NULL,NULL,NULL,NULL);

/*Table structure for table `rh_representante` */

DROP TABLE IF EXISTS `rh_representante`;

CREATE TABLE `rh_representante` (
  `id_representante` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id del representante',
  `id_persona` int(11) unsigned NOT NULL COMMENT 'Id de la persona',
  `yn_activo` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'EActivo(1: Si; 2: No)',
  `fecha_creacion` datetime NOT NULL COMMENT 'Fecha de creación',
  `id_usuario_creacion` int(11) unsigned NOT NULL COMMENT 'Id del usuario de creación',
  `fecha_modificacion` datetime DEFAULT NULL COMMENT 'Fecha de modificación',
  `id_usuario_modificacion` int(11) unsigned DEFAULT NULL COMMENT 'Id del usuario de modificación',
  PRIMARY KEY (`id_representante`),
  KEY `id_persona_representante_idx` (`id_persona`),
  CONSTRAINT `id_persona_representante_fk` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Recurso Humano: Representantes';

/*Data for the table `rh_representante` */

insert  into `rh_representante`(`id_representante`,`id_persona`,`yn_activo`,`fecha_creacion`,`id_usuario_creacion`,`fecha_modificacion`,`id_usuario_modificacion`) values (1,2,1,'2018-01-17 10:01:36',1,NULL,NULL);

/*Table structure for table `rh_representante_cargo` */

DROP TABLE IF EXISTS `rh_representante_cargo`;

CREATE TABLE `rh_representante_cargo` (
  `id_representante` int(11) unsigned NOT NULL COMMENT 'Identificador del representante',
  `id_cargo` int(11) unsigned NOT NULL COMMENT 'Id del cargo del representante',
  `yn_activo` smallint(1) unsigned DEFAULT NULL COMMENT '1: Si (Activo); 2: No (Inactivo)',
  PRIMARY KEY (`id_representante`,`id_cargo`),
  KEY `id_cargo_representante_cargo_fk` (`id_cargo`),
  CONSTRAINT `id_cargo_representante_cargo_fk` FOREIGN KEY (`id_cargo`) REFERENCES `rh_cargo` (`id_cargo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_representante_representante_cargo_fk` FOREIGN KEY (`id_representante`) REFERENCES `rh_representante` (`id_representante`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Recurso Humano: Cargos Representantes';

/*Data for the table `rh_representante_cargo` */

insert  into `rh_representante_cargo`(`id_representante`,`id_cargo`,`yn_activo`) values (1,6,1),(1,7,1);

/*Table structure for table `servicio` */

DROP TABLE IF EXISTS `servicio`;

CREATE TABLE `servicio` (
  `id_servicio` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id del servicio',
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'descripcion del servicio',
  `yn_activo` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'ESiNo(1: Si; 2: No)',
  `fecha_registro` datetime NOT NULL COMMENT 'Fecha registro',
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `servicio` */

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id_usuario` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id del usuario',
  `id_persona` int(11) unsigned NOT NULL COMMENT 'Id de la persona',
  `loggin` varchar(20) NOT NULL COMMENT 'Loggin del usuario',
  `password` varchar(60) NOT NULL COMMENT 'Contrasena del usuario',
  `yn_activo` smallint(20) unsigned NOT NULL DEFAULT '1' COMMENT 'EActivo(1: Si; 2: No)',
  `yn_ingreso` smallint(20) unsigned NOT NULL DEFAULT '2' COMMENT 'ESiNo(1: Si; 2: No)',
  `fecha_registro` datetime NOT NULL COMMENT 'Fecha registro',
  `fecha_modificacion` datetime DEFAULT NULL COMMENT 'Fecha modificación',
  PRIMARY KEY (`id_usuario`),
  KEY `id_persona_usuario_idx` (`id_persona`),
  CONSTRAINT `id_persona_usuario_fk` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`id_usuario`,`id_persona`,`loggin`,`password`,`yn_activo`,`yn_ingreso`,`fecha_registro`,`fecha_modificacion`) values (1,1,'admin','a80a6678fa430121ecc291bf4dcf2d27ab283d06',1,1,'2017-01-30 19:50:04','2017-07-10 18:48:55'),(2,2,'svillavona1','7110eda4d09e062aa5e4a390b0a572ac0d2c0220',1,1,'2018-01-17 10:01:36','2018-01-17 10:03:26');

/*Table structure for table `usuario_menu` */

DROP TABLE IF EXISTS `usuario_menu`;

CREATE TABLE `usuario_menu` (
  `id_menu` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador primario de la tabla menu',
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del menu',
  `url` varchar(120) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Url del menu',
  `id_menu_padre` int(11) unsigned DEFAULT NULL COMMENT 'Id del menu padre',
  `ubicacion` smallint(1) unsigned NOT NULL COMMENT 'EUbicacion(1: Vertical; 2: Horizontal)',
  `class_icon` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Clase del icono a mostrar',
  `visualizar_en` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'main_content' COMMENT 'Capa donde se visualiza el contenido del menu',
  `target` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'ETarget(1: self; 2: _blank; 3: _parent; 4: _top; 5: framename)',
  `orden` smallint(1) unsigned DEFAULT NULL COMMENT 'Orden del menu',
  `yn_activo` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'ESiNo(1: Si; 2: No)',
  PRIMARY KEY (`id_menu`),
  KEY `id_menu_padre_fk` (`id_menu_padre`),
  CONSTRAINT `id_menu_padre_fk` FOREIGN KEY (`id_menu_padre`) REFERENCES `usuario_menu` (`id_menu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `usuario_menu` */

insert  into `usuario_menu`(`id_menu`,`nombre`,`url`,`id_menu_padre`,`ubicacion`,`class_icon`,`visualizar_en`,`target`,`orden`,`yn_activo`) values (1,'Administración','#',NULL,1,'fa fa-cogs','main_content',1,1,1),(2,'Perfiles','perfil/',1,1,'fa fa-users','main_content',1,2,1),(3,'Menús','menu/',1,1,'fa fa-sitemap','main_content',1,1,1),(4,'Crear','menu/create',3,2,'fa fa-plus-square','main_content',1,1,1),(5,'Editar','menu/edit',3,2,'fa fa-edit','main_content',1,2,1),(6,'Ordenar','menu/order',3,2,'fa fa-sort-alpha-asc','main_content',1,3,1),(7,'Perfiles','perfil/perfil/',2,2,'fa fa-user','main_content',1,1,1),(8,'Permisos','perfil/permisos',2,2,'fa fa-user-secret','main_content',1,2,1),(9,'Recurso humano','#',NULL,1,'fa fa-user-circle','main_content',1,2,1),(10,'Cargos','cargo/',9,1,'fa fa-user-circle-o','main_content',1,1,1),(11,'Cargos','cargo/cargo',10,2,'fa fa-user-circle-o','main_content',1,1,1),(12,'Asociar Cargos','cargo/asociar',10,2,'fa fa-user-o','main_content',1,2,1),(13,'Empleados','representante/',9,1,'fa fa-users','main_content',1,2,1),(14,'Empleados','representante/representante',13,2,'fa fa-user-circle','main_content',1,NULL,1),(15,'Clientes','cliente/',NULL,1,'fa fa-users','main_content',1,3,1),(16,'Clientes','cliente/cliente',15,1,'fa fa-user-circle','main_content',1,1,1),(26,'Reportes','reporte/',NULL,1,'fa fa-file-text-o','main_content',1,8,1),(47,'Servicios','servicio/',1,1,'fa fa-cubes','main_content',1,3,1),(48,'Servicios','servicio/inicio/',47,2,'fa fa-cubes','main_content',1,NULL,1),(51,'Equipos','equipo/',1,1,'fa fa-print','main_content',1,4,1),(52,'Equipos','equipo/inicio',51,2,'fa fa-print','main_content',1,NULL,1),(53,'Modelos','equipo/modelo/',51,2,'fa fa-bars','main_content',1,NULL,1),(54,'Asignar  equipos','cliente/asignar_equipo',15,1,'fa fa-print','main_content',1,2,1),(55,'Asignar equipos','cliente/asignar_equipo',54,2,'fa fa-print','main_content',1,NULL,1),(56,'Clientes','cliente/cliente',16,2,'fa fa-user-circle-o','main_content',1,NULL,1);

/*Table structure for table `usuario_perfil` */

DROP TABLE IF EXISTS `usuario_perfil`;

CREATE TABLE `usuario_perfil` (
  `id_perfil` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id del perfil',
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del perfil',
  `yn_activo` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'ESiNo(1: Si; 2: No)',
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `usuario_perfil` */

insert  into `usuario_perfil`(`id_perfil`,`nombre`,`yn_activo`) values (1,'Administrador',1),(2,'Cartera',1),(3,'Tecnico',1),(4,'Encargado contadores',1),(5,'Facturacion',1);

/*Table structure for table `usuario_perfil_asignado` */

DROP TABLE IF EXISTS `usuario_perfil_asignado`;

CREATE TABLE `usuario_perfil_asignado` (
  `id_usuario` int(11) unsigned NOT NULL COMMENT 'Id del usuario',
  `id_perfil` int(11) unsigned NOT NULL COMMENT 'Id del perfil',
  PRIMARY KEY (`id_usuario`,`id_perfil`),
  KEY `id_usuario_asignado_fk_idx` (`id_usuario`),
  KEY `id_perfil_asignado_fk_idx` (`id_perfil`),
  CONSTRAINT `id_perfil_usuario_asignado_fk` FOREIGN KEY (`id_perfil`) REFERENCES `usuario_perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario_perfil_asignado_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `usuario_perfil_asignado` */

insert  into `usuario_perfil_asignado`(`id_usuario`,`id_perfil`) values (1,1),(2,2),(2,5);

/*Table structure for table `usuario_perfil_permiso` */

DROP TABLE IF EXISTS `usuario_perfil_permiso`;

CREATE TABLE `usuario_perfil_permiso` (
  `id_perfil` int(11) unsigned NOT NULL COMMENT 'Id del perfil',
  `id_menu` int(11) unsigned NOT NULL COMMENT 'Id del menu',
  `yn_view` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'ESiNo(1: Si; 2: No)',
  `yn_edit` smallint(1) unsigned NOT NULL DEFAULT '2' COMMENT 'ESiNo(1: Si; 2: No)',
  `yn_add` smallint(1) unsigned NOT NULL DEFAULT '2' COMMENT 'ESiNo(1: Si; 2: No)',
  `yn_delete` smallint(1) unsigned NOT NULL DEFAULT '2' COMMENT 'ESiNo(1: Si; 2: No)',
  PRIMARY KEY (`id_perfil`,`id_menu`),
  KEY `id_menu_permiso_idx` (`id_menu`),
  KEY `id_perfil_permiso_idx` (`id_perfil`,`id_menu`),
  CONSTRAINT `id_menu_permiso_fk` FOREIGN KEY (`id_menu`) REFERENCES `usuario_menu` (`id_menu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_perfil_permiso_fk` FOREIGN KEY (`id_perfil`) REFERENCES `usuario_perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `usuario_perfil_permiso` */

insert  into `usuario_perfil_permiso`(`id_perfil`,`id_menu`,`yn_view`,`yn_edit`,`yn_add`,`yn_delete`) values (1,1,1,1,1,1),(1,2,1,1,1,1),(1,3,1,1,1,1),(1,4,1,1,1,1),(1,5,1,1,1,1),(1,6,1,1,1,1),(1,7,1,1,1,1),(1,8,1,1,1,1),(1,9,1,1,1,1),(1,10,1,1,1,1),(1,11,1,1,1,1),(1,12,1,1,1,1),(1,13,1,1,1,1),(1,14,1,1,1,1),(1,15,1,1,1,1),(1,16,1,1,1,1),(1,26,1,1,1,1),(1,47,1,1,1,1),(1,48,1,1,1,1),(1,51,1,1,1,1),(1,52,1,1,1,1),(1,53,1,1,1,1),(1,54,1,1,1,1),(1,55,1,1,1,1),(1,56,1,1,1,1),(2,13,1,1,1,1),(2,14,1,1,1,1),(4,15,1,1,1,1),(4,16,1,1,1,1),(5,9,1,2,2,2),(5,10,1,2,2,2),(5,11,1,2,2,2),(5,12,1,2,2,2),(5,13,1,2,2,2),(5,14,1,2,2,2),(5,15,1,2,2,2),(5,16,1,2,2,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
