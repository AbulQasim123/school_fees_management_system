<?php
	// academic_standard.php
	include('database_connection.php');

	if (!is_login()) {
		header('location:login.php');
	}
	if (!is_master_user()) {
		header('location:index.php');
	}

	// Add Academic Standard
	$error = '';
	if (isset($_POST['add_academic_standard'])) {
		$formdata = array();

		if (empty($_POST['academic_standard_name'])) {
			$error .= '<li>Standard Name is Required?</li>';
		}else{
			$formdata['academic_standard_name'] = trim($_POST['academic_standard_name']);
		}

		if (empty($_POST['academic_standard_division'])) {
			$error .= '<li>Standard Division is Required?</li>';
		}else{
			$formdata['academic_standard_division'] = trim($_POST['academic_standard_division']);
		}

		if ($error == '') {
			$query = "
			SELECT * FROM sfms_acedemic_standard
			WHERE acedemic_standard_name = '".$formdata['academic_standard_name']."'
			AND acedemic_standard_division = '".$formdata['academic_standard_division']."'
			AND acedemic_standard_status = 'Enable'
			";

			$statement = $connect->prepare($query);
			$statement->execute();

			if ($statement->rowCount() > 0) {
				$error .= '<li>Academic Standard Data Already Exists</li>';
			}else{
				$data = array(
					':acedemic_standard_name' => $formdata['academic_standard_name'],
					':acedemic_standard_division' => $formdata['academic_standard_division'],
					':acedemic_standard_status' => 'Enable',
					':acedemic_standard_added_on' => $datetime,
				);

				$query = "INSERT INTO sfms_acedemic_standard (acedemic_standard_name,acedemic_standard_division,acedemic_standard_status,acedemic_standard_added_on) VALUES (:acedemic_standard_name, :acedemic_standard_division, :acedemic_standard_status, :acedemic_standard_added_on)";

				$statement = $connect->prepare($query);
				$statement->execute($data);
				header('location:academic_standard.php?msg=add');
			}
		}
	}

	// Edit Academic Standard
	if (isset($_POST['edit_academic_standard'])) {
		$formdata = array();

		if (empty($_POST['academic_standard_name'])) {
			$error .= '<li>Standard Name is Required?</li>';
		}else{
			$formdata['academic_standard_name'] = trim($_POST['academic_standard_name']);
		}

		if (empty($_POST['academic_standard_division'])) {
			$error .= '<li>Standard Division is Required?</li>';
		}else{
			$formdata['academic_standard_division'] = trim($_POST['academic_standard_division']);
		}

		if ($error == '') {
			$query = "SELECT * FROM sfms_acedemic_standard
			WHERE acedemic_standard_name = '".$formdata['academic_standard_name']."'
			AND acedemic_standard_division = '".$formdata['academic_standard_division']."'
			AND acedemic_standard_status = 'Enable'
			AND acedemic_standard_id != '".$_POST['academic_standard_id']."'
			";

			$statement = $connect->prepare($query);
			$statement->execute();

			if ($statement->rowCount() > 0 ) {
				$error .= '<li>Academic Standard Data Already Exists</li>';
			}else{
				$data = array(
					':acedemic_standard_name' => $formdata['academic_standard_name'],
					':acedemic_standard_division' => $formdata['academic_standard_division'],
					':acedemic_standard_updated_on' => $datetime,
					':acedemic_standard_id' => $_POST['academic_standard_id']
				);

				$query = "
				UPDATE sfms_acedemic_standard
				SET acedemic_standard_name = :acedemic_standard_name,
				acedemic_standard_division = :acedemic_standard_division,
				acedemic_standard_updated_on = :acedemic_standard_updated_on
				WHERE acedemic_standard_id = :acedemic_standard_id
				";

				$statement = $connect->prepare($query);
				$statement->execute($data);
				header('location:academic_standard.php?msg=edit');
			}
		}
	}
	 
	// Enable and Disable 
	if (isset($_GET['action'], $_GET['id'], $_GET['status']) && $_GET['action'] == 'delete') {
		$academic_standard_id = $_GET['id'];
		$academic_standard_status = trim($_GET['status']);

		$data = array(
			':academic_standard_id' => $academic_standard_id,
			':academic_standard_status' => $academic_standard_status,
		);

		$query = "
		UPDATE sfms_acedemic_standard
		SET acedemic_standard_status = :academic_standard_status
		WHERE acedemic_standard_id = :academic_standard_id
		";

		$statement = $connect->prepare($query);
		$statement->execute($data);

		header('location:academic_standard.php?msg='.$academic_standard_status);

	}

	include('header.php');
?>

