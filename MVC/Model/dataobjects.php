<?php
class Extra
{
	public $name, $type;
	
	function __construct($name, $type)
	{
		$this->name = $name;
		$this->type = $type;
	}
}

class Flavor
{
	public $qty, $flavor;
	
	function __construct($qty, $flavor)
	{
		$this->qty = $qty;
		$this->flavor = $flavor;
	}
}

class Cone
{
	public $flavors=array();
	public $extras=array();
	public $maxscoops = 2; 
	public $scoopcount = 0;
	
	function addFlavor($qty, $flavor)
	{
		if ($this->scoopcount + $qty <= $this->maxscoops) {
			array_push($this->flavors, new Flavor($qty, $flavor));
			$this->scoopcount += $qty;
			return true;
		}
		return false;
	}
	
	function __construct($vessel){
		$this->extras['vessel'] = new Extra($vessel, 'Vessel');
	}
}

class Shake
{
	public $extras;
	
	function __construct($flavor, $milk)
	{
		$this->extras['flavor'] = new Extra($flavor, 'Flavor');
		$this->extras['milk'] = new Extra($milk, 'Milk');
	}
}

class Float
{
	public $flavors=array();
	public $extras=array();
	public $scoopcount=0;
	
	function addFlavor($qty, $flavor)
	{
		array_push($this->flavors, new Flavor($qty, $flavor));
		$this->scoopcount += $qty;
	}
	
	function __construct($soda)
	{
		$this->extras['soda'] = new Extra($soda, 'Soda');
	}
}

class Item
{
	public $flavors=array();
	public $extras=array();
	public $scoopcount=0;
	public $type;
	
	function addFlavor($qty, $flavor)
	{
		array_push($this->flavors, new Flavor($qty, $flavor));
		$this->scoopcount += $qty;
	}
	
	function addExtra($name,$type){
		$this->extras[$type] = new Extra($name, $type);
	}
	
	function __construct($type, $extras, $flavors){
		$this->type = $type;
		$this->extras = $extras;
		$this->flavors = $flavors;
	}
}

class ItemType
{
	public $id, $type, $price, $pricePerScoop;
	
	function __construct($id, $type, $price, $pricePerScoop)
	{
		$this->id = $id;
		$this->type = $type;
		$this->price = $price;
		$this->pricePerScoop = $pricePerScoop;
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

class LineItem
{
	public $item, $itemType, $qty, $discount, $price;
	
	function setPrice()
	{
		$this->price = $this->itemType->price;
		if (isset($this->item->scoopcount)){
			$this->price += $this->item->scoopcount * $this->itemType->pricePerScoop;
		}
		if (!is_null($this->discount)){
			$this->price -= $this->discount->amount;
		}
		$this->price = $this->price * $this->qty;
	}
	
	function __construct($item, $itemType, $qty, $discount)
	{
		$this->item = $item;
		$this->itemType = $itemType;
		$this->qty = $qty;
		$this->discount = $discount;
		$this->setPrice();
	}
}

class Order
{
	public $items = array();
	public $total = 0, $customerName;
	
	function addItem($item, $itemType, $qty, $discount)
	{
		$lineItem = new LineItem($item, $itemType, $qty, $discount);
		$this->total += $lineItem->price;
		array_push($this->items, $lineItem);
	}
	
	function __construct($customerName)
	{
		$this->customerName = $customerName;
	}
	
}









?>