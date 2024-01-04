<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$_SESSION['user_name']) {
	header("location:welcome");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>All Campaign Register</title>
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
							<h1 class="card-title"> Campaign Clients List</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_campaign' ?>">Campaign Register</a>
									</li>
									<li class="breadcrumb-item">Campaign Clients List
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
									<h3 class="card-title">Campaign Registered Clients </h3>
								</div>
								<div class="row col-md-12 p-3 ">
									<div class="col-md-4">
										<span class="text-primary p-3 font-weight-bold">Campaign Name : - </span><label><?php echo $campaign_data['campaign_name']; ?></label>
									</div>
									<div class="col-md-4">

										<span class="text-primary p-3 font-weight-bold">Assigned To : - </span><label> <?php echo $campaign_data['emp_first_name']; ?></label>
									</div>
									<div class="col-md-4">

										<span class="text-primary p-3 font-weight-bold">Started Date : - </span><label><?php echo $campaign_data['start_date']; ?></label>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Sr. No.</th>
													<th>Client Name</th>
													<th>Email id</th>
													<th>Mobile Number</th>
													<th>Company Name</th>
													<th>State</th>
													<th>City</th>
													<th>Pin Code</th>
													<th>Website</th>
													<th>Source</th>
													<th>Category</th>
													<th>Designation</th>
													<th>Address</th>
													<th>DND</th>
													<th>Last Call Date And Time</th>
													<th>Attended By</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 0;
												$campaign_id = $campaign_data['entity_id'];
												foreach ($campaign_telephone_numbers as $value) :
													$no++;
													$entity_id = $value->entity_id;

													$this->db->select('*');
													$this->db->from('call_log');
													$this->db->where('campaign_relation_id', $entity_id);
													$this->db->order_by('entity_id', 'desc');
													$this->db->limit(1);
													$query = $this->db->get();
													$call_data = $query->row();


													if ($call_data) {

														$last_log_date = $call_data->last_log_date;
														$user_id = $call_data->user_id;




														if ($call_data->status == 1) {
															$Enquiry_status = "Not Started";
														} else if ($call_data->status == 2) {

															$Enquiry_status = "In Process";
														} else if ($call_data->status == 3) {

															$Enquiry_status = "Complete";
														} else {
															$Enquiry_status = "";
														}
														// $Enquiry_status = $value->status;
														if ($call_data->dnd == 0) {
															$dnd = "";
														} else if ($call_data->dnd == 1) {
															$dnd = "DND";
														}
													} else {
														$Enquiry_status = "";
														$dnd = '';
														$last_log_date = "";
														$user_id = "";
													}
													/*
														if ($dnd_data['status']== 1) {
																$status="pending";
														}
														else if ($dnd_data['status']== 2) {
																$status="Call Not Recieved";
														}
														else if ($dnd_data['status']== 3) {
																$status="Call Recieved";
														}*/


													$last_call_query = $this->db->select('last_log_date,user_id')->from('call_log')->where('telephone_id', $entity_id)->order_by('entity_id', 'DESC')->limit(1)->get();

													if($last_call_query->num_rows())
													{
														
													$user_id = $last_call_query->row_array()['user_id'];
													$user = $this->db->select('user_name')->from('user_login')->where('entity_id', $user_id)->get()->row_array();
													}else{
														$user = "";
													}

												?>
													<tr>
														<td><?php echo $no; ?></td>
														<td><b><?php echo $value->client_name; ?></b></td>
														<td><?php echo $value->email; ?></td>
														<td><?php echo $value->mobile; ?></td>
														<td><?php echo $value->company_name; ?></td>
														<td><?php echo $value->state; ?></td>
														<td><?php echo $value->city; ?></td>
														<td><?php echo $value->pincode; ?></td>
														<td><?php echo $value->website; ?></td>
														<td><?php echo $value->source; ?></td>
														<td><?php echo $value->category; ?></td>
														<td><?php echo $value->designation; ?></td>
														<td><?php echo $value->address; ?></td>
														<td><?php echo $dnd; ?></td>
														<td><?php echo $last_log_date; ?></td>
														<td><?php echo $user_id; ?></td>
														<td><?php echo $Enquiry_status; ?></td>
														<td>
															<div class="btn-group">
																<a href="<?php echo site_url('view_call_log2/' . $value->entity_id); ?>" class="btn btn-sm btn-success"><i class="fa fa-phone" aria-hidden="true"></i></a> &nbsp;&nbsp;
															</div>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
								<!-- /.card-body -->
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
	<!-- jQuery -->
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
		$('#example1').dataTable({
			"pageLength": 50
		});
	</script>
</body>

</html>