CREATE TABLE `tax`( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `name` VARCHAR(30), `display_name` VARCHAR(40),
 `rate_type` ENUM('fixed','percent') DEFAULT 'percent', `rate_value` DECIMAL(2,2),
 `min_applicable_amt` DECIMAL(10,2), `min_value` DECIMAL(10,2),
  `user_id` INT, `updated_at` DATETIME, PRIMARY KEY (`id`) );