INSERT INTO extra (id, name, e_type) VALUES
	(1, 'Whole', 'milk'),
	(2, 'Skim', 'milk'),
	(3, '2%', 'milk'),
	(4, 'Chocolate', 'flavor'),
	(5, 'Vanilla', 'flavor'),
	(6, 'Strawberry', 'flavor'),
	(7, 'Coke', 'soda'),
	(8, 'Pepsi', 'soda'),
	(9, 'Rootbeer', 'soda'),
	(10, 'Waffel Cone', 'vessel'),
	(11, 'Sugar Cone', 'vessel'),
	(12, 'Cup', 'vessel'),
	(13, 'Bowl', 'vessel');

INSERT INTO item_type (id, name, price, price_per_scoop) VALUES
	(1, 'Cone', 3.5, 1),
	(2, 'Shake', 4, null),
	(3, 'Float', 4, 1);

INSERT INTO item (id, item_type) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 2),
	(5, 2),
	(6, 2),
	(7, 3),
	(8, 3),
	(9, 3);

INSERT INTO item_extras (item, extra) VALUES
	(4, 1),
	(4, 4),
	(5, 2),
	(5, 4),
	(6, 2),
	(6, 5),
	(7, 9),
	(8, 8),
	(9, 8);
	
INSERT INTO scoop (id, item, flavor, qty) VALUES
	(1, 1, 4, 1),
	(2, 1, 6, 1),
	(3, 2, 5, 2),
	(4, 3, 5, 1),
	(5, 7, 4, 2),
	(6, 7, 5, 1),
	(7, 8, 6, 19),
	(8, 9, 5, 2),
	(9, 9, 6, 2);

INSERT INTO discount (id, name, item_type, amount) VALUES
	(1, 'Free Shake', 2, 4),
	(2, 'Free Float Scoop', 3, 1);
	
INSERT INTO orders (id, customer_name) VALUES
	(1, 'Anthony'),
	(2, 'Betty'),
	(3, 'Colin'),
	(4, 'Daisy'),
	(5, 'Ernie');
	
INSERT INTO line_item (order_id, item, discount, qty) VALUES
	(1, 1, null, 1),
	(1, 2, null, 1),
	(2, 3, null, 2),
	(3, 4, 1, 1),
	(3, 5, null, 1),
	(4, 6, null, 1),
	(4, 7, 2, 2),
	(5, 8, null, 1),
	(5, 9, null, 1);