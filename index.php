<html>
	<head>
		<link rel="stylesheet" type="text/css" href="icecreamstyle.css">
		<script src="order.js"></script>
	</head>
	<body>
		<div id="navbar"> 
			<ul>
			  <li><a href="?page=home">Home</a></li>
			  <li><a href="?page=order">Order</a></li>
			  <li><a href="?page=history">History</a></li>
			</ul>
		</div>
		<div id="content">
			<?php
				ini_set('display_errors',1);  error_reporting(E_ALL);
				include_once 'MVC/Controller/controller.php';
				$controller = new Controller();
				$controller->invoke();
			?>
		</div>		
	</body>
</html>