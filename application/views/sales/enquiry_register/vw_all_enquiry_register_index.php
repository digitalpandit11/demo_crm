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
	<title>All Lead Register</title>
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
							<h1 class="card-title">All Lead Register</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_all_enquiry_data' ?>"> All Lead Register</a>
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
									<h3 class="card-title">Lead Register</h3>
								</div>
								<div>
									<div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
										<a href="create_customer_enquiry" class="btn btn-block btn-primary">
											Create Lead
										</a>
									</div>
									<div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
										<a href="<?php echo base_url() . 'vw_enquiry_data' ?>" class="btn btn-block btn-primary">
											Working Lead's
										</a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Sr. No.</th>
													<th>Lead Number</th>
													<!-- <th>Customer Name</th> -->
													<th>Contact Person</th>
													<th>Contact No.</th>
													<th>Email</th>
													<th>Lead Description</th>
													<th>Lead Type</th>
													<th>Lead Date</th>
													<th>Lead Status</th>
													<th>Regret Reason</th>
													<th>Employee Name</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 0;
												foreach ($enquiry_details as $row) :
													$no++;
													$entity_id = $row->entity_id;
													$Enquiry_status = $row->enquiry_status;

													$customer_id = $row->customer_id;
													$contact_id = $row->contact_person_id;

													$this->db->select('*');
													$this->db->from('customer_contact_master');
													$where = '(customer_contact_master.entity_id = "' . $contact_id . '")';
													$this->db->where($where);
													$query = $this->db->get();
													$query_num_rows = $query->num_rows();

													if($query_num_rows)
													{
													$query_result = $query->row_array();

													$Contact_person = $query_result['contact_person'];
													$First_contact_no = $query_result['first_contact_no'];
													$Email = $query_result['email_id'];
													}else{
														
													$Contact_person = "";
													$First_contact_no = "";
													$Email = "";

													}

													$Enquiry_type = $row->enquiry_type;
													if ($Enquiry_status == 1) {
														$en_status = "Pending";
													} elseif ($Enquiry_status == 2) {
														$en_status = "Offer Created";
													} elseif ($Enquiry_status == 3) {
														$en_status = "Order Created";
													} elseif ($Enquiry_status == 4) {
														$en_status = "Lead Lost";
													} elseif ($Enquiry_status == 5) {
														$en_status = "Offer Lost";
													} elseif ($Enquiry_status == 6) {
														$en_status = "Order Cancled";
													} elseif ($Enquiry_status == 7) {
														$en_status = "Lead Regretted";
													}

													if ($Enquiry_type == 1) {
														$Enq_type = "Pull Cord (MH)";
													} elseif ($Enquiry_type == 2) {
														$Enq_type = "Porximity (PS)";
													} elseif ($Enquiry_type == 3) {
														$Enq_type = "Vibrator Control (VC)";
													} elseif ($Enquiry_type == 4) {
														$Enq_type = "Treading (TD)";
													} elseif ($Enquiry_type == 5) {
														$Enq_type = "Other (OT)";
													}
												?>
													<tr>
														<td><?php echo $no; ?></td>
														<td><?php echo $row->enquiry_no; ?></td>
														<!-- <td><b><?php echo $row->customer_name; ?></b></td> -->
														<td><b><?php echo $Contact_person; ?><b></td>
														<td><?php echo $First_contact_no; ?></td>
														<td><b><?php echo $Email; ?><b></td>
														<td><?php echo $row->enquiry_short_desc; ?></td>
														<td><?php echo $Enq_type; ?></td>
														<td><?php echo date("d-m-Y", strtotime($row->enquiry_date)); ?></td>
														<td><?php echo $en_status; ?></td>
														<td><?php echo $row->enquiry_rejected_reason; ?></td>
														<td><?php echo $row->emp_first_name; ?></td>
														<td>
															<div class="btn-group">
																<a href="<?php echo site_url('update_enquiry_data/') . $entity_id; ?>"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i></span></a>
																<a href="<?php echo site_url('view_enquiry_data/' . $entity_id); ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
																<a href="<?php echo site_url('setoffer/') . $entity_id; ?>" class="btn btn-sm btn-block btn-warning">Make Offer</a>
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
</body>

</html>