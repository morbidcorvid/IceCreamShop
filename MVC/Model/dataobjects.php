<?php
class ExtraType{
	public $id, $type, $description, $scoopable;
	
	function __construct($id, $type, $description, $scoopable) {
		$this->id = $id;
		$this->type = $type;
		$this->description = $description;
		$this->scoopable = $scoopable;
	}
}

class Extra
{
	public $name, $type, $is_scoop, $qty;
	
	function __construct($name, $type, $is_scoop = false, $qty = null)
	{
		$this->name = $name;
		$this->type = $type;
		$this->is_scoop = $is_scoop;
		$this->qty = $qty;
	}
}

class ItemType
{
	public $id, $type, $price, $pricePerScoop, $hasScoops, $description, $max_scoops;
	public $extraTypes;
	function __construct($id, $type, $price, $pricePerScoop, $hasScoops, $description, $max_scoops)
	{
		$this->id = $id;
		$this->type = $type;
		$this->price = $price;
		$this->pricePerScoop = $pricePerScoop;
		$this->hasScoops = $hasScoops;
		$this->description = $description;
		$this->max_scoops = $max_scoops;
	}
}

class Item
{
	public $extras=array();
	public $scoopcount=0;
	public $type, $qty, $discount, $price; 
	
	function setPrice($price, $pricePerScoop)
	{
		if (isset($this->scoopcount)){
			$price += $this->scoopcount * $pricePerScoop;
		}
		if (!is_null($this->discount)){
			$price -= $this->discount->amount;
		}
		$this->price = $price * $this->qty;
	}
	
	function addExtra($name,$type, $is_scoop, $qty){
		if ($is_scoop){
			$this->scoopcount += $qty;
		}
		array_push($this->extras, new Extra($name, $type, $is_scoop, $qty));
	}
	
	function __construct($type, $qty, $discount=null, $price=null){
		$this->type = $type;
		$this->qty = $qty;
		$this->discount =$discount;
		$this->price=$price;
	}
}

class Discount
{
	public $id, $name, $itemType, $amount;
	
	function __construct($id, $name, $itemType, $amount)
	{
		$this->id = $id;
		$this->name = $name;
		$this->itemType = $itemType;
		$this->amount = $amount;
	}
}

class Order
{
	public $items = array();
	public $total = 0, $customerName, $placed;
	
	public function getTotal(){
		//incase items added through addItem, reset total
		$this->total = 0;
		foreach ($this->items as $item) {
			$this->total += $item->price;
		}
	}
	
	function addItem($item)
	{
		$this->total += $item->price;
		array_push($this->items, $item);
	}
	
	function __construct($customerName, $placed = null)
	{
		$this->customerName = $customerName;
		$this->placed = $placed;
	}
	
}









?>