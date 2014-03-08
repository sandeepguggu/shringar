/*
SQLyog Ultimate v9.51 
MySQL - 5.5.20-log : Database - alice_gold
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`alice_gold` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `alice_gold`;

/*Table structure for table `access_levels` */

DROP TABLE IF EXISTS `access_levels`;

CREATE TABLE `access_levels` (
  `function` varchar(20) NOT NULL,
  `access_level` tinyint(4) NOT NULL,
  UNIQUE KEY `function` (`function`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `access_levels` */

insert  into `access_levels`(`function`,`access_level`) values ('exchange',2),('grn',3),('invoice',1),('po',3),('product',3);

/*Table structure for table `bill` */

DROP TABLE IF EXISTS `bill`;

CREATE TABLE `bill` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `paid_by_cash` float NOT NULL DEFAULT '0',
  `paid_by_card` float NOT NULL DEFAULT '0',
  `customer_id` bigint(20) unsigned NOT NULL,
  `discount_type` varchar(250) NOT NULL,
  `discount_value` float NOT NULL DEFAULT '0',
  `vat_amount` float DEFAULT NULL,
  `vat_discount` float NOT NULL DEFAULT '0',
  `total_amount` float NOT NULL DEFAULT '0',
  `final_amount` float NOT NULL DEFAULT '0',
  `paid_by_scheme` float NOT NULL DEFAULT '0',
  `scheme_user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `branch` */

insert  into `branch`(`id`,`name`,`address`,`phone1`,`phone2`,`mobile`,`deleted`) values (1,'MG Road','#417, MG Road\r\nBangalore','12333','1233331','12344',0),(2,'Jayanagar','#301, 10th Main\r\nJayanagar','555','666','55566',0);

/*Table structure for table `brand` */

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `brand` */

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `vat_percentage` float NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`id`,`name`,`vat_percentage`,`created_at`,`user_id`,`parent_id`,`deleted`) values (1,'ROOT',0,'2012-04-04 11:46:49',1,0,0),(2,'Ornament',2,'2012-04-04 11:46:58',1,1,0),(3,'Bullion',1,'2012-04-04 11:47:05',1,1,0);

/*Table structure for table `central_stock` */

DROP TABLE IF EXISTS `central_stock`;

CREATE TABLE `central_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `weight` float DEFAULT NULL,
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

/*Table structure for table `credit_note` */

DROP TABLE IF EXISTS `credit_note`;

CREATE TABLE `credit_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `refund_bill_id` int(11) NOT NULL,
  `used_bill_id` int(11) NOT NULL DEFAULT '0',
  `used` tinyint(4) NOT NULL DEFAULT '0',
  `used_amount` float NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `manager_user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` float NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bill_id` (`refund_bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `credit_note` */

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
  `paid_by_cash` float NOT NULL DEFAULT '0',
  `paid_by_card` float NOT NULL DEFAULT '0',
  `paid_by_scheme` float NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `discount_type` varchar(250) NOT NULL,
  `discount_value` float NOT NULL DEFAULT '0',
  `vat_amount` float DEFAULT NULL,
  `total_amount` float NOT NULL DEFAULT '0',
  `final_amount` float NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `item_entity` */

insert  into `item_entity`(`id`,`name`,`display_name`,`table_name`,`is_header`,`product_entity_id`,`barcode_only`,`mfg_barcode`,`old_purchase`,`is_composite`,`is_subtype`,`deleted`) values (1,'metal','Metal',NULL,0,NULL,0,NULL,1,0,0,0),(2,'stone','Stone',NULL,0,NULL,0,NULL,1,0,0,0),(3,'ornament','Ornament',NULL,1,5,0,NULL,0,1,0,0),(4,'old_ornament','Old Ornament',NULL,0,NULL,0,NULL,0,0,0,1),(5,'ornament_product','Ornament Product',NULL,0,NULL,0,1,0,1,1,0),(6,'bill','Bill',NULL,0,NULL,1,0,0,0,0,0),(7,'branch','',NULL,0,NULL,1,NULL,0,0,0,0),(8,'brand','Brand',NULL,0,NULL,1,NULL,0,0,0,0),(9,'category','Category',NULL,0,NULL,1,NULL,0,0,0,0),(10,'credit_note','Credit Note',NULL,0,NULL,1,NULL,0,0,0,0),(11,'customers','Customer',NULL,0,NULL,1,NULL,0,0,0,0),(12,'estimate','Estimate',NULL,0,NULL,1,NULL,0,0,0,0),(13,'goldsmith','Goldsmith',NULL,0,NULL,1,NULL,0,0,0,0),(14,'jobsheet_issued','Job Sheet',NULL,0,NULL,1,NULL,0,0,0,0),(15,'jobsheet_returned','Job Work Receipt',NULL,0,NULL,1,NULL,0,0,0,0),(16,'products','Product',NULL,0,NULL,1,1,0,0,0,0),(17,'po','Purchase Order','purchase_order',0,NULL,1,0,0,0,0,0),(18,'scheme','Scheme',NULL,0,NULL,1,0,0,0,0,0),(19,'scheme_invoice','Scheme Installment Invoice',NULL,0,NULL,1,0,0,0,0,0),(20,'user','User',NULL,0,NULL,1,0,0,0,0,0),(21,'vendor','Vendor',NULL,0,NULL,1,0,0,0,0,0),(22,'grn','Goods Receive Note','product_receive_note',0,NULL,1,0,0,0,0,0),(23,'old_purchase_bill','Purchase Bill','old_purchase_bill',0,NULL,1,NULL,0,0,0,0),(24,'customer_order','Customer Order','customer_order',0,NULL,1,NULL,0,0,0,0);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `metal` */

insert  into `metal`(`id`,`name`,`karat`,`fineness`,`type`,`category_id`,`unit`,`is_old`,`low_threshold`,`high_threshold`,`deleted`) values (1,'Gold 916 KDM (91.6)',22,916,'gold',3,'g',NULL,0,-1,0),(2,'Gold White (860)',18,860,'gold',3,'g',NULL,0,-1,0);

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
  `quantity` int(11) NOT NULL,
  `weight` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `purchase_price` float NOT NULL,
  `branch_id` int(11) NOT NULL,
  `max_qnt` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `product_receive_note_id` (`product_receive_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_receive_note_items` */

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

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sell_price` float NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `item_entity_id` int(11) NOT NULL,
  `item_specific_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `mfg_barcode` varchar(50) DEFAULT NULL,
  `custom_barcode` varchar(50) NOT NULL,
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  `attr1` varchar(250) NOT NULL,
  `attr2` varchar(250) NOT NULL,
  `attr3` varchar(250) NOT NULL,
  `attr4` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `custom_barcode` (`custom_barcode`),
  UNIQUE KEY `mfg_barcode` (`mfg_barcode`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`),
  KEY `registered_bar_code` (`mfg_barcode`,`custom_barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `products` */

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `rate` */

insert  into `rate`(`id`,`item_entity_id`,`item_specific_id`,`updated_at`,`price`,`unit`) values (1,1,6,'2012-03-05 13:30:12',2344.2,'g'),(2,2,6,'2012-04-02 18:20:23',134,'g'),(3,2,6,'2012-04-03 13:48:53',566,'g'),(4,2,6,'2012-04-03 14:26:18',122,'g');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `scheme` */

insert  into `scheme`(`id`,`name`,`min_installment`,`terms`,`duration_months`,`adv_type`,`flexible`,`bonus_installments`,`making_cost_disc`,`making_cost_disc_limit`,`wastage_cost_disc`,`wastage_cost_disc_limit`,`rate_adv`,`rate_item_entity_id`,`rate_item_specific_id`,`vat_discount`,`vat_discount_limit`,`referal_bonus_percent`,`Comments`,`delete`) values (1,'AGSS II',1000,1,18,'Avg Rate, One installment',0,1,1,1,1,1,'Yes',1,6,1,1,10,'Yeah',0);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `stone` */

insert  into `stone`(`id`,`name`,`carat_weight`,`shape`,`color`,`clarity`,`cut`,`grid_length`,`grid_width`,`grid_depth`,`type`,`category_id`,`rate_per_gram`,`unit`,`purchase_price`,`profit_margin`,`is_old`,`deleted`) values (1,'Ruby small 4ct - 14ct',NULL,'','','','',0,0,0,'stone',3,0,'g',NULL,NULL,0,0);

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
  `deteted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`name`,`phone`,`access_level`,`manager_id`,`branch_id`,`access_json`,`created_by`,`created_at`,`deteted`) values (1,'pratik','pratik','Kumar Pratik','9535052086',3,0,1,'',0,'2011-12-06 16:38:17',0),(2,'rajat','rajat','Rajat Garg','8050098813',10,0,2,'a',0,'2012-04-01 12:57:09',0),(3,'admin','admin','Alice','0802569914',10,0,1,'',0,'2012-04-02 11:04:51',0);

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
