<div id="FloatTemplate">
	Choose a soda, and add as many flavors and scoops as you want!<br>
	
	<table>
		<tr>
			<td rowspan="1">
				Soda: 
				<select name="floatSodas[]">
					<?php 
						foreach ($sodas as $soda){
							echo "<option value='$soda->name'>$soda->name</option>";
						}
					?>
				</select>
			</td>
			<td id="flavorCell">
				Flavor: 
				<select name="floatFlavors[]">
					<?php 
						foreach ($flavors as $flavor){
							echo "<option value='$flavor->name'>$flavor->name</option>";
						}
					?>
				</select>
			</td>
			<td id="scoopsCell">
				Scoops: 
				<input name="floatScoops[]" type="number" min="1" value="1">
			</td>
			<td id="plusMinusCell">
				<input type="hidden" name="flavorCounts[]" value="1">
				<button type="button" onclick="addFloatFlavor(this);">+</button>
				<button type="button" onclick="removeFloatFlavor(this);">-</button>
			</td>
		</tr>
	</table>

</div>

<div >
	<table>
		<tr id="floatFlavorTemplate">
			<td id="flavorCell">
				Flavor: 
				<select id="flavorSelect" name="floatFlavors[]">
					<?php 
						foreach ($flavors as $flavor){
							echo "<option value='$flavor->name'>$flavor->name</option>";
						}
					?>
				</select>
			</td>
			<td id="scoopsCell">
				Scoops: 
				<input name="floatScoops[]" type="number" min="1" value="1">
			</td>
			<td id="plusMinusCell">
				<button type="button" onclick="addFloatFlavor(this);">+</button>
				<button type="button" onclick="removeFloatFlavor(this);">-</button>
			</td>
		</tr>
	</table>
</div>