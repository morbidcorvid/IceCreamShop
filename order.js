/**
 * Colin Yantis - 3/2/2015
 * JavaScript source for order.php
 */

function addFlavor(obj){
	var table = obj.parentNode.parentNode.parentNode;
	table.children[2].style.display="table-row";
	table.children[1].children[2].style.display="none";
	table.children[2].children[0].children[0].children[0].disabled=true;
	table.children[2].children[0].children[0].children[1].selected=true;
	table.children[2].children[1].children[0].children[0].value=1;
}

function removeFlavor(obj){
	var table = obj.parentNode.parentNode.parentNode;
	table.children[2].style.display="none";
	table.children[1].children[2].style.display="inline-block";
	table.children[2].children[0].children[0].children[0].disabled=false;
	table.children[2].children[0].children[0].children[0].selected=true;
	table.children[2].children[1].children[0].children[0].value=0;
}

function checkCount(obj){
	var table = obj.parentNode.parentNode.parentNode;
	if (obj.value > 1){
		removeFlavor(obj);
		table.children[1].children[2].style.display="none";
	}
	else {
		table.children[1].children[2].style.display="inline-block";
	}
}

function addFloatFlavor(obj){
	var table = obj.parentNode.parentNode.parentNode;
	var currRow = obj.parentNode.parentNode;
	var flavorCount = table.children[0].children[3].children[0]
	console.log(flavorCount.value,document.getElementById('flavorSelect').options.length)
	if (flavorCount.value < document.getElementById('flavorSelect').options.length){
		flavorCount.value = parseInt(flavorCount.value) + 1;
		table.children[0].children[0].rowSpan += 1; 
		var row = table.insertRow(currRow.rowIndex+1);
		row.innerHTML = document.getElementById("floatFlavorTemplate").innerHTML;
	}
}

function removeFloatFlavor(obj){
	var table = obj.parentNode.parentNode.parentNode;
	var row = obj.parentNode.parentNode;
	if (row.rowIndex>0){
		table.deleteRow(row.rowIndex);
		var flavorCount = table.children[0].children[3].children[0]
		flavorCount.value = parseInt(flavorCount.value) - 1;
	}
}

function deleteItem(obj){
	var row = obj.parentNode.parentNode;
	var table = document.getElementById("items");
	table.deleteRow(row.rowIndex)
}
function showDiscount(obj){
	var row = obj.parentNode.nextSibling.style.display="table-cell";
}
function addItem(type){
	var table = document.getElementById("items");
	var row = table.insertRow(-1);
	var cell0 = row.insertCell(0);
	var cell1 = row.insertCell(1);
	var cell2 = row.insertCell(2);
	var cell3 = row.insertCell(3);
	cell0.innerHTML = document.getElementById(type+"HeaderTemplate").innerHTML;
	cell1.innerHTML = document.getElementById(type+"Template").innerHTML;
	cell2.innerHTML = '<button type="button" onclick="showDiscount(this);">Add Discount</button><br><button type="button" onclick="deleteItem(this);">Remove Item</button>';
	cell3.style.display = "none"
	cell3.innerHTML = document.getElementById(type+"DiscountTemplate").innerHTML;
}