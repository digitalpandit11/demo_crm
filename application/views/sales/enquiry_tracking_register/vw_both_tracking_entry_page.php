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
	<title>Create Tracking Record</title>
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
		<?php $this->load->view('header_sidebar');
		date_default_timezone_set("Asia/Calcutta");
		?>
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<br>
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">Create Tracking</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_tracking_data_entry' ?>">Quote_follow up</a></li>
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
									<h3 class="card-title">Tracking Details Form</h3>
								</div>

								<div class="card-body">
									<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Offer Wise Tracking</a>
										</li>
									</ul>
									<div class="tab-content" id="custom-content-below-tabContent">
										<div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
											<div class="card-body">
												<div class="table-responsive">
													<table id="example1" class="table table-bordered table-striped">
														<thead>
															<tr>
																<th>Action</th>
																<!-- <th>Operation</th> -->
																<th>Sr. No.</th>
																<!-- <th>Task Entry Date </th> -->
																<th>Company Name</th>
																<th>Contact Person</th>
																<th>Contact No.</th>
																<th>Call Discussion</th>
																<!-- <th>Next Action</th> -->
																<th>Action Due Date</th>
																<th>Offer No. </th>
																<th>Offer Date</th>
																<th>Offer Description</th>
																<!-- <th>Enquiry No. </th> -->
																<th>Offer Value</th>
																<th>Offer Engg</th>
																<th>Offer Stage</th>
																<th>Action</th>
																<!-- <th>Operation</th> -->
															</tr>
														</thead>
														<tbody>
															<?php

															$no = 0;

															foreach ($enquiry_tracking_details as $row) :
																$no++;
																$entity_id = $row->offer_id;

																$track_detail = $row->combined_tracking_record;

																$Status_data = $row->offer_status;

																if ($Status_data == '1') {
																	$Status = "Pending Offer Creation";
																} else if ($Status_data == '2') {
																	$Status = "Offer Created";
																} else if ($Status_data == '3') {
																	$Status = "Order Created";
																} else if ($Status_data == '4') {
																	$Status = "Offer Lost";
																} else if ($Status_data == '5') {
																	$Status = "Offer Regrated";
																} else if ($Status_data == '6') {
																	$Status = "Win";
																} else if ($Status_data == '7') {
																	$Status = "InActive";
																} else if ($Status_data == '8') {
																	$Status = "A";
																} else if ($Status_data == '9') {
																	$Status = "B";
																} else if ($Status_data == '10') {
																	$Status = "Offer Revised";
																} else {
																	$Status = "NA";
																}

																$this->db->select_sum('total_amount_with_gst');
																$this->db->from('offer_product_relation');
																$where = '(offer_product_relation.offer_id = "' . $entity_id . '")';
																$this->db->where($where);
																$product_amount = $this->db->get();
																$product_amount_result =  $product_amount->row_array();

																if (!empty($product_amount_result)) {
																	$product_amount_without_gst_format = $product_amount_result['total_amount_with_gst'];
																	$Product_amt = number_format((float)$product_amount_without_gst_format, 2, '.', '');
																} else {
																	$Product_amt = 0;
																}


																$Service_amt = 0;


																$Offer_order_val = $Product_amt + $Service_amt;
																$Offer_order_amount = number_format((float)$Offer_order_val, 2, '.', '');

																$Enquiry_id = $row->enquiry_id;
																if (empty($Enquiry_id)) {
																	$Enquiry_number = "NA";
																} else {
																	$this->db->select('*');
																	$this->db->from('enquiry_register');
																	$where = '(enquiry_register.entity_id = "' . $Enquiry_id . '")';
																	$this->db->where($where);
																	$query = $this->db->get();
																	$query_result = $query->row_array();

																	$Enquiry_number = $query_result['enquiry_no'];
																}
																// new addition to get track details

															?>

																<tr>
																	<td>
																		<div class="btn-group">
																			<a onclick="return confirm('Are You Sure To Track Offer?')" href="<?php echo site_url('set_track_offer/' . $entity_id); ?>" class="btn btn-block btn-danger"><i class="fas fa-paper-plane"></i>Track</a>
																		</div>
																	</td>

																	<td><?php echo $no; ?></td>
																	<!-- <td><?php echo $row->tracking_date; ?></td> -->
																	<td><b><?php echo $row->customer_name; ?></b></td>
																	<td><?php echo $row->contact_person; ?></td>
																	<td><?php echo $row->first_contact_no; ?></td>
																	<td><?php echo $track_detail . "<br>" . $row->next_action; ?></td>
																	<!-- <td><?php echo $row->combined_next_action; ?></td> -->
																	<td><?php echo $row->action_due_date; ?></td>
																	<!-- <td><?php echo $Enquiry_number; ?></td> -->
																	<!-- <td><?php echo $row->email_id; ?></td> -->
																	<td><?php echo $row->offer_no; ?></td>
																	<td><?php echo date("Y-m-d", strtotime($row->offer_date)); ?></td>
																	<td><?php echo $row->offer_description; ?></td>
																	<!-- <td><?php echo $row->reason_for_rejection; ?></td> -->
																	<td><?php echo $Offer_order_amount; ?></td>
																	<td><?php echo $row->emp_first_name; ?></td>
																	<td><?php echo $Status; ?></td>
																	<td>
																		<div class="btn-group">
																			<a onclick="return confirm('Are You Sure To Track Offer?')" href="<?php echo site_url('set_track_offer/' . $row->offer_id); ?>" class="btn btn-block btn-danger"><i class="fas fa-paper-plane"></i>Track</a>
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
	</script>

	<script>
		$(function() {
			//Initialize Select2 Elements
			$('.select2').select2()

			//Initialize Select2 Elements
			$('.select2bs4').select2({
				theme: 'bootstrap4'
			})

			//Datemask dd/mm/yyyy
			$('#datemask').inputmask('dd/mm/yyyy', {
				'placeholder': 'dd/mm/yyyy'
			})
			//Datemask2 mm/dd/yyyy
			$('#datemask2').inputmask('mm/dd/yyyy', {
				'placeholder': 'mm/dd/yyyy'
			})
			//Money Euro
			$('[data-mask]').inputmask()

			//Date range picker
			$('#reservation').daterangepicker()
			//Date range picker with time picker
			$('#reservationtime').daterangepicker({
				timePicker: true,
				timePickerIncrement: 30,
				locale: {
					format: 'MM/DD/YYYY hh:mm A'
				}
			})
			//Date range as a button
			$('#daterange-btn').daterangepicker({
					ranges: {
						'Today': [moment(), moment()],
						'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'Last 7 Days': [moment().subtract(6, 'days'), moment()],
						'Last 30 Days': [moment().subtract(29, 'days'), moment()],
						'This Month': [moment().startOf('month'), moment().endOf('month')],
						'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
					},
					startDate: moment().subtract(29, 'days'),
					endDate: moment()
				},
				function(start, end) {
					$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
				}
			)

			//Timepicker
			$('#timepicker').datetimepicker({
				format: 'LT'
			})

			//Bootstrap Duallistbox
			$('.duallistbox').bootstrapDualListbox()

			//Colorpicker
			$('.my-colorpicker1').colorpicker()
			//color picker with addon
			$('.my-colorpicker2').colorpicker()

			$('.my-colorpicker2').on('colorpickerChange', function(event) {
				$('.my-colorpicker2 .fa-square').css('color', event.color.toString());
			});

			$("input[data-bootstrap-switch]").each(function() {
				$(this).bootstrapSwitch('state', $(this).prop('checked'));
			});

		})
	</script>
</body>

</html>
