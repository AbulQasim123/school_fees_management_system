<?php

//index.php

include('database_connection.php');

if (!is_login()) {
	header('location:login.php');
}

include('header.php');

?>

<div class="container-fluid px-4">
	<h1 class="mt-2">Dashboard</h1>
	
	<ol class="breadcrumb mb-4">
		<li class="breadcrumb-item active">Dashboard</li>
	</ol>

	<div class="row">
		<div class="col-xl-3 col-md-6">
			<div class="card bg-primary text-white mb-4">
				<div class="card-body">
					<h2 class="text-center"></h2>
					<h5 class="text-center"></h5>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card bg-warning text-white mb-4">
				<div class="card-body">
					<h2 class="text-center"></h2>
					<h5 class="text-center"></h5>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card bg-danger text-white mb-4">
				<div class="card-body">
					<h2 class="text-center"></h2>
					<h5 class="text-center"></h5>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card bg-success text-white mb-4">
				<div class="card-body">
					<h2 class="text-center"></h2>
					<h5 class="text-center"></h5>
				</div>
			</div>
		</div>
	</div>

	<?php include('footer.php'); ?>
