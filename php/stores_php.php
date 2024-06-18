<?php
	require_once 'connect.php';
	require_once 'StoresBO.php';

	$storesBO = new StoresBO($conn);

	$update = false;

	if(isset($_POST['save'])){
		$s_location = $_POST['s_location'];

		$storesBO->add_store($s_location);

		header("Location:http://localhost/market/stores.php");
	}

	if(isset($_POST['update'])){
		$id = $_POST['store_id'];
		$s_location = $_POST['s_location'];

		$storesBO->update_store($id, $s_location);

		header("Location:http://localhost/market/stores.php");
	}

	if(isset($_GET['edit'])){
		$id = $_GET['edit'];

		$data = $storesBO->get_store_ById($id);

		if(empty($data)){
			header("Location:http://localhost/market/stores.php");
		}else{	
			$update = true;
			$s_location = $data['s_location'];
		}
	}

	if(isset($_GET['delete'])){
		$id = $_GET['delete'];

		$storesBO->delete_store($id);

		header("Location:http://localhost/market/stores.php");
	}

?>