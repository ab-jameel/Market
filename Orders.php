<html>
	<head>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
	        	function sanitizeInput(event) {
	            	var inputValue = event.target.value;
	            	var sanitizedValue = inputValue.replace(/[^0-9]/g, '');
	            	event.target.value = sanitizedValue;
	        	}

	        	document.getElementById('quantity').addEventListener('input', sanitizeInput);
	        	document.getElementById('sales_total').addEventListener('input', sanitizeInput);
        	});

		    function addInput() {
		    	var lineBreak = document.createElement("br");
		        
		        var newInput = document.createElement("input");
		        newInput.type = "text";
		        newInput.className = "form-control";
		        newInput.name = "payment_method[]";

			    var container = document.getElementById("inputContainer");
			    container.appendChild(lineBreak);
			    container.appendChild(newInput);
			}
    	</script>

	    <style>
	        .btn-spacing {
	            margin-right: 10px; /* Adjust the margin as needed */
	        }
	    </style>

		<?php
		require_once 'php/orders_php.php';
		$customers = $conn->query("SELECT * FROM m_customer") or die($conn->error());
		$stores = $conn->query("SELECT * FROM m_store") or die($conn->error());
		?>

		<title>Orders</title>
	</head>

	<body class="container">
		<br>
		<h1 style="text-align: center;">Orders</h1>
		<br>
		<br>
		<form action="php/orders_php.php" method="POST" class="row g-3">
			<input type="hidden" name="sale_id" value="<?php if($update == true) echo $id; ?>">
			<div class="row">
			<div class="col-md-3">
				<label for="customer_id" class="form-label">Customer Name</label>
				<select class="form-select" name="customer_id">
					<?php while($data = $customers->fetch_assoc()){ ?>
						<option <?php if($update == true && $customer_id == $data['customer_id']) echo 'selected'; ?> value="<?php echo $data['customer_id']; ?>" ><?php echo $data['c_name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-3">
				<label for="store_id" class="form-label">Store Location</label>
				<select class="form-select" name="store_id">
					<?php while($data = $stores->fetch_assoc()){ ?>
						<option <?php if($update == true && $store_id == $data['store_id']) echo 'selected'; ?> value="<?php echo $data['store_id']; ?>" ><?php echo $data['s_location']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-2">
				<label for="quantity" class="form-label">Quantity</label>
				<input type="text" class="form-control" id="quantity" name="quantity" value="<?php if($update == true) echo $quantity; ?>" required>
			</div>
			<div class="col-md-2">
				<label for="sales_total" class="form-label">Total</label>
				<input type="text" class="form-control" id="sales_total" name="sales_total" value="<?php if($update == true) echo $sales_total; ?>" required>
			</div>
			<div class="col-md-2">
				<label for="o_date" class="form-label">Date</label>
				<input type="date" class="form-control" name="o_date" value="<?php if($update == true) echo $o_date; ?>" required>
			</div>
		</div>
		<br>
		<br>
		<br>
		<br>
		<div class="row">
			<div class="col-md-12 d-flex justify-content-center">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#order_details">Add payment methods</button>
			</div>
		</div>


			<div class="modal" id="order_details">
			    <div class="modal-dialog">
			        <div class="modal-content">

			            <div class="modal-header">
			                <h4 class="modal-title">Payment Details</h4>
			            </div>

			            <div class="modal-body" id="inputContainer">
							<div class="row">
							    <div class="col">
							        <label for="input1">Payment method</label>
							    </div>

							    <div class="col-auto">
				                    <button type="button" class="btn btn-outline-secondary border-0 justify-content-end" onclick="addInput()">
				                    	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
											<path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
											<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
										</svg>
									</button>
								</div>
							</div>
							<?php 
								if($update == true){
									$details = $conn->query("SELECT * FROM order_details WHERE sale_id = $id") or die($conn->error());
									if($details->num_rows < 1){
							?>
										<input type="text" class="form-control" name="payment_method[]" required>
							<?php
									}else{
									while($data = $details->fetch_assoc()){
							?>
										<input type="text" class="form-control" name="payment_method[]" value="<?php echo $data['payment_method']?>" >
										<br>
							<?php 	}}}else{ ?>
										<input type="text" class="form-control" name="payment_method[]" required>
							<?php 	} ?>
			            </div>

			            <div class="modal-footer">
			                <button type="submit" class="btn btn-primary" name="<?php if($update == true) echo "update"; else echo "save"; ?>">Submit</button>
			                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			            </div>

			        </div>
			    </div>
			</div>

		</form>

		<br>
		<?php
			$result = $conn->query("SELECT * FROM m_order") or die($conn->error());
		?>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Customer Name</th>
					<th scope="col">Store Location</th>
					<th scope="col">Quantity</th>
					<th scope="col">Total</th>
					<th scope="col">Date</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<?php
					while($data = $result->fetch_assoc()){
						$c_id = $data['customer_id'];
						$s_id = $data['store_id'];

						$customer = $conn->query("SELECT * FROM m_customer WHERE customer_id = $c_id") or die($conn->error());
						$d_customer = $customer->fetch_assoc();

						$store = $conn->query("SELECT * FROM m_store WHERE store_id = $s_id") or die($conn->error());
						$d_store = $store->fetch_assoc();
				?>
				<tr>
					<th><?php echo $data['sale_id']; ?></th>
					<th><?php echo $d_customer['c_name']; ?></th>
					<th><?php echo $d_store['s_location']; ?></th>
					<th><?php echo $data['quantity']; ?></th>
					<th><?php echo $data['sales_total']; ?></th>
					<th><?php echo $data['o_date']; ?></th>
					<th>
						<a href="orders.php?edit=<?php echo $data['sale_id']; ?>" class="btn btn-outline-secondary">
                  			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
								<path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
							</svg>
                  			<span class="visually-hidden">Edit</span>
                		</a>
						<a href="orders.php?delete=<?php echo $data['sale_id']; ?>" class="btn btn-outline-secondary">
                			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
								<path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
							</svg>
                		</a>
                	</th>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>

		<div class="d-flex justify-content-end">
			<a href="customers.php" class="btn btn-warning btn-spacing">Customers</a>
			<a href="stores.php" class="btn btn-warning">Stores</a>
		</div>

	</body>

</html>