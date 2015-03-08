<?php
	echo "<table class='order'>
			<tr><td class='placed' colspan='4'> Order placed by ".$order->customerName;
	if (!is_null($order->placed)){
		echo " on ".$order->placed;
	}			
	echo "</td></tr><tr><th>Items</th><th>Item Price</th><th>Quantity</th><th>Total</th></tr>";
	foreach ($order->items as $item){
		$buildStr = "";
		$rows=1;
		//separate extras into different arrays depending on is_scoop, different format for scoopables
		$scoopExtras = array_filter($item->extras,function($e) {return $e->is_scoop;});
		$extras = array_filter($item->extras,function($e) {return !$e->is_scoop;});
		//build non-scoop extras
		if (count($extras)>0){
			foreach ($extras as $extra) {
				$buildStr .= "<tr class='extra'><td class='first'>".ucwords($extra->type)." : $extra->name</td><td></td><td></td></tr>";
				$rows+=1;
			}
		}
		//build scoop extras
		if (count($scoopExtras) > 0){
			$buildStr .= "<tr class='extra'><td class='first'>Scoops:</td><td></td><td></td></tr>";
			$rows+=1;
			foreach ($scoopExtras as $extra){
				$buildStr .= "<tr class='scoop'><td class='first'>".ucwords($extra->type)." : $extra->name</td><td class='number'>".sprintf("$%.2f",$itemTypes[$item->type]->pricePerScoop)."</td><td class='number'>$extra->qty</td></tr>";
				$rows+=1;
			}
		}
		//build discount row
		if (!is_null($item->discount)){
			$buildStr .= "<tr class='extra'><td class='first'>Discount:".$item->discount->name."</td><td class='number'>".sprintf("-$%.2f",$item->discount->amount)."<td></td></td></tr>";
			$rows+=1;
		}
		//display item
		echo "<tr class='item'><td class='first'>".$item->type."</td><td class='number'>".sprintf("$%.2f",$itemTypes[$item->type]->price)."</td><td class='number'>$item->qty</td><td class='number' rowspan='$rows'>".sprintf("$%.2f", $item->price)."</td></tr>";
		echo $buildStr;
		 
	}
	echo "<tr><td></td><td></td><th>Grand Total:</th><th>".sprintf("$%.2f <br>",$order->total)."</th></tr></table>";
?>