ALTER TABLE `product_header` ADD COLUMN `price` DECIMAL(10,2) DEFAULT -99 NULL AFTER `date_added`;
ALTER TABLE `product_sku` ADD COLUMN `price_unit` ENUM('weight','volume','pieces','-99') DEFAULT 'pieces' NULL AFTER `price`;
ALTER TABLE `product_header` ADD COLUMN `price_unit` ENUM('weight','volume','pieces','-99') DEFAULT 'pieces' NULL AFTER `price`;