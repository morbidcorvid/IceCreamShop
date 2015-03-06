<?php
include_once "MVC/Model/model.php";

class Controller
{
	public $model;
	
	public function __construct()
	{
		$this->model = new Model();
	}
	
	public function invoke()
	{
		$extras = $this->model->getExtras();
		$flavors = array_filter($extras,function($e){return $e->type == 'flavor';});
		$milks= array_filter($extras,function($e){return $e->type == 'milk';});
		$sodas = array_filter($extras,function($e){return $e->type == 'soda';});
		$vessels = array_filter($extras,function($e){return $e->type == 'vessel';});
		$discounts = $this->model->getDiscounts();
		$itemTypes = $this->model->getItemTypes();
		
		if (isset($_POST['page'])) {
			switch ($_POST['page']) {
				case 'process':
					$order = $this->model->buildOrder($_POST);
					$this->model->saveOrder($order);
					include_once 'MVC/View/process.php';
				break;
				
				case 'history':
					$orders = $this->model->getOrders();
					include_once 'MVC/View/history.php';
				break;
				
				default:
					include_once 'MVC/View/order.php';
				break;
			}
		}
		else{
			include_once 'MVC/View/order.php';
		}
		
		
	}
}