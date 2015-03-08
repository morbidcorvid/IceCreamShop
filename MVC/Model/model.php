<?php
include_once 'dataobjects.php';

class Model 
{
	protected $connection = null;
	public function __construct()
	{
		$this->connection = new PDO("mysql:host=localhost;dbname=ba_ice_cream_v2", "icecream", "ba");
	}
	private function getQuery($sql){
		$query = $this->connection->prepare($sql);
		$query->execute();
		return $query;
	}
	
	public function getExtraTypes(){
		$sql = "select * from extra_type";
		$extraTypes = array();
		foreach ($this->getQuery($sql) as $row)
		{
			$extraTypes[$row['id']] = new ExtraType($row['id'], $row['type'], $row['description'], $row['is_scoopable']);
		}
		return $extraTypes;
	}
	
	public function getItemTypeExtras(){
		//query to get item/extra type relations
		$sql = "select item_type, id, type, description, is_scoopable from item_type_extras ite, extra_type et where ite.extra_type = et.id order by is_scoopable asc";
		//create array of arrays of extra type objects, use item_type.id as key
		$ite = array();
		foreach ($this->getQuery($sql) as $row){
			if (! isset($ite[$row['item_type']])) {
				$ite[$row['item_type']] = array();
			}
			array_push($ite[$row['item_type']], new ExtraType($row['id'], $row['type'], $row['description'], $row['is_scoopable']));
		}
		return $ite;
	}
	public function getItemTypes()
	{
		//get item_type_extras and build sql string
		$itemTypeExtras = $this->getItemTypeExtras();
		$sql = "SELECT * FROM item_type";
		//build array of item type objects, use item_type.name as key
		$itemTypes = array();
		foreach ($this->getQuery($sql) as $row)
		{
			$itemTypes[$row['name']] = new ItemType($row['id'], $row['name'], $row['price'], $row['price_per_scoop'], $row['has_scoops'], $row['description'], $row['max_scoops']);
			$itemTypes[$row['name']]->extraTypes = $itemTypeExtras[$row['id']];
		}
		return $itemTypes;
	}
	
	public function getExtras()
	{
		$sql = "select e.id, e.name, et.type from extra e, extra_type et where e.extra_type = et.id";
		$extras = array();
		foreach ($this->getQuery($sql) as $row)
		{
			$extras[$row['id']] = new Extra($row['name'], $row['type']);
		}
		return $extras;
	}
	
	public function getDiscounts()
	{
		$sql = "select d.id, d.name, it.name as item_type, amount
				from discount d, item_type it
				where d.item_type = it.id";
		$discounts = array();
		foreach ($this->getQuery($sql) as $row)
		{
			$discounts[$row['id']] = new Discount($row['id'], $row['name'], $row['item_type'], $row['amount']);
		}
		return $discounts;
	}
	
	public function buildOrder($name, $items){
		$order = new Order($name);
		$itemTypes = $this->getItemTypes();
		$discounts = $this->getDiscounts();
		foreach ($items as $item){
			//initialize new item object
			$nItem = new Item($item['itemType'], $item['quantity']);
			//add extras to item
			foreach ($item['extras'] as $extra){
				$type = key($extra);
				$name = $extra[$type];
				if (isset($extra['scoops'])){
					$is_scoop = true;
					$qty = $extra['scoops'];
				}
				else {
					$is_scoop = false;
					$qty = null;
				}
				$nItem->addExtra($name, $type, $is_scoop, $qty);
			}
			//add discount to item
			if (isset($item['discount']) and $item['discount']!=''){
				$nItem->discount = $discounts[$item['discount']];
			}
			//set the price of the item
			$nItem->setPrice($itemTypes[$nItem->type]->price, $itemTypes[$nItem->type]->pricePerScoop);
			//add item to order
			$order->addItem($nItem);
		}
		return $order;
	}
	
	public function saveOrder(Order $order){
		$extras= $this->getExtras();
		$itemTypes = $this->getItemTypes();
		try {
			$conn = $this->connection;
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//start a transaction
			$conn->beginTransaction();
			//insert order
			$sql = "insert into orders (customer_name) values ('".$order->customerName."')";
			$conn->exec($sql);
			$orderID = $this->connection->lastInsertId();
			foreach ($order->items as $item) {
				//insert item
				$sql = sprintf("insert into item (order_id, item_type, qty, price) values  (%u, %u, %u, %u)", $orderID, $itemTypes[$item->type]->id, $item->qty, $item->price);
				$conn->exec($sql);
				$itemID = $this->connection->lastInsertId();
				//update item with discount if there
				if (!is_null($item->discount)){
					$sql = sprintf("UPDATE item SET discount = %u WHERE id = %u", $item->discount->id, $itemID);
					$conn->exec($sql);
				}
				//add item_extras
				foreach ($item->extras as $extra) {
					//Get the extra object from extras array
					$filtered = array_filter($extras,function($e) use ($extra) {return 0 == strcasecmp($e->name, $extra->name) + strcasecmp($e->type, $extra->type);});
					//key from extras is id for extra
					$extraID = key($filtered);
					//insert item_extra relationship
					$sql = sprintf("INSERT INTO item_extras (item, extra, qty, is_scoop) values (%u, %u, %u, %u)",$itemID,$extraID,$extra->qty,$extra->is_scoop);
					$conn->exec($sql);
				}
			}
			//commit the transaction
			$conn->commit();
			echo "Order Saved Succesfully<br>";
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function getOrders(){
		$extras = $this->getExtras();
		$discounts = $this->getDiscounts();
		$itemTypes = $this->getItemTypes();
		
		//get item_extras and build itemExtras as array of arrays of Extra object with key as item id
		$sql = "SELECT item, name, type, qty, is_scoop FROM item_extras ie, extra e, extra_type et where ie.extra = e.id and e.extra_type = et.id";
		$itemExtras = array();
		foreach ($this->getQuery($sql) as $row)
		{
			if (! isset($itemExtras[$row['item']])) {
				$itemExtras[$row['item']] = array();
			}
			array_push($itemExtras[$row['item']], new Extra($row['name'], $row['type'], $row['is_scoop'], $row['qty']));
		}
				
		//get items
		$sql = "SELECT i.id, order_id, it.name, discount, qty, i.price FROM item i, item_type it where i.item_type = it.id;";
		$orderItems = array();
		foreach ($this->getQuery($sql) as $row){
			if (! isset($orderItems[$row['order_id']])) {
				$orderItems[$row['order_id']] = array();
			}
			//create item from query data
			$discount = null;
			if (!is_null($row['discount'])){
				$discount = $discounts[$row['discount']];
			}
			$item = new Item($row['name'], $row['qty'],$discount,$row['price']);

			//add extras gathered before
			$item->extras = $itemExtras[$row['id']];
			//add to orderItems
			array_push($orderItems[$row['order_id']], $item);
		}
		//get orders
		$sql = "select * from orders order by id desc";
		$orders = array();
		foreach ($this->getQuery($sql) as $row){
			$order = new Order($row['customer_name'],$row['placed']);
			$order->items = $orderItems[$row['id']];
			$order->getTotal();
			$orders[$row['id']] = $order;
		}
		return $orders;
	}
	
	
	
	
	
	
	
	
	
	
}


?>