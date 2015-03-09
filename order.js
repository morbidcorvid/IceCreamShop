/**
 * Colin Yantis - 3/2/2015
 * JavaScript source for order.php
 */

var numItems = 0;

function addScoopable(itemId, type){
	var table = document.getElementById('item'+itemId+'Extras');
	var maxScoops = document.getElementById(itemId+'MaxScoops').value;
	var scoops = parseInt(document.getElementById(itemId+'ScoopCount').value)
	if (maxScoops=='' || (table.rows.length <= maxScoops && scoops < parseInt(maxScoops))){
		var row = table.insertRow(-1);
		//using a variable rather than checking number of rows in table because users can delete rows, causing duplicate id's
		var rowCount = document.getElementById('item'+itemId+'Rows');
		row.innerHTML = document.getElementById(type+'ScoopTemplate').innerHTML.replace(/ITEMID/g,itemId);
		row.innerHTML = row.innerHTML.replace(/ROWID/g,rowCount.value);
		var scoops = parseInt(document.getElementById(itemId+'ScoopCount').value)
		document.getElementById(itemId+'ScoopCount').value = scoops + 1
		var select = row.children[0].children[0];
		var selects = document.getElementsByClassName('item'+itemId+'type'+type);
		var selected = [];
		for (i = 0; i < selects.length; i++){
			selected[selected.length]=selects[i].value;
		}
		for (o = 0; o < select.options.length; o++){
			if (selected.indexOf(select.options[o].value) >= 0){
				select.options[o].disabled = true;
			}
			else{
				select.options[o].selected = true;
			}
		}
		
		rowCount.value = parseInt(rowCount.value) + 1;
	}
}

function removeScoopable(itemId, obj){
	var table = obj.parentNode.parentNode.parentNode;
	var row = obj.parentNode.parentNode;
	var rowScoops = row.children[1].children[0]
	var scoops = parseInt(document.getElementById(itemId+'ScoopCount').value)
	document.getElementById(itemId+'ScoopCount').value = scoops - parseInt(rowScoops.value);
	table.deleteRow(row.rowIndex);
}

function checkScoops(itemId,obj){
	var maxScoops = document.getElementById(itemId+'MaxScoops').value;
	var scoops = parseInt(document.getElementById(itemId+'ScoopCount').value)
	var val = parseInt(obj.value);
	if (maxScoops == '' || scoops + (val-obj.defaultValue) <= parseInt(maxScoops)){
		document.getElementById(itemId+'ScoopCount').value = scoops + (val-obj.defaultValue)
		obj.defaultValue = val;
	}
	else {
		obj.value = parseInt(maxScoops) - (scoops - obj.defaultValue);
		document.getElementById(itemId+'ScoopCount').value = parseInt(maxScoops);
	}
}

function checkSelect(itemID, type, obj){
	var val = obj.value;
	var selects = document.getElementsByClassName('item'+itemID+'type'+type);
	var selected = [];
	for (i = 0; i < selects.length; i++){
		selected[selected.length]=selects[i].value;
	}

	for (i = 0; i < selects.length; i++){		
		for (o = 0; o < selects[i].options.length; o++){
			if (selected.indexOf(selects[i].options[o].value) >= 0){
				selects[i].options[o].disabled = true;
			}
			else{
				selects[i].options[o].disabled = false;
			}
		}
	}
	obj.options.namedItem(val).disabled = false;
}

function addItem(type){
	var table = document.getElementById("items");
	var row = table.insertRow(-1);
	row.innerHTML = document.getElementById(type+"Template").innerHTML.replace(/ITEMID/g, numItems);
	row.className = "item";
	numItems += 1;
}

function deleteItem(obj){
	var row = obj.parentNode.parentNode;
	var table = document.getElementById("items");
	table.deleteRow(row.rowIndex)
}

function showDiscount(obj){
	var row = obj.parentNode.nextSibling.style.display="table-cell";
}