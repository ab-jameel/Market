<?php
	require_once 'connect.php';
	require_once 'CustomerBO.php';

	$customerBO = new CustomerBO($conn);

	$update = false;

	if(isset($_POST['save'])){
		$c_name = $_POST['c_name'];
		$c_city = $_POST['c_city'];
		$mobile_number = $_POST['mobile_number'];
		$c_gender = $_POST['c_gender'];
		$imag = $_FILES['imag'];

		$customerBO->addCustomer($c_name, $c_city, $mobile_number, $c_gender, $imag);

		header("Location:http://localhost/market/customers.php");
	}

	if(isset($_POST['update'])){
		$id = $_POST['customer_id'];
		$c_name = $_POST['c_name'];
		$c_city = $_POST['c_city'];
		$mobile_number = $_POST['mobile_number'];
		$c_gender = $_POST['c_gender'];

		$customerBO->updateCustomer($id, $c_name, $c_city, $mobile_number, $c_gender);

		header("Location:http://localhost/market/customers.php");
	}

	if(isset($_GET['edit'])){
		$id = $_GET['edit'];
		$customerData = $customerBO->getCustomerById($id);

		if(empty($customerData)){
			header("Location:http://localhost/market/customers.php");
		}else{
			$update = true;
			$c_name = $customerData['c_name'];
			$c_city = $customerData['c_city'];
			$mobile_number = $customerData['mobile_number'];
			$c_gender = $customerData['c_gender'];
		}
	}

	if(isset($_GET['delete'])){
		$id = $_GET['delete'];

    	$result = $customerBO->deleteCustomer($id);

		header("Location:http://localhost/market/customers.php");
	}

?>