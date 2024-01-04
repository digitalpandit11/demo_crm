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
	<title>Stage Wise Quotation Summary Report</title>
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
							<h1 class="card-title">Stage Wise Quotation Summary Report</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'create_stage_wise_quotation_summary' ?>">Create Stage Wise Quotation Summary Report</a>
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
									<h3 class="card-title">Stage Wise Quotation Summary<strong>[ <?php echo date("d-m-Y", strtotime($timesheet_from_date))." to ".date("d-m-Y", strtotime($timesheet_to_date)); ?> ]</strong></h3>
								</div>

								<div class="card-body">
							
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Sr. No.</th>
													<th>Employee Name</th>
													<th>Quotation Stage </th>
													<th>Quotation Count </th>
													<th>Quotation Value</th>
													<!-- <th>Action</th> -->
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 0;
												$emp_id = $_SESSION['emp_id'];
												$role_id = $_SESSION['role_id'];

												if($role_id ==1)
												{
											
												$this->db->select('*');
												$this->db->from('employee_master');
												//$this->db->join('','','');
												//$where = '(entity_id = '.1.')';
												//$this->db->where($where);
												$employee_query = $this->db->get();
												//$employee_query_num_rows = $employee_query->num_rows();
												$employee_data = $employee_query->result();
												}else{
													$this->db->select('*');
													$this->db->from('employee_master');
													//$this->db->join('','','');
													$where = '(entity_id = "'.$emp_id.'")';
													$this->db->where($where);
													$employee_query = $this->db->get();
													//$employee_query_num_rows = $employee_query->num_rows();
													$employee_data = $employee_query->result();
												}

												foreach($employee_data as $employee)
												{
													$no++;
													$employee_name = $employee->emp_first_name;
													$emp_id = $employee->entity_id;

														//get offer value
														$this->db->select('sum(offer_product_relation.total_amount_without_gst) as offer_value,count(*) as offer_count,offer_register.status as offer_status');
														$this->db->from('offer_register');
														$this->db->join('enquiry_register','enquiry_register.entity_id = offer_register.enquiry_id','left');
														$this->db->join('offer_product_relation','offer_product_relation.offer_id = offer_register.enquiry_id','inner');
														$this->db->join('customer_master','customer_master.entity_id = offer_register.customer_id','left');
														$this->db->join('customer_contact_master','customer_contact_master.entity_id = offer_register.contact_person_id','inner');
														$this->db->join('employee_master','employee_master.entity_id = offer_register.offer_engg_name','inner');
														$this->db->join('enquiry_source_master','enquiry_source_master.entity_id = offer_register.offer_source','inner');
														$this->db->join('state_master','state_master.entity_id = customer_master.state_id','inner');
														$where = '(offer_register.offer_engg_name = "'.$emp_id.'" )';
														$this->db->where($where);
														$where1 = '(offer_register.offer_date >= "'.$timesheet_from_date.'" and offer_register.offer_date <= "'.$timesheet_to_date.'" )';
														$this->db->where($where1);
														$this->db->group_by('offer_register.status', 'DESC');
														$this->db->order_by('offer_register.entity_id', 'DESC');
														$query = $this->db->get();
														$query_result = $query->result();

											foreach ($query_result as $key => $row) 
											{
										
													$Status_data = $row->offer_status;
													//   $offer_value = number_format($row->total_amount_with_gst);

													if ($Status_data == 1) {
														$Status = "Unsaved";
													} elseif ($Status_data == 2) {
														$Status = "Offer Created";
													} elseif ($Status_data == 3) {
														$Status = "Active";
													} elseif ($Status_data == 4) {
														$Status = "Offer Lost";
													} elseif ($Status_data == 5) {
														$Status = "Offer Regrated";
													} elseif ($Status_data == 6) {
														$Status = "Win";
													} elseif ($Status_data == 7) {
														$Status = "InActive";
													} elseif ($Status_data == 8) {
														$Status = "A";
													} elseif ($Status_data == 9) {
														$Status = "B";
													} elseif ($Status_data == 10) {
														$Status = "Offer Revised";
													} else {
														$Status = "NA";
													}

												

												?>
													<tr>
														<td><?php echo $no; ?></td>
														<td><?php echo $employee_name; ?></td>
														<td><?php echo $Status; ?></td>
														<td><?php echo $row->offer_count; ?></td>
														<td><?php echo number_format($row->offer_value, 0, ".", ","); ?></td>
														<!-- <td><a href="<?php echo base_url() . "update_offer_data/" . $row->entity_id ?>"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i></span></a> 
														
														<a href="<?php echo base_url() . "view_offer_data/" . $row->entity_id ?>"><span class="btn btn-sm btn-success"><i class="fas fa-eye"></i></span></a> 
														
														<a href="<?php echo base_url() . "download_offer/" . $row->entity_id ?>" target="_blank"><span class="btn btn-sm btn-secondary"><i class="fas fa-print"></i></span></a>
														</td> -->
													</tr>
												<?php } } ?>
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