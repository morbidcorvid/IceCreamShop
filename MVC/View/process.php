<html>
	<head>
		<link rel="stylesheet" type="text/css" href="processstyle.css">
	</head>
	<body>
		<h3>Process Order</h3>
		<br>
		<?php 
			echo '<!--';
			print_r($order);
			echo '-->';
			 		 	
		 	echo "<table><tr><th>Items</th><th>Item Price</th><th>Quantity</th><th>Total</th></tr>";
		 	foreach ($order->items as $line){
		 		$buildStr = "";
		 		$rows=1;
		 		foreach ($line->item->extras as $extra) {
		 			$buildStr .= "<tr class='extra'><td>$extra->type : $extra->name</td><td></td><td></td></tr>";
		 			$rows+=1;
		 		}
		 		if (isset($line->item->flavors)){
		 			//echo "<li>Flavors:</li><ul>";
		 			foreach ($line->item->flavors as $flavor){
		 				$buildStr .= "<tr class='extra'><td>Scoops: $flavor->flavor</td><td>".sprintf("$%.2f",$line->itemType->pricePerScoop)."</td><td>$flavor->qty</td></tr>";
		 				$rows+=1;
		 			}
		 		}
		 		if (isset($line->discount)){
		 			$buildStr .= "<tr class='extra'><td>Discount:".$line->discount->name."</td><td>".sprintf("-$%.2f",$line->discount->amount)."<td></td></td></tr>";
		 			$rows+=1;
		 		}
		 		
		 		echo "<tr class='item'><td>".$line->itemType->type."</td><td>".sprintf("$%.2f",$line->itemType->price)."</td><td>$line->qty</td><td rowspan='$rows'>".sprintf("$%.2f", $line->price)."</td></tr>";
		 		echo $buildStr;
		 	}
		 	echo "<tr><td></td><td></td><th>Grand Total:</th><th>".sprintf("$%.2f <br>",$order->total)."</th></tr></table>";
		 ?>
		 <form method="post" action="index.php">
		 	<input id="pageInput" type="hidden" name="page">
		    <button type="submit" onclick="document.getElementById('pageInput').value='order';">Place Order</button>
		    <button type="submit" onclick="document.getElementById('pageInput').value='history';">Order History</button>
		</form>
	</body>
</html>
 