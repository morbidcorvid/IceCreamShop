<div id="ConeDiscountTemplate">
	Sorry, no discounts for ice cream cones.
	<input type="hidden" name="discounts[]" value="">
</div>

<div id="ShakeDiscountTemplate">
	Discount:
	<select name="discounts[]">
		<option value='' selected>-----</option>
		<?php
		foreach ($discounts as $discount){
			if ($discount->itemType == 'Shake') {
				echo "<option value='$discount->id'>$discount->name - $$discount->amount</option>";
			}
		}
		?>
	</select>
</div>

<div id="FloatDiscountTemplate">
	Discount:
	<select name="discounts[]">
		<option value='' selected>-----</option>
		<?php
		foreach ($discounts as $discount){
			if ($discount->itemType == 'Float') {
				echo "<option value='$discount->id'>$discount->name - $$discount->amount</option>";
			}
		}
		?>
	</select>
</div>