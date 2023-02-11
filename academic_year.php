<?php
	//academic_year.php
	include('database_connection.php');
	if (!is_login()) {
		header('location:login.php');
	}
	if (!is_master_user()) {
		header('location:index.php');
	}

	$error = '';
	if (isset($_POST['add_academic_year'])) {
		$formdata = array();

		if (empty($_POST['academic_start_year'])) {
			$error .= '<li>Start Year is Required?</li>';
		}else{
			$formdata['academic_start_year'] = $_POST['academic_start_year'];
		}

		if (empty($_POST['academic_start_month'])) {
			$error .= '<li>Start Month is Required?</li>';
		}else{
			$formdata['academic_start_month'] = $_POST['academic_start_month'];
		}

		if (empty($_POST['academic_end_year'])) {
			$error .= '<li>End Year is Required?</li>';
		}else{
			$formdata['academic_end_year'] = $_POST['academic_end_year'];
		}

		if (empty($_POST['academic_end_month'])) {
			$error .= '<li>End Month is Required?</li>';
		}else{
			$formdata['academic_end_month'] = $_POST['academic_end_month'];
		}

		if ($error == '') {
			$query = "
			SELECT * FROM sfms_acedemic_year
			WHERE acedemic_start_year = '".$formdata['academic_start_year']."'
			AND acedemic_start_month = '".$formdata['academic_start_month']."'
			AND acedemic_end_year = '".$formdata['academic_end_year']."'
			AND acedemic_end_month = '".$formdata['academic_end_month']."'
			AND acedemic_year_status = 'Enable'
			";
			$statement = $connect->prepare($query);
			$statement->execute();
			if ($statement->rowCount() > 0) {
				$error .= '<li>Academic Year Data Already Exists</li>';
			}else{
				$data = array(
					':academic_start_year' => $formdata['academic_start_year'],
					':academic_start_month' => $formdata['academic_start_month'],
					':academic_end_year' => $formdata['academic_end_year'],
					':academic_end_month' => $formdata['academic_end_month'],
					':acedemic_added_on' => $datetime,
					':acedemic_year_status' => 'Enable',
				);

				$query = "INSERT INTO sfms_acedemic_year (acedemic_start_year, acedemic_start_month, acedemic_end_year, acedemic_end_month, acedemic_added_on, acedemic_year_status) VALUES (:academic_start_year, :academic_start_month, :academic_end_year, :academic_end_month, :acedemic_added_on :acedemic_year_status)";
				$statement = $connect->prepare($query);
				$statement->execute($data);
				header('location:academic_year.php?msg=add');
			}
		}
	}
		// Edit Academic year
	if (isset($_POST['edit_academic_year'])) {
		$formdata = array();
		if (empty($_POST['academic_start_year'])) {
			$error .= '<li>Start Year is Required?</li>';
		}else{
			$formdata['academic_start_year'] = $_POST['academic_start_year'];
		}

		if (empty($_POST['academic_start_month'])) {
			$error .= '<li>Start Month is Required?</li>';
		}else{
			$formdata['academic_start_month'] = $_POST['academic_start_month'];
		}

		if (empty($_POST['academic_end_year'])) {
			$error .= '<li>End Year is Required?</li>';
		}else{
			$formdata['academic_end_year'] = $_POST['academic_end_year'];
		}

		if (empty($_POST['academic_end_month'])) {
			$error .= '<li>End Month is Required?</li>';
		}else{
			$formdata['academic_end_month'] = $_POST['academic_end_month'];
		}

		if ($error == '') {
			$query = "
			SELECT * FROM sfms_acedemic_year
			WHERE acedemic_start_year = '".$formdata['academic_start_year']."'
			AND acedemic_start_month = '".$formdata['academic_start_month']."'
			AND acedemic_end_year = '".$formdata['academic_end_year']."'
			AND acedemic_end_month = '".$formdata['academic_end_month']."'
			AND acedemic_year_status = 'Enable'
			AND acedemic_year_id != '".$_POST['academic_year_id']."'
			";

			$statement = $connect->prepare($query);
			$statement->execute();
			if ($statement->rowCount() > 0) {
				$error .= '<li>Academic Year Data Already Exists</li>';
			}else{
				$data = array(
					':academic_start_year' => $formdata['academic_start_year'],
					':academic_start_month' => $formdata['academic_start_month'],
					':academic_end_year' => $formdata['academic_end_year'],
					':academic_end_month' => $formdata['academic_end_month'],
					':acedemic_updated_on' => $datetime,
					':academic_year_id' => $_POST['academic_year_id']
				);

				$query ="
				UPDATE sfms_acedemic_year
				SET acedemic_start_year = :academic_start_year,
				acedemic_start_month = :academic_start_month,
				acedemic_end_year = :academic_end_year,
				acedemic_end_month = :academic_end_month,
				acedemic_updated_on = :acedemic_updated_on
				WHERE acedemic_year_id = :academic_year_id
				";

				$statement = $connect->prepare($query);
				$statement->execute($data);
				header('location:academic_year.php?msg=edit');
			}
		}
	}
		// Enable and Disable 
	if (isset($_GET['action'], $_GET['id'], $_GET['status']) && $_GET['action'] == 'delete') {
		$acedemic_year_id = $_GET['id'];
		$acedemic_year_status = $_GET['status'];
		$data = array(
			':acedemic_year_id' => $acedemic_year_id,
			':acedemic_year_status' => $acedemic_year_status,
		);

		$query = "
		UPDATE sfms_acedemic_year
		SET acedemic_year_status = :acedemic_year_status
		WHERE acedemic_year_id = :acedemic_year_id
		";

		$statement = $connect->prepare($query);
		$statement->execute($data);
		header('location:academic_year.php?msg='.$acedemic_year_status.'');
	}

	include('header.php');
