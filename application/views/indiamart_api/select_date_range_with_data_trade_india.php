<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$_SESSION['user_name']) {
	header("location:dashboard");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Select Trade India API</title>
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
		<?php
		$this->load->view('header_sidebar');

		$state_list = $this->db->select('*')->from('state_master')->get()->result();
		?>
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
		<div class="content-wrapper">
			<!-- Content Wrapper. Contains page content -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">Generate Trade India Lead</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item">Select Lead</li>
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
									<h3 class="card-title">Trade India Lead Lists </h3>
								</div>
								<div class="card-body" style="border-radius: 1.25rem;">
									<form role="form" name="sales_register_report" action="<?php echo site_url('indiamart_api/search_leads'); ?>" method="post">

										<!-- <div class="card-body">
											<a class="btn btn-md btn-success f-right text-white" data-toggle="modal" data-target="#modal-lg-bill-to"> + Add Customer</a>
									</div> -->

										<div class="card-body">
											<div class="table-responsive">
												<table id="example1" class="table table-bordered table-striped">
													<thead>
														<tr>
															<th style="display: none;">Entity Id</th>
															<!-- <th></th> -->
															<th></th>
															<th>Sr. No.</th>
															<th>Lead Date</th>
															<th>Lead Type</th>
															<th>Lead All Details</th>
															<th>Email id</th>
															<th>Sender Name</th>
															<th>Subject</th>
															<th>Mobile Number</th>
															<th>State</th>
															<th>City</th>
															<th>Lead Status</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$no = 0;

														foreach ($enquiry_details as $row) :
															$no++;
															$entity_id = $row->entity_id;

															// $customer_id = $row->customer_id;

															?>
															<tr>
																<td style="display: none;" class="relation_id" id="relation_id"><?php echo $entity_id; ?></td>

																<!-- <td><input type="checkbox" class="checkboxes" id="trade_india_id" name="trade_india_id" value="<?php echo $entity_id; ?>"></td> -->
																<td>
																	<a onclick="return confirm('Are You Sure To Create Lead?')" href="<?php echo site_url('create_trade_india_lead/' . $entity_id); ?>" class="btn btn-sm btn-info"><i class="fas fa-check"></i></a>
																</td>

																<td><?php echo $no; ?></td>
																<!-- <td class="customer_id" id="customer_id">
																	<select class="form-control select2bs4" style="width: 150px;"  id="customer_id" name="customer_id" onchange="change_customer(this);">
																			<option value="">Not Selected</option>
																			<?php foreach ($customer_details as $customer_data) : ?>
																			<option value="<?php echo $customer_data->entity_id; ?>"<?php if ($customer_data->entity_id == $customer_id) echo ' selected="selected"'; ?>><?php echo $customer_data->customer_name; ?></option>
																			<?php endforeach; ?>
																	</select>
															</td> -->
																<td><?php echo $row->formated_lead_date; ?></td>
																<td><?php echo $row->inquiry_type; ?></td>
																<td>
																	<textarea class="form-control" id="details_of_lead" name="details_of_lead" disabled style="width: 500px;" rows="5"><?php echo $row->message; ?></textarea>
																</td>
																<td><?php echo $row->sender_email; ?></td>
																<td><?php echo $row->sender_name; ?></td>
																<td><?php echo $row->subject; ?></td>
																<td><?php echo $row->sender_mobile; ?></td>
																<td><?php echo $row->sender_state; ?></td>
																<td><?php echo $row->sender_city; ?></td>
																<td class="indiamart_status" id="indiamart_status">
																	<!-- <select class="form-control select2bs4" style="width: 150px;"  id="indiamart_status" name="indiamart_status" onchange="change_status(this);">
																			<option value="">Not Selected</option>
																			<option value="1" <?= $row->status == '1' ? ' selected="selected"' : ''; ?> >Just Created</option>
																			<option value="3"  <?= $row->status == '3' ? ' selected="selected"' : ''; ?> >Lead disqualify</option>
																	</select> -->
																	<a class="btn btn-sm btn-danger disqualify_btn"  data-toggle="modal" data-target="#modal-disqualify" data-trade_india="<?php echo $entity_id; ?>"><i class="fas fa-thumbs-down"></i> </a>
																</td>
															</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
										<!-- <button style="margin-left: 500px;" type="button" class="btn btn-primary" id="select_lead">Save</button> -->
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

	<div class="modal fade" id="modal-lg-bill-to">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Write Customer Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form role="form" name="customer_address" id="customer_address" method="post">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label style="color: #FF0000;"> Customer Name *</label>
									<input type="text" name="pop_up_customer_name" id="pop_up_customer_name" class="form-control" size="50" placeholder="Enter Customer Name" required>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label style="color: #FF0000;"> Customer Type *</label>
									<select class="form-control select2bs4" style="width: 100%;" id="customer_type" name="customer_type" required>
										<option value="">No Selected</option>
										<option value="1">Dealer</option>
										<option value="2">End User</option>
										<option value="3">OEM</option>
										<option value="4">Trader</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<!-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">Address Type *</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="address_type" name="address_type" required>
                                            <option value="3">Both(Bill To & Ship To)</option>
                                        </select>
                                    </div>
                                </div> -->

							<div class="col-sm-12">
								<div class="form-group">
									<label style="color: #FF0000;"> Address *</label>
									<textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address" required></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;">State Name *</label>
									<select class="form-control select2bs4" style="width: 100%;" id="state_id" name="state_id" required>
										<option value="">Select State</option>
										<?php foreach ($state_list as $row) : ?>
											<option value="<?php echo $row->entity_id; ?>"><?php echo $row->state_name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;">City Name *</label>
									<select class="form-control select2bs4" style="width: 100%;" id="city_id" name="city_id" required>
										<option value="">Select City</option>
									</select>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;">State Code *</label>
									<input type="text" name="state_code" id="state_code" class="form-control" size="50" placeholder="State Code" required readonly>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label> Pin Code <span style="color: #FF0000;"></span> </label>
									<input type="number" name="customer_pin_code" id="customer_pin_code" class="form-control" size="50" placeholder="Enter Customer Pin Code">
								</div>
							</div>

							<!-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label> State Code <span style="color: #FF0000;">* Mandatory</span> </label>
                                        <input type="number" name="customer_state_code" id="customer_state_code" class="form-control" size="50" placeholder="Enter Customer State Code" required>
                                    </div>
                                </div> -->

							<div class="col-sm-4">
								<div class="form-group">
									<label> GST Number </label>
									<input type="text" name="customer_gst_number" id="customer_gst_number" class="form-control" size="50" placeholder="Enter GST Number" required>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label> Pan Number </label>
									<input type="text" name="customer_pan_number" id="customer_pan_number" class="form-control" size="50" placeholder="Enter Pan Number" required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;"> Designation *</label>
									<input type="text" name="contact_person_designation" id="contact_person_designation" class="form-control" size="50" placeholder="Enter Contact Person Designation" required>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;"> Contact Person *</label>
									<input type="text" name="contact_person" id="contact_person" class="form-control" size="50" placeholder="Enter Contact Person" required>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;"> Email Id *</label>
									<input type="email" name="contact_person_email_id" id="contact_person_email_id" class="form-control" size="50" placeholder="Enter Customer Email Id" required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;"> Contact Number *</label>
									<input type="number" name="first_contact_no" id="first_contact_no" class="form-control" size="50" placeholder="Enter Contact Number" required>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label> Alternate Contact Number </label>
									<input type="number" name="second_contact_no" id="second_contact_no" class="form-control" size="50" placeholder="Enter Alternate Contact Number">
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label> What's up Number </label>
									<input type="number" name="whatsup_no" id="whatsup_no" class="form-control" size="50" placeholder="Enter What's up Number">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

					<button type="submit" name="add_address" id="add_address" class="btn btn-primary">Save</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>



<!-- disqualify modal -->
<div class="modal fade" id="modal-disqualify">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Are You Sure?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form role="form" name="lead_disqualify" id="lead_disqualify" method="post">
						<div class="row">

						<input type="text" id="trade_india_id" class="trade_india_id text-secondary" style="border: none; font-size:10px;" required readonly>
						</div>
						<div class="row">
							

							<div class="col-sm-12">
								<div class="form-group">
									<label style="color: #FF0000;"> Reason *</label>
									<select class="form-control select2bs4" style="width: 100%;" id="reason_to_disqualify" name="reason_to_disqualify" required>
										<option value="">No Selected</option>
										<option value="1">Technical</option>
										<option value="2">Commercial</option>
										<option value="3">Lead Time</option>
										<option value="4">Irrelevant</option>
										<option value="5">Other</option>
									</select>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

					<button type="submit" name="confirm_disqualify" id="confirm_disqualify" class="btn btn-primary">Save</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- end of disqualify modal -->

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
		$(document).on('click', '#add_address', function() {

			var address = $("#address").val();
			var state_id = $("#state_id").val();
			var city_id = $("#city_id").val();
			var customer_pin_code = $("#customer_pin_code").val();
			var state_code = $("#state_code").val();
			var customer_gst_number = $("#customer_gst_number").val();
			var customer_pan_number = $("#customer_pan_number").val();
			var designation = $("#contact_person_designation").val();
			var contact_person = $("#contact_person").val();
			var contact_person_email_id = $("#contact_person_email_id").val();
			var first_contact_no = $("#first_contact_no").val();
			var second_contact_no = $("#second_contact_no").val();
			var whatsup_no = $("#whatsup_no").val();
			var customer_name = $("#pop_up_customer_name").val();
			var customer_type = $("#customer_type").val();

			if (designation != "" && address != "" && state_id != "" && city_id != "" && state_code != "" && contact_person != "" && contact_person_email_id != "" && first_contact_no != "" && customer_name != "" && customer_type != "") {
				$.ajax({
					url: "<?php echo site_url('master/customer_master/save_customer_data'); ?>",
					type: "POST",
					data: {
						'designation': designation,
						'address': address,
						'state_id': state_id,
						'city_id': city_id,
						'customer_pin_code': customer_pin_code,
						'state_code': state_code,
						'customer_gst_number': customer_gst_number,
						'customer_pan_number': customer_pan_number,
						'contact_person': contact_person,
						'contact_person_email_id': contact_person_email_id,
						'first_contact_no': first_contact_no,
						'second_contact_no': second_contact_no,
						'whatsup_no': whatsup_no,
						'customer_name': customer_name,
						'customer_type': customer_type
					},
					success: function(data) {
						data = data.trim();
						location.reload(true);
					},
					error: function(data) {
						alert("Failed!!");
					}
				});
			} else {
				alert("Enter All Details");
			}
		});



		$(function() {
			$("#example1").DataTable({
				"order": []
			});

			//get india mart id on modal

		$(document).on('click','.disqualify_btn', function(){

			$('.trade_india_id').val('');
			var trade_india_id = $(this).data('trade_india');
			$('.trade_india_id').val(trade_india_id)
		});

		$('#confirm_disqualify').click(function(){
			var trade_india_id = $('.trade_india_id').val();
			var reason_to_disqualify = $('#reason_to_disqualify').val();
			
			if(trade_india_id != "" && reason_to_disqualify != "")
			{

				$.ajax({
				url: "<?php echo site_url('indiamart_api/update_trade_india_lead_status'); ?>",
				method: "POST",
				data: {
					'trade_india_id': trade_india_id,
					'reason_to_disqualify': reason_to_disqualify
				},
				async: false,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});

			}else{
				alert("Please Enter Reason to Disqualify");
			}

		

		});



		});
	</script>

	<script type="text/javascript">
		function change_customer(item) {
			var trade_india_id = $(item).closest('tr').find('.relation_id').text();
			var customer_id = item.val();

			$.ajax({
				url: "<?php echo site_url('indiamart_api/update_customer_id'); ?>",
				method: "POST",
				data: {
					'customer_id': customer_id,
					'trade_india_id': trade_india_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;
		}

		// function change_status(d) {
		// 	alert("If You disqualify lead , It no longer available for process...");
		// 	var trade_india_id = d;

		// 	$.ajax({
		// 		url: "<?php echo site_url('indiamart_api/update_indiamart_lead_status'); ?>",
		// 		method: "POST",
		// 		data: {
		// 			'trade_india_id': trade_india_id
		// 		},
		// 		async: true,
		// 		dataType: 'json',
		// 		success: function(data) {
		// 			location.reload();
		// 		}
		// 	});
		// 	return false;
		// }
	</script>

	<script type="text/javascript">
		$('#state_id').change(function() {
			var id = $(this).val();
			$.ajax({
				url: "<?php echo site_url('master/customer_master/get_city_name'); ?>",
				method: "POST",
				data: {
					id: id
				},
				async: true,
				dataType: 'json',
				/*success: function(data){ 
				    var html = '';
				    var i;
				    for(i=0; i<data.length; i++){
				         html += '<option value='+data[i].entity_id+'>'+data[i].city_name+'</option>';
				    }
				        $('#city_id').html(html);
				}*/
				success: function(response) {

					// Remove options 
					$('#city_id').find('option').not(':first').remove();

					// Add options
					$.each(response, function(index, data) {
						$('#city_id').append('<option value="' + data['entity_id'] + '">' + data['city_name'] + '</option>');
					});
				}
			});
			return false;
		});

		$('#state_id').change(function() {
			var id = $(this).val();
			$.ajax({
				url: "<?php echo site_url('master/customer_master/get_state_code'); ?>",
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
							$('[name="state_code"]').val(data[i].state_code);
					})
				}
			});
			return false;
		});

		$('#pop_up_customer_name').change(function() {
			var id = $(this).val();
			$.ajax({
				url: "<?php echo site_url('master/customer_master/check_customer_name'); ?>",
				method: "POST",
				data: {
					id: id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//
					//location.reload();
				},
				error: function(data) {
					alert("Customer Already Exist");
					//location.reload();
					$("#pop_up_customer_name").val('');
				}
			});
			return false;
		});
	</script>

	<script>
		$(function() {
			$("#select_lead").on('click', function(event) {
				$("#select_lead").attr("disabled", true);

				var trade_india_id = [];
				$.each($("input[name='trade_india_id']:checked"), function() {
					trade_india_id.push($(this).val());
				});

				$.ajax({
					url: "<?php echo site_url('indiamart_api/update_enquiry'); ?>",
					type: 'POST',
					data: {
						'trade_india_id': trade_india_id
					},
					success: function(data) {
						window.location.href = data;
					},
					error: function() {
						alert("Fail")
					}
				});
			});
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