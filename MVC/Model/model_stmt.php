<?php
include_once 'dataobjects.php';

class Model 
{
	protected $connection = null;
	public function __construct()
	{
		$this->connection = new PDO("mysql:host=localhost;dbname=ba_ice_cream", "icecream", "ba");
	}
	
	private function runSql($sql){
		$query = $this->connection->prepare($sql);
		$query->execute();
		
		return $query;
	}
	
	public function getExtras()
	{
		$query = $this->connection->prepare("SELECT * FROM extra");
		
		$query->execute();
		
		$extras = array();
		
		foreach ($query as $row)
		{
			$extras[$row['id']] = new Extra($row['name'], $row['e_type']);
		}
		
		return $extras;
	}
	
	public function getDiscounts()
	{
		$query = $this->connection->prepare("	select d.id, d.name, it.name as item_type, amount
												from discount d, item_type it
												where d.item_type = it.id");
		$query->execute();
		
		$discounts = array();
		
		foreach ($query as $row)
		{
			$discounts[$row['id']] = new Discount($row['id'], $row['name'], $row['item_type'], $row['amount']);
		}
		
		return $discounts;
	}
	
	public function getItemTypes()
	{
		$query = $this->connection->prepare("SELECT * FROM item_type");
		$query->execute();
		
		$itemTypes = array();
		
		foreach ($query as $row)
		{
			$itemTypes[$row['name']] = new ItemType($row['id'], $row['name'], $row['price'], $row['price_per_scoop']);
		}
		
		return $itemTypes;
	}
	
	public function buildOrder($post)
	{
		$itemTypes = $this->getItemTypes();
		$discounts = $this->getDiscounts();
		$extras= $this->getExtras();
		$order = new Order($post['name']);
		for ($i = 0; $i < count($post['itemType']); $i++) {
			$itemType = $itemTypes[$post['itemType'][$i]];
			$qty = $post['quantity'][$i];
			$discount = null;
			if ($post['discounts'][$i] != ''){
				$discount = $discounts[$post['discounts'][$i]];
			}
			if ($itemType->type == 'Cone') {

				$item = new Cone(array_shift($post['coneVessels']));
				$item->addFlavor(array_shift($post['coneScoops']), array_shift($post['coneFlavors']));
				$q = array_shift($post['coneScoops']);
				$f = array_shift($post['coneFlavors']);
				if ($q>0){
					$item->addFlavor($q, $f);
				}
			}
			elseif ($itemType->type == 'Shake'){
				$item = new Shake(array_shift($post['shakeFlavors']), array_shift($post['shakeMilks']));
			}
			elseif ($itemType->type == 'Float'){
				$item = new Float(array_shift($post['floatSodas']));
				for ($f = 0; $f < array_shift($post['flavorCounts']); $f++) {
					$item->addFlavor(array_shift($post['floatScoops']), array_shift($post['floatFlavors']));
				}
			}
			
			$order->addItem($item, $itemType, $qty, $discount);
		}
		
		return $order;
	}
	
	public function saveOrder(Order $order){
		$extras= $this->getExtras();
		try {
			//insert order
			$sql = "insert into orders (customer_name) values (".$order->customerName.");";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
			$orderID = $this->connection->lastInsertId();
			foreach ($order->items as $lineItem) {
				//insert item
				$sql = "insert into item (item_type) values (".$lineItem->itemType->id.");";
				$stmt = $this->connection->prepare($sql);
				$stmt->execute();
				$itemID = $this->connection->lastInsertId();
				
				//insert line_item
				$sql = sprintf("insert into line_item (order_id, item, qty, price) values  (%i, %i, %i, %u);", $orderID, $itemID, $lineItem->qty, $lineItem->price);
				$stmt = $this->connection->prepare($sql);
				$stmt->execute();
				$lineItemID = $this->connection->lastInsertId();
				//update line_item with discount if there
				if (!is_null($lineItem->discount)){
					$sql = sprintf("UPDATE line_item SET discount = %i WHERE id = %i;", $lineItem->discount->id, $lineItemID);
					$stmt = $this->connection->prepare($sql);
					$stmt->execute();
				}
				
				//add item_extras
				foreach ($lineItem->item->extras as $extra) {
					//Get the extra object from extras array
					$filtered = array_filter($extras,function($e) use ($extra) {return 0 == strcasecmp($e->name, $extra->name) + strcasecmp($e->type, $extra->type);});
					//key from extras is id for extra
					$extraID = key($filtered);
					//insert item_extra relationship
					$sql = sprintf("INSERT INTO item_extras (item, extra) values (%i, %i);",$itemID,$extraID);
					$stmt = $this->connection->prepare($sql);
					$stmt->execute();
				}
				
				//add flavors/scoops if applicable
				if (isset($lineItem->item->flavors)){
					foreach ($lineItem->item->flavors as $flavor) {
						//Get flavor from extra object, use key as id
						$filtered = array_filter($extras,function($e) use ($flavor) {return 0 == strcasecmp($e->name, $flavor->flavor) + strcasecmp($e->type, 'flavor');});
						$extraID = key($filtered);
						// insert flavor
						$sql = sprintf("INSERT INTO scoop (item, flavor, qty) values (%i, %i, %i);",$itemID, $extraID, $flavor->qty);
						$stmt = $this->connection->prepare($sql);
						$stmt->execute();
					}
				}
			}
			echo "Order added";
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	
	
	
	
	
	
	
	
	
	
}


?>