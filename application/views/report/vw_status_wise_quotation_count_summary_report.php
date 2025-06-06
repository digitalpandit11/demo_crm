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
	<title>Stage Wise Quotation Count Summary Report</title>
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
							<h1 class="card-title">Stage Wise Quotation Count Summary Report</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_status_wise_quotation_count_summary_report' ?>">Create Status Wise Quotation Count Summary Report</a>
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
									<h3 class="card-title">Stage Wise Quotation Count Summary<strong>[ <?php //echo date("d-m-Y", strtotime($timesheet_from_date))." to ".date("d-m-Y", strtotime($timesheet_to_date)); 
																																								?> ]</strong></h3>
								</div>

								<div class="card-body">
									<?php
									$this->db->select('*');
									$this->db->from('status_master_relation');
									$this->db->where('status_for',1);
									$this->db->where('entity_id !=',9);
									$this->db->where('entity_id !=',1);
									$status_query = $this->db->get();
									//$status_query_num_rows = $status_query->num_rows();
									$status_list = $status_query->result();
									?>

									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Sr. No.</th>
													<th>Employee Name</th>
													<?php
													foreach ($status_list as $offer_status) {
													?>
														<th><?= $offer_status->status_name; ?></th>
													<?php } ?>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 0;
												$total_quote_num_rows = 0;
												foreach ($employee_list as $employee) {
													$no++;
													$employee_name = $employee->emp_first_name;
													$emp_id = $employee->entity_id;

													//get offer value
													$this->db->select('offer_register.offer_engg_name,offer_register.status as offer_status,count(distinct(offer_register.entity_id)) as offer_count');
													$this->db->from('offer_register');
													$where = '(offer_register.offer_engg_name = "' . $emp_id . '" and offer_register.status != 9 and offer_register.status != 1)';
													$this->db->where($where);
													$this->db->group_by(['offer_register.offer_engg_name', 'offer_register.status']);
													// $quote_query = $this->db->get_compiled_select();
													$quote_query = $this->db->get();
													$quote_num_rows = $quote_query->num_rows();
													$quote_result = $quote_query->result();

													// $total_quote_num_rows += $quote_num_rows;

												

													$this->db->select('*');
													$this->db->from('offer_register');
													$where = '(offer_register.offer_engg_name = '.$emp_id.' and offer_register.status != 9  and offer_register.status != 1)';
													$this->db->where($where);
													$this->db->group_by('offer_register.entity_id');
													$query = $this->db->get();
													$total_quote_num_rows = $query->num_rows();



													$quote_data = [];
													$total_offer_count = 0;
													foreach ($status_list as $os) {

														foreach ($quote_result as $row) {

															$offer_status =  $row->offer_status;
															$offer_count =  $row->offer_count;

															if ($offer_status == $os->status_value) {
																$quote_data[$os->status_value] =
																	[
																		'status' => $offer_status,
																		'offer_count' => $offer_count
																	];
															}
														}
													}


												?>
													<tr>
														<td><?php echo $no; ?></td>
														<td><a href="<?= base_url('vw_status_wise_customer_wise_quotation_count_summary_report/').$emp_id;?>" ><?php echo $employee_name; ?></a></td>
														<?php foreach ($status_list as $st) {
															$offer_status = $st->status_value ?>
															<td style="text-align: center;" >
																<?php
																$quote_check = isset($quote_data[$st->status_value]['status']);
															
																//get quote Count
																if($quote_check) {
																if($quote_data[$st->status_value]['status'] == $offer_status){
																	$quote_count =  $quote_data[$st->status_value]['offer_count'];
																}else{
																	$quote_count =0;
																}
																}else{																	
																$quote_count = 0;
																}
																

																echo "<span class='text-danger'> ".$quote_count. " </span>";
																// echo($total_quote_num_rows)?round($quote_count*100/$total_quote_num_rows,1): 0;
																// echo " %"; 
																?>

															</td>
														<?php } ?>
													</tr>
												<?php  } ?>
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
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

	<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#example1').DataTable({
				dom: 'Bfrtip',
				buttons: [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5'
				]
			})
		});
	</script>
</body>

</html>