?>
<div class="container-fluid mt-4">
	<h3 class="mt-4">Academic Year Management</h3>
	
	<?php
		if (isset($_GET['action'])) {
			if ($_GET['action'] == 'add') {
	?>
	<ol class="breadcrumb mb-4">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="academic_year.php">Academic Year Management</a></li>
		<li class="breadcrumb-item active">Add Academic Year</li>
	</ol>
	<div class="row">
		<div class="col-md-6">
			<?php
				if($error != '')
				{
					echo '<div class="alert alert-danger alert-dismissible fade show"><ul class="list-unstyled">'.$error.'</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
				}
			?>
			<div class="card mb-4">
				<div class="card-header">
					<i class="fas fa-user-plus"></i> Add Academic Year
				</div>
				<div class="card-body">
					<form method="post">
						<div class="mb-3">
							<label>Select Start Year <span class="text-danger">*</span></label>
							<select name="academic_start_year" class="form-control">
								<option value="">Select Start Year</option>
								<?php
									for ($i= date('Y'); $i <= date('Y') +5 ; $i++) { 
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								?>
							</select>
						</div>
						<div class="mb-3">
							<label>Select Start Month <span class="text-danger">*</span></label>
							<select name="academic_start_month" class="form-control">
								<option value="">Select Start Month</option>
								<?php
									for ($i= 0; $i < count($month_array); $i++) { 
										echo '<option value="'.$month_array[$i].'">'.$month_array[$i].'</option>';
									}
								?>
							</select>
						</div>
						<div class="mb-3">
							<label>Select End Year <span class="text-danger">*</span></label>
							<select name="academic_end_year" class="form-control">
								<option value="">Select Start Year</option>
								<?php
									for ($i= date('Y') + 1; $i <= date('Y') + 6 ; $i++) { 
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								?>
							</select>
						</div>
						<div class="mb-3">
							<label>Select End Month <span class="text-danger">*</span></label>
							<select name="academic_end_month" class="form-control">
								<option value="">Select Start Year</option>
								<?php
									for ($i= 0; $i < count($month_array); $i++) { 
										echo '<option value="'.$month_array[$i].'">'.$month_array[$i].'</option>';
									}
								?>
							</select>
						</div>
						<div class="mt-4 mb-0">
							<input type="submit" name="add_academic_year" class="btn btn-success btn-sm" value="Add" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
		}else if($_GET['action'] == 'edit'){
			if (isset($_GET['id'])) {
				$query = "SELECT * FROM sfms_acedemic_year WHERE acedemic_year_id = '". $_GET['id'] ."' ";
				$academic_year_array = $connect->query($query, PDO::FETCH_ASSOC);
				foreach ($academic_year_array as $academic_year_row) {
	?>

	<ol class="breadcrumb mb-4">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="academic_year.php">Academic Year Management</a></li>
		<li class="breadcrumb-item">Edit Academic Year</li>
	</ol>
	<div class="row">
		<div class="col-md-6">
			<?php
				if($error != '')
				{
					echo '<div class="alert alert-danger alert-dismissible fade show"><ul class="list-unstyled">'.$error.'</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
				}
			?>
			<div class="card mb-4">
				<div class="card-header">
					<i class="fas fa-user-edit"></i> Edit Academic Year Details
				</div>
				<div class="card-body">
					<form method="post">
						<div class="mb-3">
							<label>Select Start Year <span class="text-danger">*</span></label>
							<select name="academic_start_year" id="academic_start_year" class="form-control">
								<option value="">Select Start Year</option>
								<?php
									for ($i= date('Y'); $i <= date('Y') +5 ; $i++) { 
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								?>
							</select>
						</div>
						<div class="mb-3">
							<label>Select Start Month <span class="text-danger">*</span></label>
							<select name="academic_start_month" id="academic_start_month" class="form-control">
								<option value="">Select Start Month</option>
								<?php
									for ($i= 0; $i < count($month_array); $i++) { 
										echo '<option value="'.$month_array[$i].'">'.$month_array[$i].'</option>';
									}
								?>
							</select>
						</div>
						<div class="mb-3">
							<label>Select End Year <span class="text-danger">*</span></label>
							<select name="academic_end_year" id="academic_end_year" class="form-control">
								<option value="">Select Start Year</option>
								<?php
									for ($i= date('Y') + 1; $i <= date('Y') + 6 ; $i++) { 
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								?>
							</select>
						</div>
						<div class="mb-3">
							<label>Select End Month <span class="text-danger">*</span></label>
							<select name="academic_end_month" id="academic_end_month" class="form-control">
								<option value="">Select Start Year</option>
								<?php
									for ($i= 0; $i < count($month_array); $i++) { 
										echo '<option value="'.$month_array[$i].'">'.$month_array[$i].'</option>';
									}
								?>
							</select>
						</div>
						<div class="mt-4 mb-0">
							<input type="hidden" name="academic_year_id" value="<?php echo $academic_year_row['acedemic_year_id']; ?>">
							<input type="submit" name="edit_academic_year" class="btn btn-success btn-sm" value="Edit" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('#academic_start_year').val('<?php echo $academic_year_row['acedemic_start_year'] ?>');
		$('#academic_start_month').val('<?php echo $academic_year_row['acedemic_start_month'] ?>');
		$('#academic_end_year').val('<?php echo $academic_year_row['acedemic_end_year'] ?>');
		$('#academic_end_month').val('<?php echo $academic_year_row['acedemic_end_month'] ?>');
	</script>
	<?php
				}
			}
		}
	}else{
	?>
	<ol class="breadcrumb mb-4">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Academic Year Management</li>
	</ol>
	<?php
		if (isset($_GET['msg'])) {
			if ($_GET['msg'] == 'add') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Academic Year Data Added <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}
			if ($_GET['msg'] == 'edit') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Academic Year Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}
			if ($_GET['msg'] == 'Enable' || $_GET['msg'] == 'Disable') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">User Status Change to '.$_GET["msg"].' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}
		}
	?>
	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Academic Year Management
				</div>
				<div class="col col-md-6" align="right">
					<a href="academic_year.php?action=add" class="btn btn-primary btn-sm">Add</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<table id="acedemic_year_data" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Start Year</th>
						<th>Start Month</th>
						<th>End Year</th>
						<th>End Month</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<?php } ?>
</div>
<?php
	include('footer.php');
?>

<script type="text/javascript">
	$(document).ready(function(){
		var datatable = $('#acedemic_year_data').DataTable({
			'processing': true,
			'serverSide': true,
			'order': [],
			'ajax': {
				url: 'action.php',
				type: 'post',
				data: { action: 'fetch_academic_year'}
			}
		});

	})

	function delete_data(id,status){
		var new_status = 'Enable';
		if (status == 'Enable') {
			new_status = 'Disable'
		}
		if (confirm('Are you sure you want to ' +new_status+ ' this User?')) {
			window.location.href ='academic_year.php?action=delete&id=' + id + '&status=' + new_status;
		}
	}
</script>