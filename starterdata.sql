INSERT INTO extra_type (id, type, description, is_scoopable) VALUES 
	(1, 'milk', '', 0),
	(2, 'flavor', '', 1),
	(3, 'soda','', 0),
	(4, 'vessel', 'What would you like your ice cream served in?', 0);

INSERT INTO item_type (id, name, price, price_per_scoop, has_scoops, description, max_scoops) VALUES
	(1, 'Cone', 4, 1, 1, 'Please choose one or two scoops for your ice cream cone. Each scoop may be any flavor.', 2),
	(2, 'Shake', 5, null, 0, 'Please choose the flavor and type of milk used to make your shake.', 0),
	(3, 'Float', 6, 1, 1, 'Choose a soda, and add as many flavors and scoops as you want!', null);

INSERT INTO item_type_extras(item_type, extra_type) VALUES
	(1, 2),
	(1, 4),
	(2, 1),
	(2, 2),
	(3, 2),
	(3, 3);

INSERT INTO extra (id, name, extra_type) VALUES
	(1, 'Whole', 1),
	(2, 'Skim', 1),
	(3, '2%', 1),
	(4, 'Chocolate', 2),
	(5, 'Vanilla', 2),
	(6, 'Strawberry', 2),
	(7, 'Coke', 3),
	(8, 'Pepsi', 3),
	(9, 'Rootbeer', 3),
	(10, 'Waffel Cone', 4),
	(11, 'Sugar Cone', 4),
	(12, 'Cup', 4),
	(13, 'Bowl', 4),
	(14, 'Cookies and Cream', 2),
	(15, 'Mint Chocolate Chip', 2),
	(16, 'Pistachio', 2),
	(17, 'Bubble Gum', 2);

INSERT INTO discount (id, name, item_type, amount) VALUES
	(1, 'Free Shake', 2, 5),
	(2, 'Free Float Scoop', 3, 1);
	
INSERT INTO orders (id, customer_name) VALUES
	(1, 'Anthony'),
	(2, 'Betty'),
	(3, 'Colin'),
	(4, 'Daisy'),
	(5, 'Ernie');

INSERT INTO item (id, order_id, item_type, discount, qty, price) VALUES
	(1, 1, 1, null, 1, 6),
	(2, 1, 1, null, 1, 6),
	(3, 2, 1, null, 2, 10),
	(4, 3, 2, 1, 1, 0),
	(5, 3, 2, null, 1, 5),
	(6, 4, 2, null, 1, 5),
	(7, 4, 3, 2, 1, 9),
	(8, 5, 3, null, 1, 25),
	(9, 5, 3, null, 1, 10);

INSERT INTO item_extras (item, extra, qty, is_scoop) VALUES
	(4, 1, null, 0),
	(4, 4, null, 0),
	(5, 2, null, 0),
	(5, 4, null, 0),
	(6, 2, null, 0),
	(6, 5, null, 0),
	(7, 9, null, 0),
	(8, 8, null, 0),
	(9, 8, null, 0),
	( 1, 4, 1, 1),
	(1, 6, 1, 1),
	(2, 5, 2, 1),
	(3, 5, 1, 1),
	(7, 4, 2, 1),
	(7, 5, 1, 1),
	(8, 6, 19, 1),
	(9, 5, 2, 1),
	(9, 6, 2, 1);

