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
		$discounts = $this->model->getDiscounts();
		$itemTypes = $this->model->getItemTypes();
		$itemTypeExtras = $this->model->getItemTypeExtras();
		$extraTypes = $this->model->getExtraTypes();
		
		
		
		if (isset($_REQUEST['page'])) {
			switch ($_REQUEST['page']) {
				case 'process':
					$order = $this->model->buildOrder($_REQUEST['name'],$_REQUEST['items']);
					//$this->model->saveOrder($order);
					include_once 'MVC/View/process.php';
				break;
				
				case 'history':
					$orders = $this->model->getOrders();
					include_once 'MVC/View/history.php';
				break;
					
				case 'order':
					include_once 'MVC/View/order.php';
				break;
				
				case 'manage':
					include_once 'MVC/View/manage.php';
				break;
				
				default:
					include_once 'MVC/View/home.php';
				break;
			}
		}
		else{
			include_once 'MVC/View/home.php';
		}
		
		
	}
}