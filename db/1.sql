/*[5:53:32 PM][215 ms]*/ ALTER TABLE `alice_gold`.`bill_items` DROP FOREIGN KEY `bill_items_ibfk_1`; 
/*[5:53:38 PM][243 ms]*/ ALTER TABLE `alice_gold`.`bill` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, CHANGE `user_id` `user_id` INT NOT NULL, CHANGE `customer_id` `customer_id` BIGINT UNSIGNED NOT NULL AFTER `paid_by_card`, ADD COLUMN `vat_discount` FLOAT DEFAULT 0 NOT NULL AFTER `vat_amount`, CHANGE `paid_by_scheme` `paid_by_scheme` FLOAT DEFAULT 0 NOT NULL AFTER `final_amount`, ADD COLUMN `scheme_user_id` BIGINT UNSIGNED DEFAULT 0 NOT NULL AFTER `paid_by_scheme`; 
/*[6:03:48 PM][219 ms]*/ ALTER TABLE `alice_gold`.`scheme_user` ADD COLUMN `net_amount` FLOAT DEFAULT 0 NOT NULL AFTER `accumulated_quantity`; 


ALTER TABLE `alice_gold`.`sub_transaction` ADD COLUMN `created_at` DATETIME NULL AFTER `reference_id`;