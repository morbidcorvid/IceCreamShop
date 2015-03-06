CREATE TABLE IF NOT EXISTS extra (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(20),
	e_type CHAR(10) NOT NULL,
	
	PRIMARY KEY (id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS item_type(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(20),
	price DECIMAL,
	price_per_scoop DECIMAL,
	PRIMARY KEY (id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS item(
	id INT NOT NULL AUTO_INCREMENT,
	item_type INT NOT NULL,
	PRIMARY KEY (id),
	
	INDEX (item_type),
	
	FOREIGN KEY (item_type)
		REFERENCES	item_type(id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS item_extras(
	item INT NOT NULL,
	extra INT NOT NULL,
	PRIMARY KEY (item, extra),
	
	INDEX (item),
	INDEX (extra),
	
	FOREIGN KEY (item)
		REFERENCES item(id),
	FOREIGN KEY (extra)
		REFERENCES extra(id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS scoop(
	id INT NOT NULL AUTO_INCREMENT,
	item INT NOT NULL,
	flavor INT NOT NULL,
	qty INT NOT NULL,
	
	PRIMARY KEY (id),
	
	INDEX (item),
	INDEX (flavor),
	
	FOREIGN KEY (item)
		REFERENCES item(id),
	FOREIGN KEY (flavor)
		REFERENCES extra(id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS discount(
	id INT NOT NULL AUTO_INCREMENT,
	name CHAR(50) NOT NULL,
	item_type INT NOT NULL,
	amount decimal NOT NULL,
	
	PRIMARY KEY (id),
	
	INDEX (item_type),
	
	FOREIGN KEY (item_type)
		REFERENCES item_type(id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS orders(
	id INT NOT NULL AUTO_INCREMENT,
	placed TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	customer_name CHAR(50),
	
	PRIMARY KEY (id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS line_item(
	id INT NOT NULL AUTO_INCREMENT,
	order_id INT NOT NULL,
	item INT NOT NULL,
	discount INT,
	qty INT,
	price DECIMAL,
	
	PRIMARY KEY (id),
	
	INDEX (order_id),
	INDEX (item),
	INDEX (discount),
	
	FOREIGN KEY (order_id)
		REFERENCES orders(id),
	FOREIGN KEY (item)
		REFERENCES item(id),
	FOREIGN KEY (discount)
		REFERENCES discount(id)
) ENGINE=INNODB;