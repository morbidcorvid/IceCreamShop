<?php
	$connection = new PDO("mysql:host=localhost;dbname=ba_ice_cream_v2", "icecream", "ba");
	$sql = "select * from discount";
	$query = $connection->prepare($sql);
	$query->execute();
	
	$fetched = $query->fetchAll(PDO::FETCH_ASSOC);
	
	echo "<pre>";
	print_r($fetched);
	echo "</pre>";
	
	echo "<table>";
	$first = true;
	$rowNum = 0;
	foreach ($fetched as $row){
		$keys = array_keys($row);
		if ($first){
			$form = '<form id="editForm" action="index.php" method="post"><input type="hidden" name="page" value="manage">';
			
			$tableHead = "<tr><th></th>";
			foreach ($keys as $key){
				$form .= "<input type='hidden' id='$key' name='$key'>";
				$tableHead .= "<th>$key</th>";
			}
			echo $form . "</form>";
			echo $tableHead."</tr>";
			$first = false;
		}
		$view = "<tr id='row".$rowNum."View'><td><button type='button'>Edit</button></td>";
		$edit = "<tr id='row".$rowNum."Edit'><td><button type='button'>Cancel</button><button type='button'>Save</button></td>";
		foreach ($keys as $key){
			$view .= "<td>$row[$key]</td>";
			$edit .= "<td><input type='text' class='inputs$rowNum' name='$key' value='$row[$key]'></td>";
		}
		echo $view."</tr>";
		echo $edit."</tr>";
		$rowNum +=1;
	}
	echo "</table>";
?>