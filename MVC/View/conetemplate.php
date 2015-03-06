<div id="ConeTemplate">
	Please choose one or two scoops for your ice cream cone. Each scoop may be any flavor.<br>
	Flavors:<br>
	<table>
		<tr>
			<td>
				How would you like your cone served? 
				<select name="coneVessels[]">
					<?php 
						foreach ($vessels as $vessel){
							echo "<option value='$vessel->name'>$vessel->name</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Flavor: 
				<select name="coneFlavors[]">
					<?php 
						foreach ($flavors as $flavor){
							echo "<option value='$flavor->name'>$flavor->name</option>";
						}
					?>
				</select>
			</td>
			<td>
				Scoops: 
				<select name="coneScoops[]" onchange="checkCount(this);">
					<option value='1'>1</option>
					<option value='2'>2</option>
				</select>
			</td>
			<td>
				<button type="button" onclick="addFlavor(this);">+</button>
			</td>
		</tr>
		<tr style="display: none;">
			<td>
				Flavor: 
				<select name="coneFlavors[]">
					<option value=''></option>
					<?php 
						foreach ($flavors as $flavor){
							echo "<option value='$flavor->name'>$flavor->name</option>";
						}
					?>
				</select>
			</td>
			<td>
				Scoops: 
				<select name="coneScoops[]">
					<option value='0'>1</option>
				</select>
			</td>
			<td>
				<button type="button" onClick="removeFlavor(this)">-</button>
			</td>
		</tr>
	</table>
</div>