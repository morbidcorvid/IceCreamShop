<?php
ini_set('display_errors',1);  error_reporting(E_ALL);

include_once 'MVC/Controller/controller.php';

$controller = new Controller();
$controller->invoke();
?>