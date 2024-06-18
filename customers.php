<html>
	<head>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
		<script>
			document.getElementById('mobile_number').addEventListener('input', function(event) {
  			var inputValue = event.target.value;
  			var sanitizedValue = inputValue.replace(/[^0-9+]/g, '');
  			event.target.value = sanitizedValue;
			});
		</script>

		<title>Customers</title>

		<?php
		require_once 'php/customers_php.php';
		?>
	</head>

	<body class="container">
		<br>
		<h1 style="text-align: center;">Customers</h1>
		<br>
		<form action="php/customers_php.php" method="POST" class="row g-3" enctype="multipart/form-data">
			<input type="hidden" name="customer_id" value="<?php if($update == true) echo $id; ?>">
			<div class="col-md-3">
				<label for="m_name" class="form-label">Name</label>
				<input type="text" class="form-control" name="c_name" value="<?php if($update == true) echo $c_name; ?>" required>
			</div>
			<div class="col-md-3">
				<label for="mobile_number" class="form-label">Mobile Number</label>
				<input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if($update == true) echo $mobile_number; ?>" required>
			</div>
			<div class="col-md-2">
				<label for="c_city" class="form-label">City</label>
				<input type="text" class="form-control" name="c_city" value="<?php if($update == true) echo $c_city; ?>" required>
			</div>
			<div class="col-md-2">
				<label for="c_gender" class="form-label">Gender</label>
				<select class="form-control" name="c_gender">
					<option <?php if($update == true && $c_gender == 'Male') echo 'selected'; ?>>Male</option>
					<option <?php if($update == true && $c_gender == 'Female') echo 'selected'; ?>>Female</option>
				</select>
			</div>
			<div class="col-md-2">
				<label for="imag" class="form-label">City</label>
				<input type="file" class="form-control" name="imag" value="<?php if($update == true) echo $image; ?>" required>
			</div>
			<div class="col-md-2">
				<br>
				<button type="submit" class="btn btn-primary" name="<?php if($update == true) echo "update"; else echo "save"; ?>">Save</button>
			</div>
		</form>

		<br>
		<?php
			$result = $conn->query("SELECT * FROM m_customer") or die($conn->error());
		?>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Name</th>
					<th scope="col">Mobile Number</th>
					<th scope="col">City</th>
					<th scope="col">Gender</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<?php
					while($data = $result->fetch_assoc()){
				?>
				<tr>
					<th><?php echo $data['customer_id']; ?></th>
					<th><?php echo $data['c_name']; ?></th>
					<th><?php echo $data['mobile_number']; ?></th>
					<th><?php echo $data['c_city']; ?></th>
					<th><?php echo $data['c_gender']; ?></th>
					<th>
						<a href="customers.php?edit=<?php echo $data['customer_id']; ?>" class="btn btn-outline-secondary">
                  			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
								<path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
							</svg>
                  			<span class="visually-hidden">Edit</span>
                		</a>
						<a href="customers.php?delete=<?php echo $data['customer_id']; ?>" class="btn btn-outline-secondary">
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
			<a href="orders.php" class="btn btn-warning">Orders</a>
		</div>

	</body>

</html>