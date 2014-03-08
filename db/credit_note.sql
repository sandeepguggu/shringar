/*
SQLyog Ultimate v9.51 
MySQL - 5.5.23-log : Database - fmcg
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `credit_note` */

DROP TABLE IF EXISTS `credit_note`;

CREATE TABLE `credit_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `refund_bill_id` int(11) NOT NULL,
  `used_bill_id` int(11) NOT NULL DEFAULT '0',
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `used_amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `manager_user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,3) NOT NULL,
  `printed_times` tinyint(1) DEFAULT '0',
  `comment` text NOT NULL,
  `full_json` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bill_id` (`refund_bill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

/*Table structure for table `credit_note_item` */

DROP TABLE IF EXISTS `credit_note_item`;

CREATE TABLE `credit_note_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` int(11) DEFAULT NULL,
  `credit_note_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,3) DEFAULT '0.000',
  `price` decimal(10,2) DEFAULT NULL,
  `vat` decimal(10,3) DEFAULT NULL,
  `discount` decimal(10,3) DEFAULT NULL,
  `final_amount` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
