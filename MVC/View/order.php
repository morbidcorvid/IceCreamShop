<?php
	echo '<!--';
	print_r($itemTypes);
	echo '-->';
	include_once 'MVC/View/itemtemplate.php';
?>

<h2>Order</h2>

<form action="index.php" method="post">
	<input type="hidden" name="page" value="process">
	<table class="orderbar">
		<tr>
			<td>Name: <input type="text" name="name" value="Tester"></td>
			<td>
				Add:
				<?php 
					foreach ($itemTypes as $itemType){
						$jsStr = "'$itemType->type'";
						echo '<button type="button" onclick="addItem('.$jsStr.');">'.$itemType->type.'</button>';
					}
				?>
			</td>
			<td><input type="submit"></td>
		</tr>
	</table>
	<table id="items">
		
	</table>
</form>
