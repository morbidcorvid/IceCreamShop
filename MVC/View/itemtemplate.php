<?php
	//create table to hold template rows
	echo "<div id='itemTemplates'><table>";
	foreach ($itemTypes as $itemType){
		//start row, id as typeTemplate
		printf("<tr id='%sTemplate'>", $itemType->type);
		//header cell
		echo "<td><h3>$itemType->type</h4>Price: $$itemType->price <br>";
		if ($itemType->hasScoops)
		{
			echo "Price per scoop: $$itemType->pricePerScoop<br>";
		}
		
		echo "<input type='hidden' name='items[ITEMID][itemType]' value='$itemType->type'>";
		echo "<input type='hidden' id='ITEMIDMaxScoops' value='$itemType->max_scoops'>";
		echo "<input type='hidden' id='ITEMIDScoopCount' value='1'>";
		echo "Quantity: <input type='number' name='items[ITEMID][quantity]' min='1' max='10' value='1'></td>";
		//main cell
		echo "<td>" . $itemType->description . "<table id='itemITEMIDExtras'>";
		//iterate over extraTypes create input for each
		$rowCount=0;
		foreach ($itemType->extraTypes as $extraType){
			//create select input for extra type
			echo "<tr><td>";
			if ($extraType->description != ''){
				echo $extraType->description ."<br>";
			}
			echo ucwords($extraType->type) . ": <select name='items[ITEMID][extras][$rowCount][$extraType->type]'>";
			foreach (array_filter($extras,function($e) use ($extraType) {return $e->type == $extraType->type;}) as $extra){
				echo "<option value='$extra->name'>$extra->name</option>";
			}
			echo "</select></td>";
			//add scoops and buttons cells if scoopable
			if ($extraType->scoopable and $itemType->hasScoops){
				$jsStr = "'$extraType->type'";
				echo '
					<td>
						Scoops: 
						<input name="items[ITEMID][extras]['.$rowCount.'][scoops]" type="number" min="1" value="1" onchange="checkScoops(ITEMID,this)">
					</td>
					<td id="plusMinusCell">
						<button type="button" onclick="addScoopable(ITEMID, '.$jsStr.');">+</button>
					</td>';
			}
			
			echo "</tr>";
			$rowCount+=1;
		}
		echo "</table><input type='hidden' id='itemITEMIDRows' value='".$rowCount."'></td>";
		//buttons cell
		echo '
			<td>
				<button type="button" onclick="showDiscount(this);">Add Discount</button><br>
				<button type="button" onclick="deleteItem(this);">Remove Item</button>
			</td>';
		//discounts cell
		$typeDiscounts = array_filter($discounts,function($e) use ($itemType) {return $e->itemType == $itemType->type;});
		echo "<td style='display:none'>";
		if (count($typeDiscounts)>0){
			echo 'Discount:	<select name="items[ITEMID][discount]"><option value=""></option>';
			foreach ($typeDiscounts as $discount){
				echo "<option value='$discount->id'>$discount->name - $$discount->amount</option>";
			}
		}
		else {
			echo "Sorry, no discounts for this item today.";
		}
		echo "</td></tr>";
	}
	//Create templates for scoopables
	foreach ($extraTypes as $extraType){
		if ($extraType->scoopable){
			echo "<tr id='".$extraType->type."ScoopTemplate'><td>";
			echo ucwords($extraType->type) . ": <select name='items[ITEMID][extras][ROWID][$extraType->type]'>";
			foreach (array_filter($extras,function($e) use ($extraType) {return $e->type == $extraType->type;}) as $extra){
				echo "<option value='$extra->name'>$extra->name</option>";
			}
			echo "</select></td>";
			//add scoops and buttons cells
			$jsStr = "'$extraType->type'";
			echo '
				<td>
					Scoops:
					<input name="items[ITEMID][extras][ROWID][scoops]" type="number" min="1" value="1" onchange="checkScoops(ITEMID,this)">
				</td>
				<td id="plusMinusCell">
					<button type="button" onclick="addScoopable(ITEMID, '.$jsStr.');">+</button>
					<button type="button" onclick="removeScoopable(ITEMID, this);">-</button>
				</td></tr>';
		}
	}
	
	echo "</table></div>";
?>