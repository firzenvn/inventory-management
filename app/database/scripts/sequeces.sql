delimiter //
CREATE TABLE  `sequences` (
  `name` varchar(45) NOT NULL,
  `value` int(11) unsigned NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//

delimiter //
CREATE FUNCTION get_next_seq_no(sequence_name VARCHAR(255))
  RETURNS int(11)
  DETERMINISTIC
  SQL SECURITY INVOKER
BEGIN
  insert into sequences
    (`name`, `value`)
  values
    (sequence_name, last_insert_id(1))
  on duplicate key update
    `value` = last_insert_id(`value` + 1);
  RETURN last_insert_id();
END//

ALTER TABLE `products`
ADD COLUMN `seq_no` INT(11) NOT NULL AFTER `client_id`;

ALTER TABLE `products`
ADD UNIQUE INDEX `UK_client_seq_no` (`client_id` ASC, `seq_no` ASC);

delimiter //
CREATE TRIGGER TR_products_BI
	BEFORE INSERT
	ON products
	FOR EACH ROW
BEGIN
  if new.seq_no is null or !new.seq_no then
    set new.seq_no = last_insert_id(get_next_seq_no(concat('products_',new.client_id)));
  end if;

  set new.id = last_insert_id(new.id);
END//

#applying on other tables similar to this (orders, invoices...)



