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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`shringar` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `shringar`;

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `item_entity` */

insert  into `item_entity`(`id`,`name`,`display_name`,`table_name`,`is_header`,`product_entity_id`,`barcode_only`,`mfg_barcode`,`old_purchase`,`is_composite`,`is_subtype`,`deleted`) values (1,'metal','Metal',NULL,0,NULL,0,NULL,1,0,0,0),(2,'stone','Stone',NULL,0,NULL,0,NULL,1,0,0,0),(3,'ornament','Ornament',NULL,1,5,0,NULL,0,1,0,0),(4,'old_ornament','Old Ornament',NULL,0,NULL,0,NULL,0,0,0,1),(5,'ornament_product','Ornament Product',NULL,0,NULL,0,1,0,1,1,0),(6,'bill','Bill',NULL,0,NULL,1,0,0,0,0,0),(7,'branch','',NULL,0,NULL,1,NULL,0,0,0,0),(8,'brand','Brand',NULL,0,NULL,1,NULL,0,0,0,0),(9,'category','Category',NULL,0,NULL,1,NULL,0,0,0,0),(10,'credit_note','Credit Note',NULL,0,NULL,1,NULL,0,0,0,0),(11,'customers','Customer',NULL,0,NULL,1,NULL,0,0,0,0),(12,'estimate','Estimate',NULL,0,NULL,1,NULL,0,0,0,0),(13,'goldsmith','Goldsmith',NULL,0,NULL,1,NULL,0,0,0,0),(14,'jobsheet_issued','Job Sheet',NULL,0,NULL,1,NULL,0,0,0,0),(15,'jobsheet_returned','Job Work Receipt',NULL,0,NULL,1,NULL,0,0,0,0),(16,'products','Product',NULL,0,NULL,1,1,0,0,0,0),(17,'po','Purchase Order','purchase_order',0,NULL,1,0,0,0,0,0),(18,'scheme','Scheme',NULL,0,NULL,1,0,0,0,0,0),(19,'scheme_invoice','Scheme Installment Invoice',NULL,0,NULL,1,0,0,0,0,0),(20,'user','User',NULL,0,NULL,1,0,0,0,0,0),(21,'vendor','Vendor',NULL,0,NULL,1,0,0,0,0,0),(22,'grn','Goods Receive Note','product_receive_note',0,NULL,1,0,0,0,0,0),(23,'old_purchase_bill','Purchase Bill','old_purchase_bill',0,NULL,1,NULL,0,0,0,0),(24,'customer_order','Customer Order','customer_order',0,NULL,1,NULL,0,0,0,0),(25,'product_header','Product Header','product_header',1,26,0,1,0,0,0,0),(26,'product_sku','Product SKU','product_sku',0,NULL,0,1,0,0,0,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
