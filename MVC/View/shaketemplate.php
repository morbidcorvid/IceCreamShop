<div id="ShakeTemplate">
	Please choose the flavor and type of milk used to make your shake<br>
	
	<table>
		<tr>
			<td>
				Flavor: 
				<select name="shakeFlavors[]">
					<?php 
						foreach ($flavors as $flavor){
							echo "<option value='$flavor->name'>$flavor->name</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Milk: 
				<select name="shakeMilks[]">
					<?php 
						foreach ($milks as $milk){
							echo "<option value='$milk->name'>$milk->name</option>";
						}
					?>
				</select>
			</td>
		</tr>
	</table>

</div>
