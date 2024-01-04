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
	<title>All Ticket</title>
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
	<link rel="icon" href="<?php echo base_url() . 'assets/company_logo/construction.jpg' ?>" type="image/ico" />
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<?php $this->load->view('header_sidebar');
		date_default_timezone_set("Asia/Calcutta");

		$this->db->select('ticket_master.*,
                    customer_master.customer_name,
                    customer_contact_master.contact_person,
										customer_contact_master.email_id,
                    customer_contact_master.first_contact_no');
		$this->db->from('ticket_master');
		$where = '(ticket_master.ticket_type = "' . '1' . '")';
		$this->db->where($where);
		$this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
		$this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
		$this->db->order_by('ticket_master.entity_id', 'DESC');
		$this->db->group_by('ticket_master.entity_id');
		$warrantee_claims_query = $this->db->get();
		$warrantee_claims_query_result = $warrantee_claims_query->result();

		$this->db->select('ticket_master.*,
                    customer_master.customer_name,
                    customer_contact_master.contact_person,
										customer_contact_master.email_id,
                    customer_contact_master.first_contact_no');
		$this->db->from('ticket_master');
		$where = '(ticket_master.ticket_type = "' . '2' . '")';
		$this->db->where($where);
		$this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
		$this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
		$this->db->order_by('ticket_master.entity_id', 'DESC');
		$this->db->group_by('ticket_master.entity_id');
		$paid_service_query = $this->db->get();
		$paid_service_query_result = $paid_service_query->result();

		$this->db->select('ticket_master.*,
                    customer_master.customer_name,
                    customer_contact_master.contact_person,
										customer_contact_master.email_id,
                    customer_contact_master.first_contact_no');
		$this->db->from('ticket_master');
		$where = '(ticket_master.ticket_type = "' . '3' . '")';
		$this->db->where($where);
		$this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
		$this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
		$this->db->order_by('ticket_master.entity_id', 'DESC');
		$this->db->group_by('ticket_master.entity_id');
		$technical_support_query = $this->db->get();
		$technical_support_query_result = $technical_support_query->result();

		$this->db->select('ticket_master.*,
                    customer_master.customer_name,
                    customer_contact_master.contact_person,
										customer_contact_master.email_id,
                    customer_contact_master.first_contact_no');
		$this->db->from('ticket_master');
		$where = '(ticket_master.ticket_type = "' . '4' . '")';
		$this->db->where($where);
		$this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
		$this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
		$this->db->order_by('ticket_master.entity_id', 'DESC');
		$this->db->group_by('ticket_master.entity_id');
		$inhouse_query = $this->db->get();
		$inhouse_query_result = $inhouse_query->result();
		?>
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<br>
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">All Ticket Record</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_all_ticket_data' ?>">All Ticket Record</a></li>
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
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Ticket Details</h3>
								</div>

								<div class="card-body">
									<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Warrantee Claims</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Paid Service</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-content-below-profile1-tab" data-toggle="pill" href="#custom-content-below-profile1" role="tab" aria-controls="custom-content-below-profile1" aria-selected="false">Technical Support</a>
										</li>
										<!-- <li class="nav-item">
                                                    <a class="nav-link" id="custom-content-below-profile2-tab" data-toggle="pill" href="#custom-content-below-profile2" role="tab" aria-controls="custom-content-below-profile2" aria-selected="false">Inhouse Ticket</a>
                                                </li> -->
									</ul>
									<div class="tab-content" id="custom-content-below-tabContent">
										<div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
											<div class="card-body">
												<div class="table-responsive">
													<table id="example1" class="table table-bordered table-striped">
														<thead>
															<th>Sr. No.</th>
															<th>Ticket Number</th>
															<th>Customer Name</th>
															<th>Contact Person</th>
															<th>Contact Person Email</th>
															<th>Contact No.</th>
															<th>Product Make</th>
															<th>Product Name</th>
															<th>Ticket Description</th>
															<th>Ticket Date</th>
															<th>Status</th>
															<th>Close Date</th>
															<th>Action</th>
														</thead>
														<tbody>
															<?php
															$no = 0;
															foreach ($warrantee_claims_query_result as $row) :
																$no++;
																$entity_id = $row->entity_id;
																$ticket_status = $row->status;
																if ($ticket_status == 1) {
																	$tk_status = "Pending";
																} elseif ($ticket_status == 2) {
																	$tk_status = "Working On it";
																} elseif ($ticket_status == 3) {
																	$tk_status = "Closed";
																} elseif ($ticket_status == 4) {
																	$tk_status = "Cancelled";
																}
															?>
																<tr>
																	<td><?php echo $no; ?></td>
																	<td><?php echo $row->ticket_number; ?></td>
																	<td><b><?php echo $row->customer_name; ?></b></td>
																	<td><?php echo $row->contact_person; ?></td>
																	<td><?php echo $row->email_id; ?></td>
																	<td><?php echo $row->first_contact_no; ?></td>
																	<td><?php echo $row->product_make; ?></td>
																	<td><?php echo $row->product_name; ?></td>
																	<td><?php echo $row->ticket_record; ?></td>
																	<td><?php echo date("d-m-Y", strtotime($row->ticket_date)); ?></td>
																	<td><?php echo $tk_status; ?>
																	</td>
																	<td><?php echo $row->close_date; ?></td>
																	<td>
																		<div class="btn-group">
																			<a href="<?php echo site_url('view_ticket/' . $entity_id); ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
																			<a href="<?php echo site_url('update_all_ticket_data/' . $entity_id); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
																		</div>
																	</td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
											<div class="card-body">
												<div class="table-responsive">
													<table id="example2" class="table table-bordered table-striped">
														<thead>
															<th>Sr. No.</th>
															<th>Ticket Number</th>
															<th>Customer Name</th>
															<th>Contact Person</th>
															<th>Contact Person Email</th>
															<th>Contact No.</th>
															<th>Product Make</th>
															<th>Product Name</th>
															<th>Ticket Description</th>
															<th>Ticket Date</th>
															<th>Status</th>
															<th>Close Date</th>
															<th>Action</th>
														</thead>
														<tbody>
															<?php
															$no = 0;
															foreach ($paid_service_query_result as $row) :
																$no++;
																$entity_id = $row->entity_id;
																$ticket_status = $row->status;
																if ($ticket_status == 1) {
																	$tk_status = "Pending";
																} elseif ($ticket_status == 2) {
																	$tk_status = "Working On it";
																} elseif ($ticket_status == 3) {
																	$tk_status = "Closed";
																} elseif ($ticket_status == 4) {
																	$tk_status = "Cancelled";
																}
															?>
																<tr>
																	<td><?php echo $no; ?></td>
																	<td><?php echo $row->ticket_number; ?></td>
																	<td><b><?php echo $row->customer_name; ?></b></td>
																	<td><?php echo $row->contact_person; ?></td>
																	<td><?php echo $row->email_id; ?></td>
																	<td><?php echo $row->first_contact_no; ?></td>
																	<td><?php echo $row->product_make; ?></td>
																	<td><?php echo $row->product_name; ?></td>
																	<td><?php echo $row->ticket_record; ?></td>
																	<td><?php echo date("d-m-Y", strtotime($row->ticket_date)); ?></td>
																	<td><?php echo $tk_status; ?></td>
																	<td><?php echo $row->close_date; ?></td>
																	<td>
																		<div class="btn-group">
																			<a href="<?php echo site_url('view_ticket/' . $entity_id); ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
																			<a href="<?php echo site_url('update_all_ticket_data/' . $entity_id); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
																		</div>
																	</td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane fade" id="custom-content-below-profile1" role="tabpanel" aria-labelledby="custom-content-below-profile1-tab">
											<div class="card-body">
												<div class="table-responsive">
													<table id="example3" class="table table-bordered table-striped">
														<thead>
															<th>Sr. No.</th>
															<th>Ticket Number</th>
															<th>Customer Name</th>
															<th>Contact Person</th>
															<th>Contact Person Email</th>
															<th>Contact No.</th>
															<th>Product Make</th>
															<th>Product Name</th>
															<th>Ticket Description</th>
															<th>Ticket Date</th>
															<th>Status</th>
															<th>Close Date</th>
															<th>Action</th>
														</thead>
														<tbody>
															<?php
															$no = 0;
															foreach ($technical_support_query_result as $row) :
																$no++;
																$entity_id = $row->entity_id;
																$ticket_status = $row->status;
																if ($ticket_status == 1) {
																	$tk_status = "Pending";
																} elseif ($ticket_status == 2) {
																	$tk_status = "Working On it";
																} elseif ($ticket_status == 3) {
																	$tk_status = "Closed";
																} elseif ($ticket_status == 4) {
																	$tk_status = "Cancelled";
																}
															?>
																<tr>
																	<td><?php echo $no; ?></td>
																	<td><?php echo $row->ticket_number; ?></td>
																	<td><b><?php echo $row->customer_name; ?></b></td>
																	<td><?php echo $row->contact_person; ?></td>
																	<td><?php echo $row->email_id; ?></td>
																	<td><?php echo $row->first_contact_no; ?></td>
																	<td><?php echo $row->product_make; ?></td>
																	<td><?php echo $row->product_name; ?></td>
																	<td><?php echo $row->ticket_record; ?></td>
																	<td><?php echo date("d-m-Y", strtotime($row->ticket_date)); ?></td>
																	<td><?php echo $tk_status; ?></td>
																	<td><?php echo $row->close_date; ?></td>
																	<td>
																		<div class="btn-group">
																			<a href="<?php echo site_url('view_ticket/' . $entity_id); ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
																			<a href="<?php echo site_url('update_all_ticket_data/' . $entity_id); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
																		</div>
																	</td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane fade" id="custom-content-below-profile2" role="tabpanel" aria-labelledby="custom-content-below-profile2-tab">
											<div class="card-body">
												<div class="table-responsive">
													<table id="example4" class="table table-bordered table-striped">
														<thead>
															<th>Sr. No.</th>
															<th>Ticket Number</th>
															<th>Customer Name</th>
															<th>Contact Person</th>
															<th>Contact Person Email</th>
															<th>Contact No.</th>
															<th>Ticket Description</th>
															<th>Ticket Date</th>
															<th>Status</th>
															<th>Action</th>
														</thead>
														<tbody>
															<?php
															$no = 0;
															foreach ($inhouse_query_result as $row) :
																$no++;
																$entity_id = $row->entity_id;
																$ticket_status = $row->status;
																if ($ticket_status == 1) {
																	$tk_status = "Pending";
																} elseif ($ticket_status == 2) {
																	$tk_status = "Working On it";
																} elseif ($ticket_status == 3) {
																	$tk_status = "Closed";
																} elseif ($ticket_status == 4) {
																	$tk_status = "Cancelled";
																}
															?>
																<tr>
																	<td><?php echo $no; ?></td>
																	<td><?php echo $row->ticket_number; ?></td>
																	<td><b><?php echo $row->customer_name; ?></b></td>
																	<td><?php echo $row->contact_person; ?></td>
																	<td><?php echo $row->email_id; ?></td>
																	<td><?php echo $row->first_contact_no; ?></td>
																	<td><?php echo $row->ticket_record; ?></td>
																	<td><?php echo date("d-m-Y", strtotime($row->ticket_date)); ?></td>
																	<td><?php echo $tk_status; ?></td>
																	<td>
																		<div class="btn-group">
																			<a href="<?php echo site_url('view_ticket/' . $entity_id); ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
																		</div>
																	</td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
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
	<!-- bs-custom-file-input -->
	<script src="<?php echo base_url() . 'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js' ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url() . 'assets/dist/js/adminlte.min.js' ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url() . 'assets/dist/js/demo.js' ?>"></script>
	<!-- Page script -->
	<!-- DataTables -->
	<script src="<?php echo base_url() . 'assets/plugins/datatables/jquery.dataTables.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js' ?>"></script>
	<script>
		$(document).ready(function() {
			$('#example1').DataTable();
		});

		$(document).ready(function() {
			$('#example2').DataTable();
		});

		$(document).ready(function() {
			$('#example3').DataTable();
		});

		$(document).ready(function() {
			$('#example4').DataTable();
		});
	</script>
</body>

</html>