<div class="container-fluid px-4">
	<h3 class="mt-4">Academic Standard Management</h3>
	
	<?php
		if (isset($_GET['action'])) {
			if ($_GET['action'] == 'add') {
	?>

	<ol class="breadcrumb mb-4">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="academic_standard.php">Academic Standard Management</a></li>
		<li class="breadcrumb-item active">Add Academic Standard</li>
	</ol>
	<div class="row">
		<div class="col-md-6">
			<?php
				if ($error != '') {
					echo '<div class="alert alert-danger alert-dismissible fade show"><ul class="list-unstyled">'.$error.'</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
				}
			?>
			<div class="card mb-4">
				<div class="card-header">
					<i class="fas fa-user-plus"></i> Add Academic Standard
				</div>
				<div class="card-body">
					<form method="post">
						<div class="mb-3">
							<label for="academic_standard_name">Enter Standard Name <span class="text-danger">*</span></label>
							<input type="text" name="academic_standard_name" id="academic_standard_name" class="form-control">
						</div>
						<div class="mb-3">
							<label for="academic_standard_division">Select Division <span class="text-danger">*</span></label>
							<select name="academic_standard_division" class="form-control">
								<option value="">Select Division</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
						<div class="mt-4 mb-0">
							<input type="submit" name="add_academic_standard" class="btn btn-primary btn-sm" value="Add">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
		}else if($_GET['action'] == 'edit'){
			if ($_GET['id']) {
				$query = "SELECT * FROM sfms_acedemic_standard WHERE acedemic_standard_id = '".$_GET['id']."' ";

				$academic_standard_result = $connect->query($query, PDO::FETCH_ASSOC);
				foreach ($academic_standard_result as $academic_standard_row) {
	?>
	<ol class="breadcrumb mb-4">
		<li class="breadcrumb-item"><a href="index.php"></a>Dashboard</li>
		<li class="breadcrumb-item"><a href="academic_standard.php">Academic Standard Management</a></li>
		<li class="breadcrumb-item active">Edit Academic Standard</li>
	</ol>
	<div class="row">
		<div class="col-md-6">
			<?php
				if ($error != '') {
					echo '<div class="alert alert-danger alert-dismissible fade show"><ul class="list-unstyled">'.$error.'</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
				}
			?>
			<div class="card mb-4">
				<div class="card-header">
					<i class="fas fa-user-edit"></i> Edit Academic Standard Details
				</div>
				<div class="card-body">
					<form method="post">
						<div class="mb-3">
							<label for="academic_standard_name">Enter Standard Name <span class="text-danger">*</span></label>
							<input type="text" name="academic_standard_name" id="academic_standard_name" class="form-control" value="<?php echo $academic_standard_row['acedemic_standard_name'] ?>">
						</div>
						<div class="mb-3">
							<label for="academic_standard_division">Select Division <span class="text-danger">*</span></label>
							<select name="academic_standard_division" id="academic_standard_division" class="form-control">
								<option value="">Select Division</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
						<div class="mt-4 mb-0">
							<input type="hidden" name="academic_standard_id" value="<?php echo $academic_standard_row['acedemic_standard_id'] ?>">
							<input type="submit" name="edit_academic_standard" class="btn btn-primary btn-sm" value="Edit">
						</div>
					</form>
					<script type="text/javascript">
						$('#academic_standard_division').val('<?php echo $academic_standard_row['acedemic_standard_division'] ?>');
					</script>
				</div>
			</div>
		</div>
	</div>
	<?php
		}
				}
			}
		}else{
	?>
	<ol class="breadcrumb mb-4">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Academic Standard Management</li>
	</ol>
	<?php
		if (isset($_GET['msg'])) {
			if ($_GET['msg'] == 'add') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Academic Standard Data Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}
			if ($_GET['msg'] == 'edit') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Academic Standard Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
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
					<i class="fas fa-table me-1"></i> Academic Standard Management
				</div>
				<div class="col col-md-6" align="right">
					<a href="academic_standard.php?action=add" class="btn btn-primary btn-sm">Add</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<table id="academic_standard_data" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Standard Name</th>
						<th>Division</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<?php 
		}
	?>
</div>

<?php
	include('footer.php');
?>

<script type="text/javascript">
	$(document).ready(function(){
		var datatable = $('#academic_standard_data').DataTable({
			'processing' : true,
			'serverSide' : true,
			'order'      : [],
			'ajax'       : {
				url  : 'action.php',
				type : 'post',
				data : {action: 'fetch_academic_standard'}
			}
		})
	})

		// Enable and Disable Data
	function delete_data(id,status){
		var new_status = 'Enable'
		if (status == 'Enable') {
			new_status = 'Disable';
		}
		if (confirm('Are you sure you want to ' + new_status + 'this User')) {
			window.location.href = 'academic_standard.php?action=delete&id='+ id + '&status=' + new_status;
		}
	}
</script>