/*
SQLyog Community v8.63 
MySQL - 5.1.46-log : Database - recording
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`recording` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `recording`;

/*Table structure for table `directory` */

DROP TABLE IF EXISTS `directory`;

CREATE TABLE `directory` (
  `directory_id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `number_of_files` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  PRIMARY KEY (`directory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `directory` */

insert  into `directory`(`directory_id`,`path`,`name`,`number_of_files`,`size`) values (1,'asd','directorio',1,1000),(2,'qwe','dir2',3,2234),(3,'ggg','dir3',5,123),(4,NULL,'my superrr',NULL,NULL),(5,NULL,'asdqwe2',NULL,NULL);

/*Table structure for table `permission` */

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permission` */

insert  into `permission`(`permission_id`,`description`) values (1,'Admin'),(2,'List + Hear'),(3,'List + Hear + Delete');

/*Table structure for table `recording` */

DROP TABLE IF EXISTS `recording`;

CREATE TABLE `recording` (
  `recording_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `from` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `to` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `creation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `directory_id` int(11) NOT NULL,
  PRIMARY KEY (`recording_id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `recording` */

insert  into `recording`(`recording_id`,`name`,`from`,`to`,`size`,`creation_date`,`directory_id`) values (1,'file1','1000','2000',123,'2012-11-24 20:54:03',1),(2,'file2','1000','2000',0,'2012-11-24 20:54:14',1),(3,'file3','1000','2000',0,'2012-11-24 20:54:17',1),(4,'file4','1000','2000',0,'2012-11-24 20:54:18',1),(5,'file5','1000','2000',0,'2012-11-24 20:54:18',1),(6,'file6','1000','2000',0,'2012-11-24 20:54:18',1),(7,'file7','1000','2000',0,'2012-11-24 20:54:18',1),(8,'asdad','1000','2000',0,'2012-11-24 20:54:19',1),(9,'file9','1000','2000',0,'2012-11-24 20:54:19',1),(10,'file10','1000','2000',0,'2012-11-24 20:54:19',12),(11,'file1','','',0,'2012-11-24 20:54:20',2),(12,'helllllllllllllllllllllo','','',0,'2012-11-24 20:54:20',2),(13,'helllllllllllllllllllllo','','',0,NULL,2),(14,'helllllllllllllllllllllo','','',0,NULL,2),(15,'helllllllllllllllllllllo','','',0,NULL,2),(16,'helllllllllllllllllllllo','','',0,NULL,2),(17,'helllllllllllllllllllllo','','',0,NULL,2),(18,'helllllllllllllllllllllo','','',0,NULL,2),(19,'helllllllllllllllllllllo','','',0,NULL,2),(20,'helllllllllllllllllllllo','','',0,NULL,2),(21,'helllllllllllllllllllllo','','',0,NULL,3),(22,'helllllllllllllllllllllo','','',0,NULL,3),(23,'helllllllllllllllllllllo','','',0,NULL,3),(24,'helllllllllllllllllllllo','','',0,NULL,3),(25,'helllllllllllllllllllllo','','',0,NULL,3),(26,'helllllllllllllllllllllo','','',0,NULL,3),(27,'helllllllllllllllllllllo','','',0,NULL,3),(28,'helllllllllllllllllllllo','','',0,NULL,3),(29,'helllllllllllllllllllllo','','',0,NULL,3),(30,'helllllllllllllllllllllo','','',0,NULL,3),(31,'helllllllllllllllllllllo','','',0,NULL,3),(32,'helllllllllllllllllllllo','','',0,NULL,3),(33,'helllllllllllllllllllllo','','',0,NULL,3),(34,'helllllllllllllllllllllo','','',0,NULL,0),(35,'helllllllllllllllllllllo','','',0,NULL,0),(36,'helllllllllllllllllllllo','','',0,NULL,0),(37,'helllllllllllllllllllllo','','',0,NULL,0),(38,'helllllllllllllllllllllo','','',0,NULL,0),(39,'helllllllllllllllllllllo','','',0,NULL,0),(40,'helllllllllllllllllllllo','','',0,NULL,0),(41,'helllllllllllllllllllllo','','',0,NULL,0),(42,'helllllllllllllllllllllo','','',0,NULL,0),(43,'helllllllllllllllllllllo','','',0,NULL,0),(44,'helllllllllllllllllllllo','','',0,NULL,0),(45,'helllllllllllllllllllllo','','',0,NULL,0),(46,'helllllllllllllllllllllo','','',0,NULL,0),(47,'helllllllllllllllllllllo','','',0,NULL,0),(48,'helllllllllllllllllllllo','','',0,NULL,0),(49,'helllllllllllllllllllllo','','',0,NULL,0),(50,'helllllllllllllllllllllo','','',0,NULL,0),(51,'helllllllllllllllllllllo','','',0,NULL,0),(52,'helllllllllllllllllllllo','','',0,NULL,0),(53,'helllllllllllllllllllllo','','',0,NULL,0),(54,'helllllllllllllllllllllo','','',0,NULL,0),(55,'helllllllllllllllllllllo','','',0,NULL,0),(56,'helllllllllllllllllllllo','','',0,NULL,0),(57,'helllllllllllllllllllllo','','',0,NULL,0),(58,'helllllllllllllllllllllo','','',0,NULL,0),(59,'helllllllllllllllllllllo','','',0,NULL,0),(60,'helllllllllllllllllllllo','','',0,NULL,0),(61,'helllllllllllllllllllllo','','',0,NULL,0),(62,'helllllllllllllllllllllo','','',0,NULL,0),(63,'helllllllllllllllllllllo','','',0,NULL,0),(64,'helllllllllllllllllllllo','','',0,NULL,0),(65,'helllllllllllllllllllllo','','',0,NULL,0),(66,'helllllllllllllllllllllo','','',0,NULL,0);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `max_disk_quota` int(11) NOT NULL DEFAULT '1',
  `permission_id` int(11) NOT NULL,
  `directory_id` int(11) NOT NULL,
  `state` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`max_disk_quota`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`user_id`,`username`,`password`,`email`,`display_name`,`max_disk_quota`,`permission_id`,`directory_id`,`state`) values (1,'caruizdiaz','$2y$14$/UlxExrKPxK44iLZeS28HOZ0sckMG/LEXU1Lzf513rkMuwDEw/gma','carlos.ruizdiaz@gmail.com','Carlos Ruiz Diaz',1,1,1,NULL),(2,'ivanp','$2y$14$J.XCQeO28FXIhBEoqB5SUe83Nljf8/uEicxttMJ.IaDL0PUXz.Gc6','ivan@bellvoz.com','Ivan Penalosa',5,1,1,NULL),(3,'amonges','111111111','amonges@mail.com','Augusto Monges',5,1,1,NULL),(4,'jperez','$2y$14$KZkLJlqMeaHcX/CGyVvj4es1/pK9/WO4IWj2iGW1U55FvVofxzBpC','j@perez.com','Juan Perez',1,2,5,NULL),(5,'blabla','$2y$14$vc/d8YTA6fruZzODg7IlqujNnuiVD3yacDJfHGIdJe0O.uM1zxYHK','carlos.ruizdiaz@gmail.com','Bla Bla',1,3,1,NULL),(6,'lalo','$2y$14$T3fZNtrLjSYPTsVmYusw0ON2I7sFVb51Kff6Icz4qkBO6hLPF1rw2','lalo@ylosdescalzos.com','Bla Bla',5,1,4,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
