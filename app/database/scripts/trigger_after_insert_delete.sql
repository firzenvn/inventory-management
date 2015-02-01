DELIMITER //
CREATE TRIGGER `TR_warehouses_AI` AFTER INSERT ON `warehouses` FOR EACH ROW
BEGIN
	UPDATE `clients` SET  warehouse_count = warehouse_count + 1 WHERE id = NEW.client_id;
END;//

DELIMITER //
CREATE TRIGGER `TR_warehouses_AD` AFTER DELETE ON `warehouses` FOR EACH ROW
BEGIN
	UPDATE `clients` SET  warehouse_count = warehouse_count - 1 WHERE id = OLD.client_id;
END;//

DELIMITER //
CREATE TRIGGER `TR_products_AI` AFTER INSERT ON `products` FOR EACH ROW
BEGIN
		UPDATE `clients` SET product_count = product_count + 1 WHERE id = NEW.client_id;
END;//

DELIMITER //
CREATE TRIGGER `TR_products_AD` AFTER DELETE ON `products` FOR EACH ROW
BEGIN
	UPDATE `clients` SET product_count = product_count - 1 WHERE id = OLD.client_id;
END;//

DELIMITER //
CREATE TRIGGER `TR_users_AI` AFTER INSERT ON `users` FOR EACH ROW
BEGIN
	UPDATE `clients` SET user_count = user_count + 1 WHERE id = NEW.client_id;
END;//

DELIMITER //
CREATE TRIGGER `TR_users_AD` AFTER DELETE ON `users` FOR EACH ROW
BEGIN
	UPDATE `clients` SET user_count = user_count - 1 WHERE id = OLD.client_id;
END;//