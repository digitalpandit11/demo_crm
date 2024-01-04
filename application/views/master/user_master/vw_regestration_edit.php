<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Edit User Info</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Data Tables -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css' ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/fontawesome-free/css/all.min.css' ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.css' ?>">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css' ?>">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ?>">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/select2/css/select2.min.css' ?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css' ?>">
	<!-- Bootstrap4 Duallistbox -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css' ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/dist/css/adminlte.min.css' ?>">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Navbar -->
		<?php $this->load->view('header_sidebar'); ?>
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
		<div class="content-wrapper">
			<!-- Content Wrapper. Contains page content -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">User Master</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_regestration_data' ?>">User Master</a>
									<li class="breadcrumb-item">Edit User Master Form
									</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<!-- general form elements disabled -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Edit User Info Form</h3>
								</div>
								<div class="card-body" style="border-radius: 1.25rem;">
									<?php
									$entity_id = $sata['entity_id'];
									$username = $sata['user_name'];
									$password = $sata['password'];
									$simple_password = $sata['simple_password'];
									$role_id = $sata['role_id'];
									$company_id = $sata['company_id'];
									$full_name = $sata['full_name'];
									$mobile_no = $sata['mobile_no'];
									$designation = $sata['designation'];
									// print_r($designation);
									// die();
									?>
									<form role="form" name="client_info" action="<?php echo site_url('master/user_master/update_info'); ?>" method="post">
										<div class="row">

											<div class="col-sm-6">
												<div class="form-group">
													<label> Employee Name </label>
													<select class="form-control select2bs4" style="width: 100%;" id="emp_id" name="emp_id">
														<option value="">Not Selected</option>
														<?php foreach ($employee as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->emp_first_name; ?> <?php echo $row->emp_middle_name; ?> <?php echo $row->emp_last_name; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											</div>
										<div class="row">


											<div class="col-sm-3">
												<!-- text input -->
												<div class="form-group">
													<label>User Name</label>
													<input type="text" class="form-control" name="user_name" id="user_name" placeholder="Full Name" required="required">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label>Password</label>
													<input type="checkbox" onclick="myPassword()">Show Password
													<input type="Password" class="form-control" name="simple_password" id="simple_password" placeholder="Password" required="required">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<!-- textarea -->
												<div class="form-group">
													<label>Role</label>
													<select class="form-control" style="width: 100%;" id="role_id" name="role_id" required>
														<option value="">No Selected</option>	<?php foreach ($role_list as $role) { ?>
														<option value="<?php echo $role->entity_id; ?>"><?php echo $role->role_name; ?></option>
													<?php } ?>
													</select>
												</div>
											</div>

											<!-- <div class="col-sm-4"> -->
												<!-- text input -->
												<!-- <div class="form-group">
													<label>Full Name</label>
													<input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" required="required">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label>Mobile No</label>
													<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" required="required">
												</div>
											</div> -->

										</div>
										<!-- <div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>Designation</label>
													<input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" required="required">
												</div>
											</div>
										</div> -->
										<div class="row">
											<div class="col-sm-4">
												<!-- textarea -->
												<div class="form-group">
													<label>Activation Status</label>
													<select class="form-control" style="width: 100%;" id="activation_status" name="activation_status" required>
														<option value="1">Active</option>	
														<option value="2">In-Active</option>
													</select>
												</div>
											</div>
										</div>
										<input type="hidden" class="form-control" name="entity_id" id="entity_id" value="<?php echo $entity_id; ?>" placeholder="Entity_id" required="required">

										<div class="card-body">
											<center>
												<button type="submit" class="btn btn-success toastrDefaultSuccess">
													Update
												</button>
											</center>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php $this->load->view('footer'); ?>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->
	<script src="<?php echo base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
	<!-- Select2 -->
	<script src="<?php echo base_url() . 'assets/plugins/select2/js/select2.full.min.js' ?>"></script>
	<!-- Bootstrap4 Duallistbox -->
	<script src="<?php echo base_url() . 'assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js' ?>"></script>
	<!-- InputMask -->
	<script src="<?php echo base_url() . 'assets/plugins/moment/moment.min.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>
	<!-- date-range-picker -->
	<script src="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.js' ?>"></script>
	<!-- bootstrap color picker -->
	<script src="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js' ?>"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?php echo base_url() . 'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' ?>"></script>
	<!-- Bootstrap Switch -->
	<script src="<?php echo base_url() . 'assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js' ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url() . 'assets/dist/js/adminlte.min.js' ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url() . 'assets/dist/js/demo.js' ?>"></script>
	<!-- DataTables -->
	<script src="<?php echo base_url() . 'assets/plugins/datatables/jquery.dataTables.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js' ?>"></script>
	<!-- Page script -->
	<script>
		$(function() {
			$("#example1").DataTable();
			$('#example2').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false,
			});
		});
	</script>
	<script>
		function myPassword() {
			var x = document.getElementById("simple_password");
			if (x.type === "simple_password") {
				x.type = "text";
			} else {
				x.type = "simple_password";
			}
		}
	</script>


	<script type="text/javascript">
		$(document).ready(function() {
			//call function get data edit
			get_data_edit();

			//load data for edit
			function get_data_edit() {
				var entity_id = $('[name="entity_id"]').val();

				$.ajax({
					url: "<?php echo site_url('master/user_master/get_user_details_by_id'); ?>",
					method: "POST",
					data: {
						entity_id: entity_id
					},
					async: true,
					dataType: 'json',
					success: function(data) {
						$.each(data, function(i, item) {
							console.log(data);
							$val =
								$('[name="user_name"]').val(data[i].user_name);
							$('[name="simple_password"]').val(data[i].simple_password);
							// $('[name="full_name"]').val(data[i].full_name);
							// $('[name="mobile_no"]').val(data[i].mobile_no);
							$('[name="entity_id"]').val(data[i].entity_id);
							$('[name="role_id"]').val(data[i].role_id).trigger('change');
							$('[name="activation_status"]').val(data[i].activation_status);
							$('[name="emp_id"]').val(data[i].emp_id).trigger('change');

						});
					}
				});
			}
		});
	</script>
</body>

</html>