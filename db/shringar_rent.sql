/*
SQLyog Enterprise Trial - MySQL GUI v7.11 
MySQL - 5.5.8 : Database - shringar
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`shringar` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `shringar`;

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
  `delivery_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `noofdays` int(11) NOT NULL,
  `total_rent` float NOT NULL,
  `advance_amount` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `rent_booking` */

insert  into `rent_booking`(`id`,`customer_id`,`delivery_date`,`noofdays`,`total_rent`,`advance_amount`) values (1,0,'2012-05-18 19:38:18',1,800,0),(2,0,'0000-00-00 00:00:00',2,800,0),(3,0,'2012-05-18 19:38:14',3,460,0);

/*Table structure for table `rent_booking_component` */

DROP TABLE IF EXISTS `rent_booking_component`;

CREATE TABLE `rent_booking_component` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `rent_booking_component` */

insert  into `rent_booking_component`(`id`,`booking_id`,`product_id`,`component_id`,`quantity`) values (1,1,2,1,1),(2,1,2,2,1),(3,1,2,3,1),(4,2,2,1,1),(5,2,2,2,1),(6,2,2,3,1),(7,2,1,4,1),(8,2,1,2,1),(9,3,1,1,1),(10,3,1,4,1),(11,3,1,5,1);

/*Table structure for table `rent_booking_product` */

DROP TABLE IF EXISTS `rent_booking_product`;

CREATE TABLE `rent_booking_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rent_price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `rent_booking_product` */

insert  into `rent_booking_product`(`id`,`booking_id`,`product_id`,`quantity`,`rent_price`) values (1,1,1,1,250),(2,2,1,1,250),(3,3,2,1,230);

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

/*Data for the table `rent_component_stock` */

insert  into `rent_component_stock`(`id`,`rent_component_id`,`quantity`) values (1,1,10),(2,2,20),(3,3,5),(4,4,43),(5,5,4),(6,6,11),(7,7,10),(8,8,20),(9,28,10),(10,29,10),(11,1,10),(12,2,10),(13,3,10),(14,1,10),(15,2,10),(16,3,10),(17,1,10),(18,2,10),(19,3,10),(20,1,10),(21,2,10),(22,3,10),(23,4,10),(24,5,10),(25,6,10),(26,7,10),(27,8,10),(28,9,10),(29,10,10),(30,4,10),(31,5,10),(32,6,10),(33,7,10),(34,8,10),(35,1,10),(36,2,10),(37,3,10),(38,4,10),(39,5,10);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `rent_components` */

insert  into `rent_components`(`id`,`name`,`quantity`,`rent_price`,`status`) values (1,'Pyjama',10,100,1),(2,'Turban',10,50,1),(3,'Shoes',10,100,1),(4,'Kurta',10,100,1),(5,'Beard',10,30,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `rent_product` */

insert  into `rent_product`(`id`,`product_name`,`description`,`purchase_date`,`purchase_price`,`rent_price`,`quantity`,`category_id`,`deposit`,`status`) values (1,'Misc','Description','2012-05-21 08:28:47',0,0,0,1,0,1),(2,'Gujarati','Description Description Description Description Description Description ','2012-05-18 11:15:59',0,500,0,5,0,1),(3,'Punjabi','Description Description Description Description ','2012-05-21 08:28:44',0,500,0,13,0,1);

/*Table structure for table `rent_product_component_relation` */

DROP TABLE IF EXISTS `rent_product_component_relation`;

CREATE TABLE `rent_product_component_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `rent_product_component_relation` */

insert  into `rent_product_component_relation`(`id`,`component_id`,`product_id`) values (1,1,1),(2,2,1),(3,3,1),(4,4,2),(5,5,2),(6,1,2);

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
