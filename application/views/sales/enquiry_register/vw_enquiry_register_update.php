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
	<title>Update Lead</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
		<?php $this->load->view('header_sidebar'); ?>
		<?php
		$attachment_data = $enquiry_result->row_array();
		$attachment_img = $attachment_data['attachment'];
		$image_attachment_name = explode(',', $attachment_img);
		array_pop($image_attachment_name);

		date_default_timezone_set("Asia/Calcutta");
		$tracking_date = date('Y-m-d');
		?>
		<div class="content-wrapper">
			<!-- Content Wrapper. Contains page content -->
			<section class="content-header">
				<div class="container-fluid">
					<br>
					<!-- <div class="card" style="background-color: #20c997;"> -->
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">Update Lead</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_enquiry_data' ?>">Lead Register</a></li>
									<li class="breadcrumb-item">Update Lead Details Of Id :- <?php echo $entity_id; ?> </li>
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
									<h3 class="card-title">Lead Details Form</h3>
								</div>
								<div class="card-body">
									<form role="form" name="enquiry_form" enctype="multipart/form-data" action="<?php echo site_url('sales/enquiry_register/update_enquiry'); ?>" method="post">

										<input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id ?>" required>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label> Lead Number </label>
													<input type="text" name="enquiry_number" id="enquiry_number" class="form-control" size="50" placeholder="Enter Lead Number" readonly>
												</div>
											</div>

											<input type="hidden" id="customer_id" name="customer_id" required>

											<div class="col-sm-6">
												<div class="form-group">
													<label style="color: #FF0000;"> Customer Name *</label>
													<select class="form-control select2bs4" style="width: 100%;" id="customer_name" name="customer_name" required>
														<option value="">No Selected</option>
														<?php foreach ($customer_contact_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->contact_person . ' - ' . $row->email_id . ' - ' . $row->first_contact_no; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="card card-primary">
													<div class="card-header">
														<h3 class="card-title"> Customer Details</h3>
													</div>
													<div class="card-body">
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<label> Customer Contact Person </label>
																	<input type="text" name="enquiry_contact_person" id="enquiry_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" readonly>
																</div>
															</div>

															<div class="col-sm-6">
																<div class="form-group">
																	<label> Customer Email Id </label>
																	<input type="text" name="enquiry_email_id" id="enquiry_email_id" class="form-control" size="50" placeholder="Customer Email Id" readonly>
																</div>
															</div>
														</div>

														<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label> Customer Contact Number </label>
																	<input type="text" name="enquiry_contact_number" id="enquiry_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" readonly>
																</div>
															</div>

															<div class="col-sm-3">
																<div class="form-group">
																	<label> Customer State </label>
																	<input type="text" name="enquiry_customer_state" id="enquiry_customer_state" class="form-control" size="50" placeholder="Customer State" readonly>
																</div>
															</div>

															<div class="col-sm-3">
																<div class="form-group">
																	<label> Customer City </label>
																	<input type="text" name="enquiry_customer_city" id="enquiry_customer_city" class="form-control" size="50" placeholder="Customer City" readonly>
																</div>
															</div>

															<div class="col-sm-3">
																<div class="form-group">
																	<label> State Code </label>
																	<input type="text" name="enquiry_state_code" id="enquiry_state_code" class="form-control" size="50" placeholder="State Code" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label style="color: #FF0000;"> Lead Description *</label>
													<textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enter Lead Description" required></textarea>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label style="color: #FF0000;"> Select Sales Engineer *</label>
													<select class="form-control select2bs4" style="width: 100%;" id="employee_id" name="employee_id" required>
														<option value="">No Selected</option>
														<?php foreach ($employee_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->Emp_name; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label style="color: #FF0000;"> Lead Type *</label>
													<select class="form-control select2bs4" style="width: 100%;" id="enquiry_type" name="enquiry_type" required>
														<option value="">Select</option>
														<!-- <option value="1">Pull Cord (MH)</option>
                                                                <option value="2">Porximity (PS)</option>
                                                                <option value="3">Vibrator Control (VC)</option>
                                                                <option value="4">Treading (TD)</option>     -->
														<option value="5">Other (OT)</option>
														<!-- <option value="6">CUH & TD-MH</option>
                                                                <option value="7">TD-PS</option>
                                                                <option value="8">TD-VC</option> -->
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label style="color: #FF0000;"> Lead Source *</label>
													<select class="form-control select2bs4" style="width: 100%;" id="enquiry_source" name="enquiry_source" required>
														<option value="">Select</option>
													
														<option value="">No Selected</option>
														<?php foreach ($source_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->source_name; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label style="color: #FF0000;"> Lead Urgency <span>*</label>
													<select class="form-control select2bs4" style="width: 100%;" id="enquiry_urgency" name="enquiry_urgency" required>
														<option value="">Select</option>
														<option value="1">Cold Call </option>
														<option value="2">Live Enquiry / Budgatory</option>
														<option value="3">Hot Lead</option>
													</select>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="employee_attachment">Attachment</label>
													<div class="input-group">
														<div class="custom-file">
															<input type="file" class="custom-file-input" name="employee_attachment[]" multiple id="employee_attachment">
															<label class="custom-file-label" for="employee_attachment">Choose Attachment</label>
														</div>
													</div>
													<?php
													foreach ($image_attachment_name as $key => $value) {
													?>
														<p>
															<a target="_blank" href="<?php echo base_url(); ?>assets/enquiry_attachment/<?php echo $value; ?>"><?php echo $value; ?></a>
															<?php if (!empty($value)) { ?>
																<a href="<?php echo site_url('delete_enquiry_attach_image/' . $value . '-' . $entity_id); ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
														</p>
												<?php }
														} ?>
												</div>
											</div>

											<div class="col-sm-3">
												<!-- <div class="form-group">
                                                        <label>Job Card Status</label>
                                                        <select class="form-control" style="width: 100%;" id="status" name="status" required>
                                                            <option value="">No Selected</option>
                                                            <option value="1" onClick="hideRejection()">Open</option>
                                                            <option value="2" onClick="hideRejection()">Matrial Issued</option>
                                                            <option value="3" onClick="hideRejection()">Close</option>
                                                            <option value="6" onClick="showRejection()">Cancel</option>
                                                            <option value="7" onClick="hideRejection()">Estimated</option>
                                                        </select>
                                                        </div> -->
												<div class="form-group">
													<label>Enquiry Status</label>
													<div class="col-sm-3">
														<!-- radio -->
														<div class="form-group">
															<div class="custom-control custom-radio">
																<input class="custom-control-input" type="radio" id="customRadio6" name="enquiry_status" checked="checked" value="1" onclick="hideR()">
																<label for="customRadio6" class="custom-control-label">Qualify</label>
															</div>
														</div>
													</div>

													<div class="col-sm-4">
														<!-- radio -->
														<div class="form-group">
															<div class="custom-control custom-radio">
																<input class="custom-control-input" type="radio" id="customRadio7" name="enquiry_status" value="4" onclick="showR()">
																<label for="customRadio7" class="custom-control-label">Disqualify</label>
															</div>
														</div>
													</div>

													<div class="col-sm-12">
														<!-- radio -->
														<div class="form-group">
															<div class="custom-control custom-radio">
																<input class="custom-control-input" type="radio" id="customRadio8" name="enquiry_status" value="7" onclick="showR()">
																<label for="customRadio8" class="custom-control-label">Regretted</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12" id="Rejection_reason_form" style="display: none">
												<div class="form-group">
													<label style="color: #FF0000;">Reason *</label>
													<textarea class="form-control" id="enquiry_rejected_reason" name="enquiry_rejected_reason" rows="3" placeholder="Enter Cancellation Reason"></textarea>
												</div>
											</div>
										</div>

										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Lead Tracking Details Form</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-4">
														<div class="form-group">
															<label> Lead Tracking Date </label>
															<input type="date" name="enquiry_tracking_date" id="enquiry_tracking_date" value="<?php echo $tracking_date; ?>" class="form-control" size="50">
														</div>
													</div>

													<div class="col-sm-8">
														<div class="form-group">
															<label style="color: #FF0000;"> Lead Tracking Description * </label>
															<textarea class="form-control" id="enquiry_tracking_descrption" name="enquiry_tracking_descrption" rows="3" placeholder="Enter Lead Tracking Description"></textarea>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-sm-4">
														<div class="form-group">
															<label style="color: #FF0000;"> Next Action * </label>
															<textarea class="form-control" id="tracking_next_action" name="tracking_next_action" rows="3" placeholder="Enter Tracking Next Action"></textarea>
														</div>
													</div>

													<div class="col-sm-4">
														<div class="form-group">
															<label style="color: #FF0000;"> Action Due Date *</label>
															<input type="date" name="action_due_date" id="action_due_date" class="form-control" size="50">
														</div>
													</div>

													<div class="col-sm-4">
														<div class="form-group">
															<label> Add Reminder </label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															<input type="hidden"><i style="font-size: 50px;" class="fa fa-bell"></i>
														</div>
													</div>
												</div>

												<div class="card-body">
													<center>
														<button type="submit" class="btn btn-success toastrDefaultSuccess">
															Submit
														</button>
													</center>
												</div>
											</div>
										</div>
									</form>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example12" class="table table-bordered table-striped">
												<tr>
													<th>Lead Tracking Number</th>
													<th>Lead Tracking Date</th>
													<th>Lead Tracking Record</th>
												</tr>
											</table>
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
	<script type="text/javascript">
		$(document).ready(function() {
			bsCustomFileInput.init();
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			//call function get data edit
			get_data_edit();

			//load data for edit
			function get_data_edit() {
				var entity_id = $('[name="entity_id"]').val();

				$.ajax({
					url: "<?php echo site_url('sales/enquiry_register/get_enquiry_details_by_id'); ?>",
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
								$('[name="enquiry_number"]').val(data[i].enquiry_no);
							$('[name="customer_id"]').val(data[i].customer_id);
							$('[name="customer_name"]').val(data[i].contact_person_id).trigger('change');
							$('[name="employee_id"]').val(data[i].emp_id).trigger('change');
							$('[name="enquiry_descrption"]').val(data[i].enquiry_short_desc);
							$('[name="enquiry_type"]').val(data[i].enquiry_type).trigger('change');
							$('[name="enquiry_source"]').val(data[i].enquiry_source).trigger('change');
							$('[name="enquiry_urgency"]').val(data[i].enquiry_urgency).trigger('change');
							//$('[name="enquiry_status"]').val(data[i].enquiry_status).trigger('change');

							if (data[i].enquiry_status == 1)
								$('#enquiry_form').find(':radio[name=enquiry_status][value="1"]').prop('checked', true);
							if (data[i].enquiry_status == 4)
								$('#enquiry_form').find(':radio[name=enquiry_status][value="4"]').prop('checked', true);
							if (data[i].enquiry_status == 5)
								$('#enquiry_form').find(':radio[name=enquiry_status][value="5"]').prop('checked', true);

							$('[name="employee_attachment"]').val(data[i].attachment);
						});
					}
				});
			}
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			//call function get data edit
			get_first_save_data_of_enquiry_track();

			//load data for edit
			function get_first_save_data_of_enquiry_track() {
				var entity_id = $('[name="entity_id"]').val();
				//alert(entity_id);


				$.ajax({
					url: "<?php echo site_url('sales/enquiry_tracking_register/get_enquiry_tracking_data_by_enquiry_id'); ?>",
					method: "POST",
					data: {
						entity_id: entity_id
					},
					async: true,
					dataType: 'json',
					success: function(data) {
						console.log(data);
						var trHTML = '';
						$.each(data, function(i, item) {
							//bill_link = 'http://shreeautocare.com/erp/view_invoice/'+ item.Bill_id;
							trHTML += '<tr><td>' + item.tracking_number + '</td><td>' + item.tracking_date + '</td><td>' + item.tracking_record + '</td></tr>';
						});
						$('#example12').append(trHTML);
					}
				});
			}
		});
	</script>

	<!-- <script type="text/javascript">
            function showEnquiryStatus (){
               document.getElementById('Enquiry_reasonssss').style.display = "block";
            }

            function hideEnquiryStatus(){
                $('#Enquiry_reasonssss').hide();  
            }
        </script> -->

	<script type="text/javascript">
		//load data for edit
		$('#customer_name').change(function() {
			var id = $(this).val();
			$.ajax({
				url: "<?php echo site_url('sales/enquiry_register/get_all_customer_data'); ?>",
				method: "POST",
				data: {
					id: id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					$.each(data, function(i, item) {
						console.log(data);
						$val =
							$('[name="customer_id"]').val(data[i].Customer_id);
						$('[name="enquiry_contact_person"]').val(data[i].contact_person);
						$('[name="enquiry_email_id"]').val(data[i].email_id);
						$('[name="enquiry_contact_number"]').val(data[i].first_contact_no);
						$('[name="enquiry_customer_state"]').val(data[i].state_name);
						$('[name="enquiry_customer_city"]').val(data[i].city_name);
						$('[name="enquiry_state_code"]').val(data[i].state_code);
					})
				}
			});
			return false;
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

	<script type="text/javascript">
		function showR() {
			document.getElementById('Rejection_reason_form').style.display = "block";
		}

		function hideR() {
			$('#Rejection_reason_form').hide();
		}
	</script>

</body>

</html>
