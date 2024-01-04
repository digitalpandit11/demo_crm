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
	<title>Lost Order Report</title>
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
							<h1 class="card-title">Lost Order Report</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'create_order_lost_report' ?>">Create Lost Order Report</a>
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
									<h3 class="card-title">Lost Order Report<strong>[ <?php echo date("d-m-Y", strtotime($timesheet_from_date))." to ".date("d-m-Y", strtotime($timesheet_to_date)); ?> ]</strong></h3>
								</div>

								<div class="card-body">
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Sr. No.</th>
													<th>Quotation No. </th>
													<th>Quotation Date </th>
													<th>Lead No. </th>
													<th>Company Name</th>
													<th>Contact Person</th>
													<th>Contact No.</th>
													<th>Email Id.</th>
													<th>Employee Name</th>
													<th>Quote Stage</th>
													<th>Source</th>
													<th>Lost Reason</th>
													<th>Quote Value</th>
													<!-- <th>Action</th> -->
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 0;

												foreach ($offer_list as $row) {

													$no++;

													$offer_id = $row->offer_id;
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

													//get offer value
													$this->db->select('sum(offer_product_relation.total_amount_without_gst) as offer_value');
													$this->db->from('offer_product_relation');
													//$this->db->join('','','');
													$where = '(offer_id = "' . $offer_id . '")';
													$this->db->where($where);
													$query = $this->db->get();
													//$query_num_rows = $query->num_rows();
													$offer_value_details = $query->row();
													$offer_value = $offer_value_details->offer_value;

												?>
													<tr>
														<td><?php echo $no; ?></td>
														<td><?php echo $row->offer_no; ?></td>
														<td><?php echo $row->offer_date; ?></td>
														<td><?php echo $row->enquiry_no; ?></td>
														<td><?php echo $row->customer_name; ?></td>
														<td><?php echo $row->contact_person; ?></td>
														<td><?php echo $row->first_contact_no; ?></td>
														<td><?php echo $row->email_id; ?></td>
														<td><?php echo $row->emp_first_name; ?></td>
														<td><?php echo $Status; ?></td>
														<td><?php echo $row->source_name; ?></td>
														<td><?php echo $row->reason_for_rejection; ?></td>
														<td><?php echo number_format($offer_value, 0, ".", ","); ?></td>
														<!-- <td><a href="<?php echo base_url() . "update_offer_data/" . $row->entity_id ?>"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i></span></a> 
                                                      
                                                      <a href="<?php echo base_url() . "view_offer_data/" . $row->entity_id ?>"><span class="btn btn-sm btn-success"><i class="fas fa-eye"></i></span></a> 
                                                      
                                                      <a href="<?php echo base_url() . "download_offer/" . $row->entity_id ?>" target="_blank"><span class="btn btn-sm btn-secondary"><i class="fas fa-print"></i></span></a>
                                                      </td> -->
													</tr>
												<?php } ?>
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