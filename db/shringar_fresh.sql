/*
SQLyog Ultimate v9.51 
MySQL - 5.5.20-log : Database - shringar
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `access_levels` */

DROP TABLE IF EXISTS `access_levels`;

CREATE TABLE `access_levels` (
  `function` varchar(20) NOT NULL,
  `access_level` tinyint(4) NOT NULL,
  UNIQUE KEY `function` (`function`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `access_levels` */

/*Table structure for table `attribute` */

DROP TABLE IF EXISTS `attribute`;

CREATE TABLE `attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `display_name` char(20) DEFAULT NULL,
  `level` int(11) DEFAULT '2',
  `availability` enum('sku','header','both') DEFAULT 'both',
  `value_type` varchar(20) DEFAULT 'text',
  `criticality` tinyint(1) DEFAULT '1',
  `value_set` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

/*Data for the table `attribute` */

insert  into `attribute`(`id`,`name`,`display_name`,`level`,`availability`,`value_type`,`criticality`,`value_set`,`created_at`,`deleted`) values (1,'model','Model',1,'header','text',1,NULL,NULL,0),(2,'size','Size',1,'both','text',1,NULL,NULL,0),(3,'color','Color',1,'both','text',1,NULL,NULL,0),(4,'volume','Volume',1,'both','text',1,NULL,NULL,0),(5,'weight','Weight',1,'both','text',1,NULL,NULL,0),(6,'variant','Variant',1,'both','text',1,NULL,NULL,0),(7,'design','Design',1,'both','text',1,NULL,NULL,0),(8,'gender','Gender',1,'header','text',1,NULL,NULL,0),(9,'price','MRP',1,'both','text',4,NULL,'2012-05-09 17:29:22',0),(10,'mfg_pkg_date','Mfg/Pkg Date',1,'sku','text',1,NULL,'2012-05-09 17:29:22',0),(11,'exp_date','Expiry Date',1,'sku','text',1,NULL,'2012-05-09 17:29:22',0),(12,'batch_no','Batch No.',1,'sku','text',1,NULL,'2012-05-09 17:29:22',0),(13,'mfg_barcode','Mfg. Barcode',1,'both','text',1,NULL,NULL,0);

/*Table structure for table `bill` */

DROP TABLE IF EXISTS `bill`;

CREATE TABLE `bill` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `paid_by_cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_by_card` decimal(10,2) NOT NULL DEFAULT '0.00',
  `customer_id` bigint(20) unsigned NOT NULL,
  `discount_type` varchar(250) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vat_amount` decimal(10,2) DEFAULT '0.00',
  `vat_discount` float NOT NULL DEFAULT '0',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `final_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_by_scheme` decimal(10,2) NOT NULL DEFAULT '0.00',
  `scheme_user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `paid_by_old_purchase_bill` decimal(10,2) DEFAULT '0.00',
  `old_purchase_bill_id` bigint(20) DEFAULT NULL,
  `paid_by_loyalty_amount` decimal(10,2) DEFAULT '0.00',
  `status` enum('paid','unpaid','cancel') NOT NULL DEFAULT 'unpaid',
  `full_json` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bill` */

/*Table structure for table `bill_items` */

DROP TABLE IF EXISTS `bill_items`;

CREATE TABLE `bill_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `weight` decimal(10,3) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `vat` decimal(10,3) NOT NULL COMMENT 'this I am using as vat_amount',
  `discount` decimal(10,3) DEFAULT NULL,
  `final_amount` decimal(10,2) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `credit_note_id` int(11) NOT NULL DEFAULT '0',
  `returned_qty` decimal(10,3) DEFAULT '0.000',
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bill_items` */

/*Table structure for table `branch` */

DROP TABLE IF EXISTS `branch`;

CREATE TABLE `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `phone1` varchar(25) NOT NULL,
  `phone2` varchar(25) NOT NULL,
  `mobile` varchar(25) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `branch` */

/*Table structure for table `brand` */

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `brand` */

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `cart` */

insert  into `cart`(`id`,`customer_id`,`status`,`created_at`,`user_id`,`branch_id`) values (1,2,'1','2012-05-29 06:38:09',2,NULL),(2,3,'1','2012-06-14 04:58:43',2,NULL),(3,7,'1','2012-06-18 12:25:04',4,NULL),(4,9,'1','2012-07-02 12:44:29',4,NULL);

/*Table structure for table `cart_item` */

DROP TABLE IF EXISTS `cart_item`;

CREATE TABLE `cart_item` (
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` bigint(20) unsigned NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,3) DEFAULT '1.000',
  `price` decimal(10,2) DEFAULT NULL,
  `vat` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cart_item` */

insert  into `cart_item`(`item_entity_id`,`item_specific_id`,`cart_id`,`quantity`,`price`,`vat`,`discount`,`final_amount`,`branch_id`,`created_at`) values (26,9,2,'1.000','999.00','999.00','0.00','999.00',2,'2012-06-14 04:59:18'),(26,16,1,'3.000','275.00','33.77','0.00','275.00',2,'2012-06-14 05:03:12'),(26,7,1,'1.000','775.00','76.80','0.00','775.00',2,'2012-06-14 05:03:12'),(26,31,3,'2.000','72.00','8.84','0.00','72.00',1,'2012-06-25 16:58:51'),(26,40,3,'4.000','72.50','8.90','0.00','72.50',1,'2012-06-25 16:58:51'),(26,48,3,'5.000','130.00','15.96','0.00','130.00',1,'2012-06-25 16:58:51'),(26,48,4,'3.000','130.00','6.19','0.00','130.00',1,'2012-07-02 12:46:07'),(26,43,4,'1.000','65.00','3.10','0.00','65.00',1,'2012-07-02 12:46:07'),(26,51,4,'2.000','75.00','3.57','0.00','75.00',1,'2012-07-02 12:46:07');

/*Table structure for table `categories_description` */

DROP TABLE IF EXISTS `categories_description`;

CREATE TABLE `categories_description` (
  `categories_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `categories_name` varchar(32) NOT NULL,
  PRIMARY KEY (`categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `categories_description` */

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `vat_percentage` float NOT NULL DEFAULT '0',
  `excise_duty` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`id`,`name`,`vat_percentage`,`excise_duty`,`created_at`,`user_id`,`parent_id`,`deleted`) values (0,'ROOT',0,NULL,'2012-04-18 13:17:43',2,0,0),(20,'Cosmetics 14',14,NULL,'2012-07-27 14:35:08',3,0,0),(21,'Exempted',0,NULL,'2012-07-27 14:35:20',3,0,0),(22,'Jewellery 5',5,NULL,'2012-07-27 14:35:31',3,0,0);

/*Table structure for table `category_description` */

DROP TABLE IF EXISTS `category_description`;

CREATE TABLE `category_description` (
  `categories_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `categories_name` varchar(32) NOT NULL,
  PRIMARY KEY (`categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `category_description` */

/*Table structure for table `central_stock` */

DROP TABLE IF EXISTS `central_stock`;

CREATE TABLE `central_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `weight` float DEFAULT NULL,
  `quantity_hold` decimal(10,3) DEFAULT '0.000',
  `weight_hold` float DEFAULT '0',
  `updated_at` datetime NOT NULL,
  `additional` varchar(100) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `central_stock` */

/*Table structure for table `central_stock_items` */

DROP TABLE IF EXISTS `central_stock_items`;

CREATE TABLE `central_stock_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` bigint(20) DEFAULT NULL,
  `super_item_entity_id` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `central_stock_items` */

/*Table structure for table `class` */

DROP TABLE IF EXISTS `class`;

CREATE TABLE `class` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=latin1;

/*Data for the table `class` */

insert  into `class`(`id`,`name`,`parent_id`,`created_at`,`sort_order`,`last_modified`,`user_id`,`deleted`) values (0,'ROOT',0,NULL,0,NULL,2,0),(133,'Cosmetics',0,NULL,0,NULL,3,0);

/*Table structure for table `class_attribute` */

DROP TABLE IF EXISTS `class_attribute`;

CREATE TABLE `class_attribute` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) DEFAULT NULL,
  `value` varchar(20) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `class_attribute` */

insert  into `class_attribute`(`id`,`attribute_id`,`value`,`class_id`,`created_at`) values (1,13,NULL,133,'2012-07-27 14:34:53');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `credit_note` */

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

/*Data for the table `credit_note_item` */

insert  into `credit_note_item`(`id`,`item_entity_id`,`item_specific_id`,`credit_note_id`,`quantity`,`price`,`vat`,`discount`,`final_amount`) values (1,26,6,5,'4.000','775.00','85.250','0.000','3441.000'),(2,26,6,6,'1.000','775.00','85.250','0.000','860.250'),(5,26,6,11,'1.000','775.00','85.250','0.000','860.250'),(6,26,6,12,'1.000','775.00','85.250','0.000','860.250'),(7,26,6,14,'1.000','775.00','85.250','0.000','860.250'),(8,26,31,15,'1.000','72.00','0.000','5.040','66.960'),(9,26,31,16,'0.000','72.00','0.000','5.040','0.000'),(10,26,31,17,'1.000','72.00','0.000','5.040','66.960'),(11,26,31,18,'2.000','72.00','0.000','0.000','144.000'),(12,26,31,25,'1.000','72.00','8.842','0.000','72.000'),(13,26,6,27,'2.000','775.00','85.250','0.000','1720.500'),(14,26,6,28,'1.000','775.00','85.250','0.000','860.250'),(15,26,6,29,'1.000','775.00','85.250','0.000','860.250'),(16,26,48,33,'1.000','130.00','15.965','0.000','130.000'),(17,26,48,34,'1.000','130.00','15.965','0.000','130.000'),(18,26,40,35,'4.000','72.50','8.904','0.000','290.000'),(19,26,48,37,'3.000','130.00','6.190','0.000','390.000'),(20,26,51,38,'2.000','75.00','3.571','0.000','150.000'),(21,26,6,39,'3.000','775.00','85.250','0.000','2580.750'),(22,26,6,40,'1.000','775.00','85.250','0.000','860.250'),(23,26,31,41,'2.000','72.00','8.842','0.000','144.000'),(24,26,6,42,'1.000','775.00','85.250','0.000','860.250'),(25,26,48,43,'1.000','130.00','15.965','0.000','130.000'),(26,26,40,44,'1.000','72.50','8.904','0.000','72.500'),(27,26,9,45,'1.000','999.00','0.000','9.990','989.010'),(28,26,9,46,'0.000','999.00','0.000','9.990','0.000'),(29,26,9,47,'0.000','999.00','0.000','9.990','0.000'),(30,26,9,48,'0.000','999.00','0.000','9.990','0.000'),(31,26,9,49,'1.000','999.00','0.000','9.990','989.010'),(32,26,6,50,'1.000','775.00','85.250','0.000','860.250'),(33,26,6,51,'1.000','775.00','85.250','0.000','860.250'),(34,26,6,52,'1.000','775.00','85.250','0.000','860.250'),(35,26,9,53,'1.000','999.00','0.000','0.000','999.000'),(36,26,61,54,'1.000','233.00','11.095','0.000','233.000'),(37,26,31,55,'0.000','72.00','0.000','0.000','0.000'),(38,26,32,56,'2.000','129.00','1.277','0.000','258.000'),(39,26,57,57,'2.000','75.00','3.571','0.000','150.000'),(40,26,6,58,'1.000','775.00','85.250','0.000','860.250'),(41,26,45,59,'3.000','55.00','2.619','0.000','165.000'),(42,26,31,60,'2.000','72.00','3.429','0.000','144.000'),(43,26,9,61,'1.000','999.00','0.000','0.000','999.000');

/*Table structure for table `customer_loyalty_config` */

DROP TABLE IF EXISTS `customer_loyalty_config`;

CREATE TABLE `customer_loyalty_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `entity_conversion` tinyint(4) DEFAULT NULL,
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` bigint(20) DEFAULT NULL,
  `weight` float DEFAULT NULL COMMENT 'in grams',
  `value_rupees` float DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `customer_loyalty_config` */

insert  into `customer_loyalty_config`(`id`,`name`,`points`,`entity_conversion`,`item_entity_id`,`item_specific_id`,`weight`,`value_rupees`,`updated_at`) values (1,'loyalty',5,0,NULL,NULL,NULL,1,'2012-04-02 19:11:20'),(2,'loyalty_points',5,0,NULL,NULL,NULL,1,'2012-04-02 19:11:45');

/*Table structure for table `customer_loyalty_transaction` */

DROP TABLE IF EXISTS `customer_loyalty_transaction`;

CREATE TABLE `customer_loyalty_transaction` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) NOT NULL,
  `loyalty_points` int(11) NOT NULL,
  `flow` enum('in','out') NOT NULL,
  `points_before` int(11) DEFAULT NULL,
  `points_after` int(11) DEFAULT NULL,
  `reference_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `customer_loyalty_transaction` */

/*Table structure for table `customer_order` */

DROP TABLE IF EXISTS `customer_order`;

CREATE TABLE `customer_order` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delivery_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `paid_by_cash` float NOT NULL DEFAULT '0',
  `paid_by_card` float NOT NULL DEFAULT '0',
  `paid_by_scheme` float NOT NULL DEFAULT '0',
  `rate_type` tinyint(4) DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `discount_type` varchar(250) NOT NULL,
  `discount_value` float NOT NULL DEFAULT '0',
  `vat_amount` float DEFAULT NULL,
  `total_amount` float NOT NULL DEFAULT '0',
  `final_amount` float NOT NULL DEFAULT '0',
  `status` enum('paid','unpaid','cancel') NOT NULL DEFAULT 'unpaid',
  `branch_id` int(11) DEFAULT NULL,
  `full_json` longtext NOT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `customer_order` */

/*Table structure for table `customer_order_items` */

DROP TABLE IF EXISTS `customer_order_items`;

CREATE TABLE `customer_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `weight` float DEFAULT NULL,
  `price` float NOT NULL,
  `vat` float NOT NULL COMMENT 'this I am using as vat_amount',
  `discount` float DEFAULT NULL,
  `final_amount` float NOT NULL,
  `branch_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `credit_note_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`customer_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `customer_order_items` */

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(250) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `dob` date NOT NULL,
  `sex` enum('M','F') NOT NULL,
  `phone` varchar(25) NOT NULL,
  `email` varchar(250) NOT NULL,
  `sms` enum('Y','N') NOT NULL,
  `building` varchar(250) NOT NULL,
  `street` varchar(250) NOT NULL,
  `area` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `pin` varchar(20) NOT NULL,
  `state` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `loyalty_points` int(11) NOT NULL DEFAULT '0',
  `loyalty_points_valid_till` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `customers` */

/*Table structure for table `estimate` */

DROP TABLE IF EXISTS `estimate`;

CREATE TABLE `estimate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `paid_by_cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_by_card` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_by_scheme` decimal(10,2) NOT NULL DEFAULT '0.00',
  `customer_id` int(11) NOT NULL,
  `discount_type` varchar(250) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vat_amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `final_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('paid','unpaid','cancel') NOT NULL DEFAULT 'unpaid',
  `full_json` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `estimate` */

/*Table structure for table `estimate_items` */

DROP TABLE IF EXISTS `estimate_items`;

CREATE TABLE `estimate_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `weight` float DEFAULT NULL,
  `price` float NOT NULL,
  `vat` float NOT NULL COMMENT 'this I am using as vat_amount',
  `discount` float DEFAULT NULL,
  `final_amount` float NOT NULL,
  `branch_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `credit_note_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`estimate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `estimate_items` */

/*Table structure for table `goldsmith` */

DROP TABLE IF EXISTS `goldsmith`;

CREATE TABLE `goldsmith` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `mobile` int(11) DEFAULT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `landline` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `goldsmith` */

/*Table structure for table `grn_payment` */

DROP TABLE IF EXISTS `grn_payment`;

CREATE TABLE `grn_payment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT '0',
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` int(11) DEFAULT NULL,
  `item_weight` float DEFAULT '0',
  `item_quantity` int(11) DEFAULT '1',
  `item_total` float DEFAULT NULL,
  `net_amount` float DEFAULT NULL,
  `due_amount` float DEFAULT NULL,
  `product_receive_note_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `grn_payment` */

/*Table structure for table `group` */

DROP TABLE IF EXISTS `group`;

CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `identifier` varchar(250) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `group` */

insert  into `group`(`id`,`title`,`identifier`,`description`,`deleted`) values (1,'Full Access','full_access',' ',0),(2,'Billing Access','billing_access','',0);

/*Table structure for table `group_tab_permission` */

DROP TABLE IF EXISTS `group_tab_permission`;

CREATE TABLE `group_tab_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `tab_id` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `group_tab_permission` */

insert  into `group_tab_permission`(`id`,`group_id`,`tab_id`) values (1,1,'1,6,7,8,2,9,10,11,12,13,31,14,15,29,3,16,17,30,33,28,4,18,19,20,21,22,23,24,25,5,26,27,32'),(2,2,'1,6,7,8');

/*Table structure for table `item_entity` */

DROP TABLE IF EXISTS `item_entity`;

CREATE TABLE `item_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `is_header` tinyint(4) NOT NULL DEFAULT '0',
  `product_entity_id` int(11) DEFAULT NULL,
  `barcode_only` tinyint(4) NOT NULL DEFAULT '0',
  `mfg_barcode` tinyint(4) DEFAULT NULL,
  `old_purchase` tinyint(4) DEFAULT '0',
  `is_composite` tinyint(4) DEFAULT '0',
  `is_subtype` tinyint(4) DEFAULT '0',
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `item_entity` */

insert  into `item_entity`(`id`,`name`,`display_name`,`table_name`,`is_header`,`product_entity_id`,`barcode_only`,`mfg_barcode`,`old_purchase`,`is_composite`,`is_subtype`,`deleted`) values (1,'metal','Metal',NULL,0,NULL,0,NULL,1,0,0,0),(2,'stone','Stone',NULL,0,NULL,0,NULL,1,0,0,0),(3,'ornament','Ornament',NULL,1,5,0,NULL,0,1,0,0),(4,'old_ornament','Old Ornament',NULL,0,NULL,0,NULL,0,0,0,1),(5,'ornament_product','Ornament Product',NULL,0,NULL,0,1,0,1,1,0),(6,'bill','Bill',NULL,0,NULL,1,0,0,0,0,0),(7,'branch','',NULL,0,NULL,1,NULL,0,0,0,0),(8,'brand','Brand',NULL,0,NULL,1,NULL,0,0,0,0),(9,'category','Category',NULL,0,NULL,1,NULL,0,0,0,0),(10,'credit_note','Credit Note',NULL,0,NULL,1,NULL,0,0,0,0),(11,'customers','Customer',NULL,0,NULL,1,NULL,0,0,0,0),(12,'estimate','Estimate',NULL,0,NULL,1,NULL,0,0,0,0),(13,'goldsmith','Goldsmith',NULL,0,NULL,1,NULL,0,0,0,0),(14,'jobsheet_issued','Job Sheet',NULL,0,NULL,1,NULL,0,0,0,0),(15,'jobsheet_returned','Job Work Receipt',NULL,0,NULL,1,NULL,0,0,0,0),(16,'products','Product',NULL,0,NULL,1,1,0,0,0,0),(17,'po','Purchase Order','purchase_order',0,NULL,1,0,0,0,0,0),(18,'scheme','Scheme',NULL,0,NULL,1,0,0,0,0,0),(19,'scheme_invoice','Scheme Installment Invoice',NULL,0,NULL,1,0,0,0,0,0),(20,'user','User',NULL,0,NULL,1,0,0,0,0,0),(21,'vendor','Vendor',NULL,0,NULL,1,0,0,0,0,0),(22,'grn','Goods Receive Note','product_receive_note',0,NULL,1,0,0,0,0,0),(23,'old_purchase_bill','Purchase Bill','old_purchase_bill',0,NULL,1,NULL,0,0,0,0),(24,'customer_order','Customer Order','customer_order',0,NULL,1,NULL,0,0,0,0),(25,'product_header','Product Header','product_header',1,26,0,1,0,0,0,0),(26,'product_sku','Product SKU','product_sku',0,NULL,0,1,0,0,0,0),(27,'purchase_return','Purchase Return','purchase_return',0,NULL,1,0,0,0,0,0);

/*Table structure for table `jobsheet_issued` */

DROP TABLE IF EXISTS `jobsheet_issued`;

CREATE TABLE `jobsheet_issued` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goldsmith_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `jobsheet_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `payment_type` enum('metal','cash','mixed') NOT NULL,
  `payment_amt` float NOT NULL,
  `payment_percent` float NOT NULL,
  `payment_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `jobsheet_issued` */

/*Table structure for table `jobsheet_issued_item` */

DROP TABLE IF EXISTS `jobsheet_issued_item`;

CREATE TABLE `jobsheet_issued_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobsheet_issued_id` int(11) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `flow` enum('in','out') NOT NULL,
  `job_charge` float NOT NULL,
  `job_type` varchar(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `jobsheet_issued_item` */

/*Table structure for table `jobsheet_returned` */

DROP TABLE IF EXISTS `jobsheet_returned`;

CREATE TABLE `jobsheet_returned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobsheet_issued_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `goldsmith_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `jobsheet_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `payment_type` enum('metal','cash','mixed') NOT NULL,
  `payment_amt` float NOT NULL,
  `payment_percent` float NOT NULL,
  `payment_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `jobsheet_returned` */

/*Table structure for table `jobsheet_returned_item` */

DROP TABLE IF EXISTS `jobsheet_returned_item`;

CREATE TABLE `jobsheet_returned_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobsheet_returned_id` int(11) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `flow` enum('in','out') NOT NULL,
  `job_charge` float NOT NULL,
  `job_type` varchar(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `jobsheet_returned_item` */

/*Table structure for table `metal` */

DROP TABLE IF EXISTS `metal`;

CREATE TABLE `metal` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `karat` int(11) DEFAULT NULL,
  `fineness` int(11) DEFAULT NULL,
  `type` enum('gold','platinum','silver') NOT NULL,
  `category_id` int(11) NOT NULL,
  `unit` enum('kg','g') NOT NULL,
  `is_old` tinyint(4) DEFAULT NULL,
  `low_threshold` int(11) NOT NULL,
  `high_threshold` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `metal` */

/*Table structure for table `old_ornament` */

DROP TABLE IF EXISTS `old_ornament`;

CREATE TABLE `old_ornament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `weight` float NOT NULL,
  `metal_id` int(11) NOT NULL,
  `deterioration_app` float NOT NULL,
  `metal_wt` float NOT NULL,
  `stone_wt` float NOT NULL,
  `stone_cost` float NOT NULL,
  `stone_details` varchar(200) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `old_ornament` */

/*Table structure for table `old_purchase_bill` */

DROP TABLE IF EXISTS `old_purchase_bill`;

CREATE TABLE `old_purchase_bill` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `amount` float NOT NULL,
  `amount_due` float DEFAULT NULL,
  `full_json` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `old_purchase_bill` */

/*Table structure for table `old_purchase_bill_item` */

DROP TABLE IF EXISTS `old_purchase_bill_item`;

CREATE TABLE `old_purchase_bill_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `old_purchase_bill_id` bigint(20) unsigned DEFAULT NULL,
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` bigint(20) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `old_purchase_bill_item` */

/*Table structure for table `ornament` */

DROP TABLE IF EXISTS `ornament`;

CREATE TABLE `ornament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `weight` float NOT NULL,
  `metal_id` int(11) DEFAULT NULL,
  `metal_wt` float DEFAULT NULL,
  `stone_wt` float DEFAULT NULL,
  `stone_details` varchar(400) DEFAULT NULL,
  `stone_cost` varchar(50) DEFAULT NULL,
  `making_cost_percent` float DEFAULT NULL,
  `making_cost_fixed` float DEFAULT NULL,
  `wastage_percent` float DEFAULT NULL,
  `wastage_cost_fixed` float DEFAULT NULL,
  `comments` text,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ornament` */

/*Table structure for table `ornament_items` */

DROP TABLE IF EXISTS `ornament_items`;

CREATE TABLE `ornament_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ornament_id` int(11) NOT NULL,
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ornament_items` */

/*Table structure for table `ornament_product` */

DROP TABLE IF EXISTS `ornament_product`;

CREATE TABLE `ornament_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ornament_header_id` int(11) NOT NULL,
  `weight` float DEFAULT NULL,
  `comment` varchar(200) NOT NULL,
  `mfg_barcode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ornament_product` */

/*Table structure for table `ornament_product_items` */

DROP TABLE IF EXISTS `ornament_product_items`;

CREATE TABLE `ornament_product_items` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ornament_product_id` bigint(20) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `weight` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ornament_product_items` */

/*Table structure for table `po_product_attribute` */

DROP TABLE IF EXISTS `po_product_attribute`;

CREATE TABLE `po_product_attribute` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_items_id` bigint(20) unsigned DEFAULT NULL,
  `attribute_id` int(11) DEFAULT NULL,
  `attribute_name` varchar(30) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `criticality` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;

/*Data for the table `po_product_attribute` */

insert  into `po_product_attribute`(`id`,`purchase_order_items_id`,`attribute_id`,`attribute_name`,`value`,`level`,`criticality`,`created_at`) values (1,1,-4,'price','100',1,2,'2012-05-22 12:22:48'),(2,1,54,'Attribute 1','1',2,2,'2012-05-22 12:22:48'),(3,1,55,'Attribute 2','2',2,2,'2012-05-22 12:22:48'),(4,1,56,'Attribute 3','3',2,2,'2012-05-22 12:22:48'),(5,2,-4,'price','199',1,2,'2012-05-22 20:09:09'),(6,2,54,'Attribute 1','att1',2,2,'2012-05-22 20:09:09'),(7,2,55,'Attribute 2','rendu',2,2,'2012-05-22 20:09:09'),(8,2,56,'Attribute 3','moodu',2,2,'2012-05-22 20:09:09'),(9,3,-1,'size','38',1,2,'2012-05-22 20:09:09'),(10,3,-3,'design','x',1,2,'2012-05-22 20:09:10'),(11,3,-5,'price','599',1,2,'2012-05-22 20:09:10'),(12,3,54,'Attribute 1','att1',2,2,'2012-05-22 20:09:10'),(13,3,55,'Attribute 2','att2',2,2,'2012-05-22 20:09:10'),(14,4,-1,'size','S',1,2,'2012-05-23 17:55:31'),(15,4,-2,'color','Blue',1,2,'2012-05-23 17:55:31'),(16,4,-3,'price','775',1,2,'2012-05-23 17:55:31'),(17,5,-1,'size','L',1,2,'2012-05-23 17:55:31'),(18,5,-2,'color','Blue',1,2,'2012-05-23 17:55:31'),(19,5,-3,'price','775',1,2,'2012-05-23 17:55:31'),(20,6,-1,'size','XL',1,2,'2012-05-23 17:55:31'),(21,6,-2,'color','Blue',1,2,'2012-05-23 17:55:31'),(22,6,-3,'price','775',1,2,'2012-05-23 17:55:31'),(23,7,-4,'price','56',1,2,'2012-05-26 07:13:16'),(24,7,54,'Attribute 1','1',2,2,'2012-05-26 07:13:16'),(25,7,55,'Attribute 2','2',2,2,'2012-05-26 07:13:17'),(26,7,56,'Attribute 3','3',2,2,'2012-05-26 07:13:17'),(27,8,-1,'size','25',1,2,'2012-05-26 07:13:17'),(28,8,-3,'design','x',1,2,'2012-05-26 07:13:17'),(29,8,-5,'price','66',1,2,'2012-05-26 07:13:17'),(30,8,54,'Attribute 1','1',2,2,'2012-05-26 07:13:17'),(31,8,55,'Attribute 2','2',2,2,'2012-05-26 07:13:17'),(32,9,-4,'price','56',1,2,'2012-05-26 07:30:51'),(33,9,54,'Attribute 1','1',2,2,'2012-05-26 07:30:52'),(34,9,55,'Attribute 2','2',2,2,'2012-05-26 07:30:52'),(35,9,56,'Attribute 3','3',2,2,'2012-05-26 07:30:52'),(36,10,-1,'size','25',1,2,'2012-05-26 07:30:52'),(37,10,-3,'design','x',1,2,'2012-05-26 07:30:52'),(38,10,-5,'price','66',1,2,'2012-05-26 07:30:52'),(39,10,54,'Attribute 1','1',2,2,'2012-05-26 07:30:52'),(40,10,55,'Attribute 2','2',2,2,'2012-05-26 07:30:52'),(41,11,-4,'price','200',1,2,'2012-05-29 06:07:11'),(42,12,-4,'price','250',1,2,'2012-05-30 05:24:03'),(43,13,-2,'design','x',1,2,'2012-05-30 05:24:04'),(44,13,-4,'price','200',1,2,'2012-05-30 05:24:04'),(45,13,54,'Attribute 1','1',2,2,'2012-05-30 05:24:04'),(46,13,55,'Attribute 2','2',2,2,'2012-05-30 05:24:04'),(47,13,56,'Attribute 3','3',2,2,'2012-05-30 05:24:04'),(48,13,57,'Attribute 4','4',2,2,'2012-05-30 05:24:04'),(49,14,-1,'size','38',1,2,'2012-05-30 10:00:19'),(50,14,-2,'color','Red',1,2,'2012-05-30 10:00:20'),(51,14,-3,'price','999',1,2,'2012-05-30 10:00:20'),(52,15,-1,'color','red',1,2,'2012-06-04 11:39:42'),(53,15,-2,'price','3',1,2,'2012-06-04 11:39:42'),(54,16,-1,'color','pink',1,2,'2012-06-04 11:39:42'),(55,16,-2,'price','3',1,2,'2012-06-04 11:39:42'),(56,17,-1,'color','red',1,2,'2012-06-04 11:41:44'),(57,17,-2,'price','3',1,2,'2012-06-04 11:41:44'),(58,18,-1,'color','pink',1,2,'2012-06-04 11:41:44'),(59,18,-2,'price','4',1,2,'2012-06-04 11:41:44'),(60,20,62,'Shades','11',2,2,'2012-06-14 09:31:31'),(61,21,-1,'MRP','240',1,2,'2012-06-14 10:03:24'),(62,21,-2,'Mfg. Barcode','8901030310379',1,2,'2012-06-14 10:03:25'),(63,21,62,'Shades','11',2,2,'2012-06-14 10:03:25'),(64,22,-1,'design','x',1,2,'2012-06-14 13:22:09'),(65,22,-3,'price','123',1,2,'2012-06-14 13:22:09'),(66,22,54,'Attribute 1','1',2,2,'2012-06-14 13:22:09'),(67,22,55,'Attribute 2','2',2,2,'2012-06-14 13:22:09'),(68,22,56,'Attribute 3','3',2,2,'2012-06-14 13:22:09'),(69,22,57,'Attribute 4','4',2,2,'2012-06-14 13:22:09'),(70,23,-3,'price','200',1,2,'2012-06-14 13:22:09'),(71,24,-2,'price','22',1,2,'2012-06-14 14:12:18'),(72,26,-1,'size','23',1,2,'2012-06-14 14:13:55'),(73,26,-2,'design','xd',1,2,'2012-06-14 14:13:55'),(74,27,-1,'design','sss',1,2,'2012-06-14 14:13:55'),(75,27,54,'Attribute 1','w',2,2,'2012-06-14 14:13:55'),(76,27,55,'Attribute 2','w',2,2,'2012-06-14 14:13:55'),(77,27,56,'Attribute 3','ww',2,2,'2012-06-14 14:13:55'),(78,27,57,'Attribute 4','w',2,2,'2012-06-14 14:13:55'),(79,28,-1,'price','72',1,2,'2012-06-14 18:27:43'),(80,29,-1,'design','xyz',1,2,'2012-06-14 15:21:34'),(81,29,-3,'price','225',1,2,'2012-06-14 15:21:34'),(82,29,54,'Attribute 1','123',2,2,'2012-06-14 15:21:34'),(83,29,55,'Attribute 2','234',2,2,'2012-06-14 15:21:34'),(84,29,56,'Attribute 3','345',2,2,'2012-06-14 15:21:34'),(85,29,57,'Attribute 4','456',2,2,'2012-06-14 15:21:34'),(86,30,-2,'price','234',1,2,'2012-06-14 15:21:34'),(87,31,-1,'price','68',1,2,'2012-06-18 12:52:06'),(88,32,-1,'price','72',1,2,'2012-06-18 12:52:06'),(89,33,-1,'price','375',1,2,'2012-06-18 13:19:31'),(90,33,62,'Shades','Black',2,2,'2012-06-18 13:19:31'),(91,34,-1,'size','38',1,2,'2012-06-19 12:05:55'),(92,34,-2,'color','Red',1,2,'2012-06-19 12:05:55'),(93,34,-3,'price','2344',1,2,'2012-06-19 12:05:55'),(94,35,-1,'price','72',1,2,'2012-06-20 12:36:04'),(95,36,-1,'price','75',1,2,'2012-06-20 12:36:04'),(96,37,-1,'price','77',1,2,'2012-06-20 12:36:04'),(97,38,-1,'price','34',1,2,'2012-06-20 12:36:05'),(98,38,62,'Shades','5',2,2,'2012-06-20 12:36:05'),(99,39,-1,'price','72',1,2,'2012-06-20 14:11:26'),(100,40,-1,'price','75',1,2,'2012-06-20 14:11:26'),(101,41,-1,'size','22',1,2,'2012-06-25 12:44:20'),(102,41,-2,'color','red',1,2,'2012-06-25 12:44:21'),(103,41,-3,'price','222',1,2,'2012-06-25 12:44:21'),(104,43,-1,'price','130',1,2,'2012-06-25 16:57:30'),(105,44,-1,'price','15',1,2,'2012-06-25 17:07:19'),(106,44,65,'Small','5',2,2,'2012-06-25 17:07:19'),(107,45,-1,'price','65',1,2,'2012-06-25 17:11:41'),(108,45,62,'Shades','5',2,2,'2012-06-25 17:11:41'),(109,46,-1,'price','750',1,2,'2012-06-25 17:22:27'),(110,47,-1,'price','130',1,2,'2012-07-02 12:29:06'),(111,48,-1,'color','Red',1,2,'2012-07-02 12:55:11'),(112,48,-2,'price','20',1,2,'2012-07-02 12:55:11'),(113,49,-1,'price','75',1,2,'2012-07-02 12:55:11'),(114,50,-1,'price','75',1,2,'2012-07-02 13:03:12'),(115,51,-2,'color','White',1,2,'2012-07-05 12:17:40'),(116,51,-3,'price','500',1,2,'2012-07-05 12:17:40'),(117,52,-1,'price','900',1,2,'2012-07-05 12:17:40'),(118,52,65,'Small','Orange',2,2,'2012-07-05 12:17:40');

/*Table structure for table `product_attribute` */

DROP TABLE IF EXISTS `product_attribute`;

CREATE TABLE `product_attribute` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` varchar(20) DEFAULT NULL,
  `product_header_id` bigint(20) DEFAULT NULL,
  `sku` tinyint(1) DEFAULT '0',
  `product_sku_id` bigint(20) unsigned DEFAULT NULL,
  `value` varchar(30) DEFAULT NULL,
  `criticality` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

/*Data for the table `product_attribute` */

insert  into `product_attribute`(`id`,`attribute_id`,`product_header_id`,`sku`,`product_sku_id`,`value`,`criticality`,`created_at`) values (7,'54',NULL,1,1,'1',1,'2012-05-22 12:24:10'),(8,'55',NULL,1,1,'2',1,'2012-05-22 12:24:10'),(9,'56',NULL,1,1,'3',1,'2012-05-22 12:24:10'),(14,'54',NULL,1,2,'att1',1,'2012-05-22 20:10:17'),(15,'55',NULL,1,2,'rendu',1,'2012-05-22 20:10:17'),(16,'56',NULL,1,2,'moodu',1,'2012-05-22 20:10:17'),(17,'54',NULL,1,3,'att1',1,'2012-05-22 20:10:18'),(18,'55',NULL,1,3,'att2',1,'2012-05-22 20:10:18'),(19,'54',NULL,1,4,'111',1,'2012-05-22 20:10:19'),(20,'55',NULL,1,4,'222',1,'2012-05-22 20:10:19'),(21,'56',NULL,1,4,'333',1,'2012-05-22 20:10:19'),(26,'61',4,0,NULL,'Short sleeve',1,'2012-06-29 09:30:37'),(27,'61',4,0,NULL,'Short sleeve',1,'2012-06-29 09:30:37'),(28,'54',NULL,1,8,'1',1,'2012-05-24 07:30:04'),(29,'55',NULL,1,8,'2',1,'2012-05-24 07:30:04'),(30,'56',NULL,1,8,'3',1,'2012-05-24 07:30:04'),(31,'54',NULL,1,11,'1',1,'2012-06-01 08:06:58'),(32,'55',NULL,1,11,'2',1,'2012-06-01 08:06:58'),(33,'56',NULL,1,11,'3',1,'2012-06-01 08:06:58'),(34,'62',10,1,NULL,'',1,'2012-06-05 06:34:20'),(36,'62',13,0,NULL,'brown',1,'2012-06-25 16:12:37'),(37,'62',15,0,NULL,'Marble',1,'2012-06-14 09:16:28'),(38,'62',16,1,NULL,'',1,'2012-06-18 13:18:30'),(39,'62',NULL,1,28,'11',1,'2012-06-14 09:35:46'),(41,'62',NULL,1,30,'11',1,'2012-06-14 12:23:06'),(42,'64',20,0,NULL,'72',1,'2012-06-18 13:18:07'),(43,'62',29,1,NULL,'',1,'2012-06-18 13:16:42'),(44,'62',NULL,1,36,'Black',1,'2012-06-18 13:20:20'),(45,'62',NULL,1,37,'Red',1,'2012-06-18 14:12:12'),(46,'62',NULL,1,38,'350',1,'2012-06-18 14:13:03'),(47,'62',NULL,1,39,'Black',1,'2012-06-18 14:13:43'),(48,'62',NULL,1,41,'RED',1,'2012-06-19 14:04:49'),(49,'65',31,1,NULL,'',1,'2012-07-04 14:41:10'),(50,'65',32,1,NULL,'550',1,'2012-06-25 17:20:24'),(51,'66',33,1,NULL,'750',1,'2012-06-25 17:21:27'),(52,'66',NULL,1,50,'750',1,'2012-06-25 17:22:59'),(53,'67',4,0,NULL,'23',1,'2012-06-29 09:30:37'),(54,'62',NULL,1,54,'Red',1,'2012-06-29 13:15:50'),(55,'68',36,0,NULL,'1',1,'2012-07-02 12:34:04'),(56,'69',37,1,NULL,'25',1,'2012-07-02 12:53:45'),(57,'62',NULL,1,56,'5',1,'2012-07-02 12:58:39'),(58,'62',NULL,1,58,'11',1,'2012-07-02 07:53:02'),(59,'68',38,0,NULL,'46',1,'2012-07-02 13:26:57'),(60,'62',NULL,1,59,'11',1,'2012-07-02 08:54:45');

/*Table structure for table `product_header` */

DROP TABLE IF EXISTS `product_header`;

CREATE TABLE `product_header` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_desc_id` bigint(20) unsigned DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `volume` decimal(5,3) DEFAULT NULL,
  `volume_unit` enum('ml','l') DEFAULT NULL,
  `weight` decimal(5,3) DEFAULT NULL,
  `weight_unit` enum('g','kg','-99','') DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `variant` varchar(30) DEFAULT NULL,
  `design` varchar(30) DEFAULT NULL,
  `gender` enum('M','F','U','') DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '-99.00',
  `price_unit` enum('weight','volume','pieces','-99') DEFAULT 'pieces',
  `tax_category_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `extra_attr_app` tinyint(1) DEFAULT '0',
  `extra_json` text,
  `mfg_barcode` varchar(50) DEFAULT NULL,
  `X` int(11) DEFAULT '0',
  `Y` int(11) DEFAULT '0',
  `Z` int(11) DEFAULT '0',
  `tracking_level` tinyint(1) DEFAULT '2',
  `user_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_header` */

/*Table structure for table `product_header_class` */

DROP TABLE IF EXISTS `product_header_class`;

CREATE TABLE `product_header_class` (
  `id` bigint(20) unsigned NOT NULL,
  `product_header_id` bigint(20) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_header_class` */

/*Table structure for table `product_receive_note` */

DROP TABLE IF EXISTS `product_receive_note`;

CREATE TABLE `product_receive_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `dated` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `extra_json` longtext NOT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_receive_note` */

/*Table structure for table `product_receive_note_items` */

DROP TABLE IF EXISTS `product_receive_note_items`;

CREATE TABLE `product_receive_note_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_receive_note_id` int(11) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `weight` decimal(10,3) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `max_qnt` int(11) NOT NULL DEFAULT '-1',
  `quantity_returned` decimal(10,3) DEFAULT '0.000',
  `weight_returned` decimal(10,3) DEFAULT '0.000',
  PRIMARY KEY (`id`),
  KEY `product_receive_note_id` (`product_receive_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_receive_note_items` */

/*Table structure for table `product_sku` */

DROP TABLE IF EXISTS `product_sku`;

CREATE TABLE `product_sku` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `header_id` bigint(20) unsigned DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `weight` decimal(5,3) DEFAULT NULL,
  `weight_unit` enum('g','kg') DEFAULT NULL,
  `volume` decimal(5,3) DEFAULT NULL,
  `volume_unit` enum('ml','l') DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `variant` varchar(30) DEFAULT NULL,
  `design` varchar(30) DEFAULT NULL,
  `gender` enum('M','F','U') DEFAULT 'U',
  `price` decimal(6,2) DEFAULT NULL,
  `price_unit` enum('weight','volume','pieces','-99') DEFAULT 'pieces',
  `max_discount` decimal(3,2) DEFAULT NULL,
  `image_path` varchar(200) DEFAULT NULL,
  `image` blob,
  `date_updated` datetime DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `batch_no` varchar(20) DEFAULT NULL,
  `mfg_pkg_date` date DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `extra_attr_app` tinyint(1) DEFAULT NULL,
  `mfg_barcode` varchar(30) DEFAULT NULL,
  `extra_json` text,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_sku` */

/*Table structure for table `product_transactions` */

DROP TABLE IF EXISTS `product_transactions`;

CREATE TABLE `product_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qnt` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `ref_id` (`ref_id`),
  KEY `product_id` (`product_id`),
  KEY `qnt` (`qnt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_transactions` */

/*Table structure for table `products_description` */

DROP TABLE IF EXISTS `products_description`;

CREATE TABLE `products_description` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `viewed` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `products_description` */

/*Table structure for table `purchase_order` */

DROP TABLE IF EXISTS `purchase_order`;

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `po_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `vendor_person_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `payment_term` varchar(250) NOT NULL,
  `payment_days` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `comments` text NOT NULL,
  `sales_tax` int(11) NOT NULL,
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  `full_json` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchase_order` */

/*Table structure for table `purchase_order_items` */

DROP TABLE IF EXISTS `purchase_order_items`;

CREATE TABLE `purchase_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `weight` float NOT NULL,
  `price` float NOT NULL,
  `price_type` enum('po_date','grn_date','fixed') NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `full_json` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchase_order_items` */

/*Table structure for table `purchase_return` */

DROP TABLE IF EXISTS `purchase_return`;

CREATE TABLE `purchase_return` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refund_grn_id` int(11) DEFAULT NULL,
  `used_grn_id` int(11) DEFAULT NULL,
  `used` tinyint(1) DEFAULT NULL,
  `used_amount` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_json` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `purchase_return` */

insert  into `purchase_return`(`id`,`refund_grn_id`,`used_grn_id`,`used`,`used_amount`,`created_at`,`amount`,`user_id`,`full_json`) values (4,0,NULL,NULL,NULL,'2012-07-19 16:32:33','122.00',3,'{\"tab\":\"purchase_return\",\"selected_products\":[{\"item_entity_id\":\"26\",\"item_specific_id\":\"30\",\"grn_item_id\":null,\"quantity\":\"1\",\"weight\":0,\"price\":\"122\",\"name\":\"Lip Gloss-Lakme\",\"vat_percentage\":\"5\",\"vat\":6.1,\"final_amount\":128.1}],\"total_purchase_return\":122}');

/*Table structure for table `purchase_return_item` */

DROP TABLE IF EXISTS `purchase_return_item`;

CREATE TABLE `purchase_return_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` bigint(20) DEFAULT NULL,
  `purchase_return_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,3) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `vat` decimal(10,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `purchase_return_item` */

insert  into `purchase_return_item`(`id`,`item_entity_id`,`item_specific_id`,`purchase_return_id`,`quantity`,`price`,`vat`,`final_amount`,`branch_id`) values (2,26,30,4,'1.000','122.00','6.10','128.10',1);

/*Table structure for table `rate` */

DROP TABLE IF EXISTS `rate`;

CREATE TABLE `rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_entity_id` int(11) NOT NULL DEFAULT '1',
  `item_specific_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `price` float NOT NULL,
  `unit` varchar(10) NOT NULL DEFAULT 'g',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rate` */

/*Table structure for table `rent` */

DROP TABLE IF EXISTS `rent`;

CREATE TABLE `rent` (
  `id` int(11) NOT NULL,
  `rent_product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deposit` float NOT NULL,
  `days_return` int(11) NOT NULL,
  `advance_paid` float NOT NULL,
  `settlement_amt` float NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rent` */

insert  into `rent`(`id`,`rent_product_id`,`customer_id`,`date`,`deposit`,`days_return`,`advance_paid`,`settlement_amt`,`status`) values (1,1,1,'2012-05-02 15:07:07',10,10,100,200,1),(2,1,1,'2012-05-02 15:07:07',20,20,200,400,1),(3,1,1,'2012-05-02 15:07:07',20,10,200,100,1);

/*Table structure for table `rent_booking` */

DROP TABLE IF EXISTS `rent_booking`;

CREATE TABLE `rent_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `noofdays` int(11) NOT NULL,
  `total_rent` float NOT NULL,
  `deposit` float NOT NULL,
  `total_negotiation` float NOT NULL,
  `bill_amount` float NOT NULL,
  `ordertype` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `rent_booking` */

insert  into `rent_booking`(`id`,`customer_id`,`delivery_date`,`noofdays`,`total_rent`,`deposit`,`total_negotiation`,`bill_amount`,`ordertype`) values (1,1,'2012-05-25',1,330,0,0,0,1),(2,1,'2012-05-25',1,330,1000,320,680,3),(3,1,'2012-05-22',3,990,500,0,0,1),(4,1,'2012-05-25',1,430,0,0,0,1),(5,1,'2012-05-25',1,340,1000,0,0,2),(6,1,'2012-05-25',1,230,0,0,0,1),(7,1,'2012-05-25',3,600,1000,24,976,3),(8,1,'2012-05-26',1,200,1000,0,0,2),(9,1,'2012-05-26',1,550,2000,30,1970,3),(10,1,'2012-05-25',1,230,0,0,0,1),(11,1,'2012-05-25',1,230,0,0,0,1),(12,1,'2012-05-29',2,520,1000,13,987,3),(13,0,'2012-07-31',14,33600,15000,0,0,1),(14,1,'2012-07-09',2,4800,4000,0,0,1);

/*Table structure for table `rent_booking_component` */

DROP TABLE IF EXISTS `rent_booking_component`;

CREATE TABLE `rent_booking_component` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `rent_price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `negotiated_amt` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

/*Data for the table `rent_booking_component` */

insert  into `rent_booking_component`(`id`,`booking_id`,`product_id`,`component_id`,`rent_price`,`quantity`,`negotiated_amt`) values (1,2,2,1,100,1,100),(2,2,2,4,100,1,10),(3,2,2,5,30,1,100),(4,2,1,4,100,1,100),(5,3,2,1,100,1,0),(6,3,2,4,100,1,0),(7,3,2,5,30,1,0),(8,3,1,4,100,1,0),(9,2,1,1,100,1,10),(10,5,4,6,100,1,0),(11,5,4,7,120,1,0),(12,5,4,8,20,1,0),(13,5,4,3,100,1,0),(14,6,2,4,100,1,0),(15,6,2,5,30,1,0),(16,6,2,1,100,1,0),(17,7,1,4,100,1,12),(18,7,1,1,100,1,12),(19,8,1,4,100,1,0),(20,8,3,1,100,1,0),(21,8,3,2,50,1,0),(22,8,3,3,100,1,0),(23,9,2,4,100,2,6),(24,9,2,5,30,1,6),(25,9,2,1,100,1,6),(26,9,1,8,20,1,6),(27,9,1,3,100,2,6),(28,10,2,4,100,1,0),(29,10,2,5,30,1,0),(30,10,2,1,100,1,0),(31,11,2,4,100,1,0),(32,11,2,5,30,1,0),(33,11,2,1,100,1,0),(34,12,3,1,100,1,10),(35,12,3,2,50,1,1),(36,12,3,3,100,1,1),(37,12,3,11,10,1,1),(38,13,1,15,200,12,0),(39,14,1,15,200,12,0);

/*Table structure for table `rent_booking_product` */

DROP TABLE IF EXISTS `rent_booking_product`;

CREATE TABLE `rent_booking_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rent_booking_product` */

/*Table structure for table `rent_category` */

DROP TABLE IF EXISTS `rent_category`;

CREATE TABLE `rent_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `rent_category` */

insert  into `rent_category`(`id`,`category_name`,`created_date`,`user_id`,`parent_id`,`status`) values (2,'Category 2','2012-05-10 16:08:19',2,2,0),(3,'Category 3','2012-05-10 15:36:07',2,2,1),(4,'Category 4','2012-05-01 15:49:49',2,2,1),(5,'Category 5','2012-05-10 15:36:15',2,2,1),(6,'Category 6','2012-05-01 17:14:25',2,3,1),(7,'Category 7','2012-05-01 17:14:36',2,4,1),(8,'Category 8','2012-05-10 15:36:15',2,2,1),(9,'Category 9','2012-05-10 15:36:22',2,2,1),(10,'Category 10','2012-05-10 16:08:06',2,2,0),(11,'Category 11','2012-05-10 16:08:16',2,5,0),(12,'Category 97','2012-05-10 15:37:35',0,6,1),(13,'Category1','2012-05-10 15:37:35',2,2,1),(14,'Category2','2012-05-10 15:37:36',2,4,1),(15,'Category3','2012-05-10 15:37:37',2,7,1);

/*Table structure for table `rent_component_stock` */

DROP TABLE IF EXISTS `rent_component_stock`;

CREATE TABLE `rent_component_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rent_component_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `rent_component_stock` */

insert  into `rent_component_stock`(`id`,`rent_component_id`,`quantity`) values (1,1,8),(2,2,20),(3,3,11),(4,4,18),(5,5,9),(6,6,11),(7,7,11),(8,8,21),(9,13,10),(10,14,10),(11,15,5),(12,16,10);

/*Table structure for table `rent_component_transaction` */

DROP TABLE IF EXISTS `rent_component_transaction`;

CREATE TABLE `rent_component_transaction` (
  `id` int(11) NOT NULL,
  `rent_transaction_id` int(11) NOT NULL,
  `product_component_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flow` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rent_component_transaction` */

/*Table structure for table `rent_components` */

DROP TABLE IF EXISTS `rent_components`;

CREATE TABLE `rent_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rent_price` float NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `rent_components` */

insert  into `rent_components`(`id`,`name`,`quantity`,`rent_price`,`status`) values (1,'Pyjama',10,100,1),(2,'Turban',10,50,1),(3,'Shoes',10,100,1),(4,'Kurta',10,100,1),(5,'Beard',10,30,1),(6,'jacket',10,100,1),(7,'trouser',10,120,1),(8,'belt',10,20,1),(11,'tie',10,10,0),(12,'cuffs',10,20,0),(13,'Watches',10,100,1),(14,'Raymond Tie',10,100,1),(15,'White Shirt',5,200,1),(16,'item 1',10,60,1);

/*Table structure for table `rent_estimate` */

DROP TABLE IF EXISTS `rent_estimate`;

CREATE TABLE `rent_estimate` (
  `id` int(11) NOT NULL,
  `rent_component_id` int(11) NOT NULL,
  `rent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rent_estimate` */

/*Table structure for table `rent_invoice_components` */

DROP TABLE IF EXISTS `rent_invoice_components`;

CREATE TABLE `rent_invoice_components` (
  `id` int(11) NOT NULL,
  `rent_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rent_invoice_components` */

/*Table structure for table `rent_invoice_product` */

DROP TABLE IF EXISTS `rent_invoice_product`;

CREATE TABLE `rent_invoice_product` (
  `id` int(11) NOT NULL,
  `rent_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `negotiated_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rent_invoice_product` */

/*Table structure for table `rent_order` */

DROP TABLE IF EXISTS `rent_order`;

CREATE TABLE `rent_order` (
  `id` int(11) NOT NULL,
  `rent_product_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `advance` float NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `rent_negotiated` float NOT NULL,
  `deposit_negotiated` float NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rent_order` */

insert  into `rent_order`(`id`,`rent_product_id`,`date`,`advance`,`no_of_days`,`rent_negotiated`,`deposit_negotiated`,`status`) values (1,1,'2012-05-02 15:07:07',10,10,10,10,1),(2,2,'2012-05-03 15:50:00',10,10,10,10,1);

/*Table structure for table `rent_payment` */

DROP TABLE IF EXISTS `rent_payment`;

CREATE TABLE `rent_payment` (
  `id` int(11) NOT NULL,
  `rent_id` int(11) NOT NULL,
  `amount_paid` float NOT NULL,
  `settle_amt` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rent_payment` */

insert  into `rent_payment`(`id`,`rent_id`,`amount_paid`,`settle_amt`,`created_date`) values (1,1,100,100,'2012-05-02 15:07:07'),(2,2,100,200,'2012-05-02 15:07:07'),(3,3,100,200,'2012-05-02 15:07:07');

/*Table structure for table `rent_product` */

DROP TABLE IF EXISTS `rent_product`;

CREATE TABLE `rent_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `purchase_price` float NOT NULL,
  `rent_price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `deposit` float NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `rent_product` */

insert  into `rent_product`(`id`,`product_name`,`description`,`purchase_date`,`purchase_price`,`rent_price`,`quantity`,`category_id`,`deposit`,`status`) values (1,'Misc','Description','2012-05-22 16:44:24',0,123,0,5,0,0),(2,'Gujarati','Description Description Description Description Description Description ','0000-00-00 00:00:00',0,500,0,5,0,1),(3,'Punjabi','Description Description Description Description ','2012-05-21 08:28:44',0,500,0,13,0,1),(4,'Suit','Description Description','2012-05-22 15:18:13',0,500,0,7,0,1);

/*Table structure for table `rent_product_component_relation` */

DROP TABLE IF EXISTS `rent_product_component_relation`;

CREATE TABLE `rent_product_component_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `rent_product_component_relation` */

insert  into `rent_product_component_relation`(`id`,`component_id`,`product_id`) values (1,1,1),(2,2,1),(3,3,1),(4,4,2),(5,5,2),(6,1,2),(7,1,3),(8,2,3),(9,3,3),(10,6,4),(11,7,4),(12,8,4),(14,3,4),(18,9,1),(20,10,1),(32,11,3),(33,13,1);

/*Table structure for table `rent_product_stock` */

DROP TABLE IF EXISTS `rent_product_stock`;

CREATE TABLE `rent_product_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rent_product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `rent_product_stock` */

insert  into `rent_product_stock`(`id`,`rent_product_id`,`quantity`) values (1,1,10),(2,1,10);

/*Table structure for table `rent_transaction` */

DROP TABLE IF EXISTS `rent_transaction`;

CREATE TABLE `rent_transaction` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `flow` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rent_transaction` */

/*Table structure for table `scheme` */

DROP TABLE IF EXISTS `scheme`;

CREATE TABLE `scheme` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `min_installment` float NOT NULL,
  `terms` int(11) NOT NULL,
  `duration_months` int(11) NOT NULL,
  `adv_type` varchar(50) NOT NULL,
  `flexible` tinyint(4) DEFAULT NULL,
  `bonus_installments` float DEFAULT NULL,
  `making_cost_disc` float DEFAULT NULL,
  `making_cost_disc_limit` float DEFAULT NULL,
  `wastage_cost_disc` float DEFAULT NULL,
  `wastage_cost_disc_limit` float DEFAULT NULL,
  `rate_adv` varchar(20) DEFAULT NULL,
  `rate_item_entity_id` int(11) NOT NULL,
  `rate_item_specific_id` bigint(20) NOT NULL,
  `vat_discount` tinyint(4) DEFAULT NULL,
  `vat_discount_limit` float DEFAULT NULL,
  `referal_bonus_percent` int(11) NOT NULL,
  `Comments` text,
  `delete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `scheme` */

/*Table structure for table `scheme_referal` */

DROP TABLE IF EXISTS `scheme_referal`;

CREATE TABLE `scheme_referal` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `paid_by` varchar(10) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `scheme_referal` */

/*Table structure for table `scheme_transaction` */

DROP TABLE IF EXISTS `scheme_transaction`;

CREATE TABLE `scheme_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scheme_user_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `installment_number` int(10) unsigned NOT NULL,
  `paid_amount` float DEFAULT '0',
  `by_cash` float NOT NULL,
  `by_card` float NOT NULL,
  `card_last_digits` int(11) NOT NULL,
  `flow` enum('in','out') NOT NULL,
  `status` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `scheme_transaction` */

/*Table structure for table `scheme_user` */

DROP TABLE IF EXISTS `scheme_user`;

CREATE TABLE `scheme_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) NOT NULL,
  `scheme_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `start_amount` float NOT NULL,
  `last_paid_date` date NOT NULL,
  `installments_paid` int(11) NOT NULL,
  `next_payment_date` date NOT NULL,
  `paid_amount` float NOT NULL,
  `accumulated_amount` float NOT NULL,
  `accumulated_quantity` float NOT NULL DEFAULT '0',
  `net_amount` float NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `scheme_referal_id` bigint(20) DEFAULT NULL,
  `comments` text,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `scheme_user` */

/*Table structure for table `stock_lock` */

DROP TABLE IF EXISTS `stock_lock`;

CREATE TABLE `stock_lock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lock_type` tinyint(1) DEFAULT '1',
  `central_stock_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,3) DEFAULT NULL,
  `locked_on` datetime DEFAULT NULL,
  `lock_valid_till` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `stock_lock` */

/*Table structure for table `stock_outward` */

DROP TABLE IF EXISTS `stock_outward`;

CREATE TABLE `stock_outward` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `description` text,
  `issued_at` datetime DEFAULT NULL,
  `expected_return` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `person_incharge` varchar(40) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `status` enum('issued','returned','cancelled','finalized') DEFAULT NULL,
  `full_json` text,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `stock_outward` */

insert  into `stock_outward`(`id`,`name`,`description`,`issued_at`,`expected_return`,`user_id`,`person_incharge`,`branch_id`,`status`,`full_json`,`deleted`) values (1,'Test','Test Description','2012-07-26 12:04:54','2012-07-27 12:04:58',1,'Ramesh',1,'issued','Nothin to display right now.',0);

/*Table structure for table `stock_outward_item` */

DROP TABLE IF EXISTS `stock_outward_item`;

CREATE TABLE `stock_outward_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_outward_id` int(11) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `weight` decimal(10,3) DEFAULT NULL,
  `quantity_returned` decimal(10,3) DEFAULT '0.000',
  `weight_returned` decimal(10,3) DEFAULT '0.000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `stock_outward_item` */

/*Table structure for table `stone` */

DROP TABLE IF EXISTS `stone`;

CREATE TABLE `stone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `carat_weight` float DEFAULT NULL,
  `shape` varchar(20) NOT NULL,
  `color` varchar(50) NOT NULL,
  `clarity` varchar(50) NOT NULL,
  `cut` varchar(50) NOT NULL,
  `grid_length` float NOT NULL,
  `grid_width` float NOT NULL,
  `grid_depth` float NOT NULL,
  `type` enum('diamond','gemstone','stone') NOT NULL,
  `category_id` int(11) NOT NULL,
  `rate_per_gram` float DEFAULT '0',
  `unit` enum('g','kg') NOT NULL DEFAULT 'g',
  `purchase_price` float DEFAULT NULL,
  `profit_margin` float DEFAULT NULL,
  `is_old` tinyint(4) DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `stone` */

/*Table structure for table `sub_transaction` */

DROP TABLE IF EXISTS `sub_transaction`;

CREATE TABLE `sub_transaction` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) unsigned NOT NULL,
  `item_entity_id` int(10) unsigned DEFAULT NULL,
  `item_specific_id` int(10) unsigned DEFAULT NULL,
  `weight` float DEFAULT '0',
  `quantity` int(11) DEFAULT '0',
  `weight_before` float DEFAULT '0',
  `quantity_before` int(11) DEFAULT '0',
  `weight_after` float DEFAULT '0',
  `quantity_after` int(11) DEFAULT '0',
  `reference_id` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sub_transaction` */

/*Table structure for table `super_central_stock` */

DROP TABLE IF EXISTS `super_central_stock`;

CREATE TABLE `super_central_stock` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` bigint(20) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `additional` varchar(100) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `super_central_stock` */

/*Table structure for table `super_transaction` */

DROP TABLE IF EXISTS `super_transaction`;

CREATE TABLE `super_transaction` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) DEFAULT NULL,
  `item_entity_id` int(11) DEFAULT NULL,
  `item_specific_id` bigint(20) DEFAULT NULL,
  `weight` float DEFAULT '0',
  `quantity` int(11) DEFAULT '0',
  `weight_before` float DEFAULT '0',
  `quantity_before` int(11) DEFAULT '0',
  `weight_after` float DEFAULT '0',
  `quantity_after` int(11) DEFAULT '0',
  `reference_id` varchar(50) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `super_transaction` */

/*Table structure for table `tabs` */

DROP TABLE IF EXISTS `tabs`;

CREATE TABLE `tabs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `identifier` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  `class_css` varchar(250) NOT NULL,
  `index` int(5) NOT NULL,
  `p_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `tabs` */

insert  into `tabs`(`id`,`title`,`identifier`,`url`,`description`,`class_css`,`index`,`p_id`) values (1,'Billing','billing','invoice',' ','',1,0),(2,'Purchases','purchases','po',' ','',2,0),(3,'Inventory','inventory','inventory',' ',' ',3,0),(4,'Renting','renting','rent',' ',' ',4,0),(5,'Admin','users','manage_users',' ',' ',5,0),(6,'New Invoice','new_invoice','invoice/new_invoice',' ','icon-new-invoice',1,1),(7,'Exchange','sales_return','invoice/exchange',' ','icon-sales-return',2,1),(8,'Search Invoice','search_invoice','invoice/search',' ','icon-search-invoice',3,1),(9,'Purchase Order','purchase_order','po',' ','icon-purchase-order',1,2),(10,'Goods Received Note','goods_recieved_note','grn',' ','icon-goods-received-note',2,2),(11,'Manage Vendors','manage_vendors','vendor',' ',' icon-manage-vendors',3,2),(12,'Manage Brands','manage_brands','brand',' ','icon-manage-brands',4,2),(13,'Manage Category','manage_category','category',' ','icon-manage-categories',5,2),(14,'Manage Classification','manage_classification','classification','  ','icon-manage-categories',7,2),(15,'Manage Products','manage_products','product',' ','icon-manage-products',8,2),(16,'Stock','inventory_stock','inventory/stock',' ',' icon-inventory-stock',1,3),(17,'Reports','inventory_reports','inventory/reports',' ','icon-inventory-reports',2,3),(18,'Manage Products','rent_manage_products','rent/manageProducts',' ',' ',1,4),(19,'Manage Components','rent_manage_components','rent/manageComponents',' ',' ',2,4),(20,'Manage Category','rent_manage_category','rent/manageCategory',' ',' ',3,4),(21,'Bookings','rent_bookings','rent/manageOrders',' ',' ',4,4),(22,'Pickup','rent_pickup','rent/pickup',' ',' ',5,4),(23,'Reports','rent_reports','rent/transactionReports',' ',' ',6,4),(24,'Invoice','rent_invoice','rent/invoice',' ',' ',7,4),(25,'Stock','rent_stock','rent/displayComponentsStock',' ',' ',8,4),(26,'Manage Users','manage_users','manage_users/user',' ',' ',1,5),(27,'Manage Groups','manage_access_groups','manage_users/group',' ',' ',2,5),(28,'Opening Stock','opening_stock','inventory/opening_stock',' ',' ',5,3),(29,'Purchase Returns','purchase_returns','purchase_returns',' ',' ',9,2),(30,'Stock Ledger ','stock_ledger','inventory/stock_ledger_report','','',4,3),(31,'Manage Attributes','manage_attributes','attribute',' ',' ',6,2),(32,'Gift vouchers','vouchers','vouchers',' ',' ',3,5),(33,'Stock Outward','stock_outward','stock_admin',' ',' ',4,3);

/*Table structure for table `tax` */

DROP TABLE IF EXISTS `tax`;

CREATE TABLE `tax` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `display_name` varchar(40) DEFAULT NULL,
  `rate_type` enum('fixed','percent') DEFAULT 'percent',
  `rate_value` decimal(2,2) DEFAULT NULL,
  `min_applicable_amt` decimal(10,2) DEFAULT NULL,
  `min_value` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tax` */

/*Table structure for table `transaction` */

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `central_stock_id` bigint(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `quantity` float NOT NULL,
  `weight` float DEFAULT NULL,
  `quantity_before` float NOT NULL,
  `quantity_after` float NOT NULL,
  `weight_before` float NOT NULL,
  `weight_after` float NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `additional` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `transaction` */

/*Table structure for table `user_group` */

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `user_group` */

insert  into `user_group`(`id`,`user_id`,`group_id`) values (1,1,1),(2,2,2),(3,3,1),(4,4,1),(5,5,1),(6,6,2);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `access_level` tinyint(4) NOT NULL,
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL DEFAULT '1',
  `access_json` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`name`,`phone`,`access_level`,`manager_id`,`branch_id`,`access_json`,`created_by`,`created_at`,`deleted`) values (1,'langoorbiz','biz43langoor','Langoor','7411350398',0,0,1,'  ',0,'2012-06-29 18:48:14',0),(2,'langoorbilling','biz43langoor','Sandeep Gunduboyina','7411350398',0,1,1,'',0,'2012-06-30 21:20:54',0),(3,'shringar','shringar','Mahindra Shringar','7411350398',0,1,1,'',0,'2012-07-02 18:06:45',0),(4,'test','test','Test Test','7411350398',0,1,1,'',0,'2012-07-02 18:07:32',0),(5,'admin','admin','Administrator Admin','7411350398',0,1,1,'',0,'2012-07-02 18:08:17',0),(6,'sivasai','sivasai','Siva Sai Janapati','8147840641',0,1,1,'',0,'2012-07-05 23:48:01',0);

/*Table structure for table `vendor_person` */

DROP TABLE IF EXISTS `vendor_person`;

CREATE TABLE `vendor_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `contact_name` varchar(250) NOT NULL,
  `contact_phone` varchar(250) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vendor_person` */

/*Table structure for table `vendors` */

DROP TABLE IF EXISTS `vendors`;

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(250) NOT NULL,
  `main_person_name` varchar(250) NOT NULL,
  `phone1` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(250) NOT NULL,
  `pin` varchar(25) NOT NULL,
  `phone2` varchar(250) NOT NULL,
  `mobile` varchar(250) NOT NULL,
  `comments` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name` (`company_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vendors` */

/*Table structure for table `voucher` */

DROP TABLE IF EXISTS `voucher`;

CREATE TABLE `voucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `voucher_config_id` int(11) NOT NULL,
  `used_bill_id` int(11) NOT NULL DEFAULT '0',
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `used_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `manager_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `printed_times` tinyint(1) DEFAULT '0',
  `valid_till` datetime DEFAULT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `voucher` */

/*Table structure for table `voucher_config` */

DROP TABLE IF EXISTS `voucher_config`;

CREATE TABLE `voucher_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `validity_days` int(11) DEFAULT NULL,
  `min_value` decimal(10,2) DEFAULT NULL,
  `max_value` decimal(10,2) DEFAULT NULL,
  `multiple_of` decimal(10,2) DEFAULT NULL,
  `value_set` text,
  `description` text,
  `user_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `voucher_config` */

insert  into `voucher_config`(`id`,`name`,`validity_days`,`min_value`,`max_value`,`multiple_of`,`value_set`,`description`,`user_id`,`deleted`) values (1,'Gift Voucher',90,'100.00','10000.00','100.00',NULL,NULL,1,0),(2,'sdafsdf',NULL,'232.00','2313.00','2323.00','[\"\"]','sdvdfg',3,0),(3,'ertwertf',NULL,'0.00','0.00','0.00','[\"1213\",\"132123\",\"13321\"]','sdfsf',3,0),(4,'sdfasf',NULL,'0.00','0.00','0.00','123123,123123,123123,1231','sdfdf',3,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
