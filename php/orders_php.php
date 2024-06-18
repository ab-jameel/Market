<?php
	require_once 'connect.php';
	require_once 'OrderORM.php';

	$orderORM = new OrderORM($conn);

	$update = false;

	if(isset($_POST['save'])){
		$customer_id = $_POST['customer_id'];
		$store_id = $_POST['store_id'];
		$quantity = $_POST['quantity'];
		$sales_total = $_POST['sales_total'];
		$o_date = $_POST['o_date'];
		$p_method = $_POST['payment_method'];
		$count_p_method = count($p_method);

		$orderORM->addOrder($customer_id, $store_id, $quantity, $sales_total, $o_date, $p_method);

		header("Location:http://localhost/market/orders.php");
	}

	if(isset($_POST['update'])){
		$id = $_POST['sale_id'];
		$customer_id = $_POST['customer_id'];
		$store_id = $_POST['store_id'];
		$quantity = $_POST['quantity'];
		$sales_total = $_POST['sales_total'];
		$o_date = $_POST['o_date'];
		$p_method = $_POST['payment_method'];
		$count_p_method = count($p_method);

		$orderORM->updateOrder($id, $customer_id, $store_id, $quantity, $sales_total, $o_date, $p_method);

		header("Location:http://localhost/market/orders.php");
	}

	if(isset($_GET['edit'])){
		$id = $_GET['edit'];

		$data = $orderORM->getOrderById($id);
		if(empty($data)){
			header("Location:http://localhost/market/orders.php");
		}else{
			$update = true;
			$customer_id = $data['customer_id'];
			$store_id = $data['store_id'];
			$quantity = $data['quantity'];
			$sales_total = $data['sales_total'];
			$o_date = $data['o_date'];
		}
	}

	if(isset($_GET['delete'])){
		$id = $_GET['delete'];

		$orderORM->deleteOrder($id);

		header("Location:http://localhost/market/orders.php");
	}

?>