<html>
	<head>
		<link rel="stylesheet" type="text/css" href="orderstyle.css">
		<script src="order.js"></script>
	</head>
	<body>
		<div id="itemTemplates">
			<?php 
				include_once 'MVC/View/conetemplate.php';
				include_once 'MVC/View/shaketemplate.php';
				include_once 'MVC/View/floattemplate.php';
				include_once 'MVC/View/discountstemplate.php';
				
				foreach ($itemTypes as $itemType) {
					echo "<div id='".$itemType->type."HeaderTemplate'><h3>$itemType->type</h4>Price: $$itemType->price <br>";
					if (!is_null($itemType->pricePerScoop))
					{
						echo "Price per scoop: $$itemType->pricePerScoop  <br>";
					}
					echo "<input type='hidden' name='itemType[]' value='$itemType->type'>";
					echo "Quantity: <input type='number' name='quantity[]' min='1' max='10' value='1'>";
					echo "</div>";					
				}
			?>
		</div>
		
		<h2>Order</h2>
		
		<form action="index.php" method="post">
			<input type="hidden" name="page" value="process">
			Name: <input type="text" name="name" value="Tester"><br> <input type="submit">
			
			Add: <button type="button" onclick="addItem('Cone');">Cone</button>
				<button type="button" onclick="addItem('Shake');">Shake</button>
				<button type="button" onclick="addItem('Float');">Float</button>
			
			<table id="items">
				
			</table>
		</form>
	</body>
</html>
