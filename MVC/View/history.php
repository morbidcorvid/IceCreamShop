<h2>History</h2>
<?php 
	echo '<!--';
	print_r($orders);
	echo '-->'; 
	
	foreach ($orders as $order) {
		include 'MVC/View/ordertemplate.php';
	}
?>