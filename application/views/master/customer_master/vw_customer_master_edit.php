<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$_SESSION['user_name']) {
	$data = site_url('dashboard');

	header("location:$data");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Update Customer Master</title>
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
	<link rel="icon" href="<?php echo base_url() . 'assets/company_logo/QFS_Logo.png' ?>" type="image/ico" />
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<?php
		$this->load->view('header_sidebar');

		$this->db->select('customer_master.*');
		$this->db->from('customer_master');
		$this->db->where('entity_id', $entity_id);
		$query = $this->db->get();
		$query_result = $query->row_array();

		$city_id = $query_result['city_id'];

		?>
		<div class="content-wrapper">
			<!-- Content Wrapper. Contains page content -->
			<section class="content-header">
				<div class="container-fluid">
					<br>
					<!-- <div class="card" style="background-color: #20c997;"> -->
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">Update Customer</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_erp_product_vw_customer_master' ?>">Customer Master</a></li>
									<li class="breadcrumb-item">Update Customer Details</li>
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
									<h3 class="card-title">Customer Master Form</h3>
								</div>
								<div class="card-body">
									<form role="form" name="customer_master" action="<?php echo site_url('master/customer_master/edit_customer_master_data'); ?>" method="post">

										<input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id ?>" required>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label> Customer Name <span style="color: #FF0000;">* Mandatory Field</span></label>
													<input type="text" name="customer_name" id="customer_name" class="form-control" size="50" placeholder="Enter Customer Name" required>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Customer Type <span style="color: #FF0000;">* Mandatory Field</span></label>
													<select class="form-control select2bs4" style="width: 100%;" id="customer_type" name="customer_type" required>
														<option value="">No Selected</option>
														<option value="1">Dealer</option>
														<option value="2">End User</option>
														<option value="3">OEM</option>
														<option value="4">Trader</option>
														<option value="5">System Integrator</option>
													</select>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Address <span style="color: #FF0000;">* Mandatory Field</span> </label>
													<textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address" required></textarea>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>State Name <span style="color: #FF0000;">* Mandatory Field</span> </label>
													<select class="form-control select2bs4" style="width: 100%;" id="state_id" name="state_id" required>
														<option value="">Select State</option>
														<?php foreach ($state_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->State_name; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label>City Name <span style="color: #FF0000;">* Mandatory Field</span> </label>
													<select class="form-control select2bs4" style="width: 100%;" id="city_id" name="city_id" required>
														<option value="">Select City</option>
													</select>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label>State Code <span style="color: #FF0000;">* Mandatory</span> </label>
													<input type="text" name="state_code" id="state_code" class="form-control" size="50" placeholder="State Code" readonly>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label> Pin Code <span style="color: #FF0000;">* Mandatory</span> </label>
													<input type="text" name="customer_pin_code" id="customer_pin_code" class="form-control" size="50" placeholder="Enter Customer Pin Code">
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> GST Number </label>
													<input type="text" name="customer_gst_number" id="customer_gst_number" class="form-control" size="50" placeholder="Enter GST Number">
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Note for Customer <span style="color: #FF0000;"></span> </label>
													<textarea class="form-control" id="customer_note" name="customer_note" rows="3" placeholder="Enter Address"></textarea>
												</div>
											</div>

											<!-- <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Pan Number </label>
                                                            <input type="text" name="customer_pan_number" id="customer_pan_number" class="form-control" size="50" placeholder="Enter Pan Number">
                                                        </div>
                                                    </div> -->
										</div>

										<div class="row">
											<div class="col-md-12">
												<!-- general form elements disabled -->
												<div class="card card-primary">
													<div class="card-header">
														<h3 class="card-title"> Contact Details</h3>
													</div>
													<div>
														<div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
															<a data-toggle="modal" data-target="#modal-lg-bill-to" class="btn btn-block btn-primary" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
																Enter Contact Details
															</a>
														</div>
													</div>
													<div class="card-body">
														<div class="table-responsive">
															
															<table id="example1" class="table table-bordered table-striped">
																<thead>
																	<tr>
																		<th>Sr. No.</th>
																		<th style="display: none;">Cust_address_Entity_id</th>
																		<th>Designation</th>
																		<th>Department</th>
																		<th>Contact Person</th>
																		<th>Email Id</th>
																		<th>Contact Number</th>
																		<th>Alternate Contact Number</th>
																		<th>Note for Person</th>
																	</tr>
																</thead>
																<tfoot style="display: table-header-group;">
																<tr>
																<th>Sr. No.</th>
																		<th style="display: none;">Cust_address_Entity_id</th>
																		<th class="searchable">Designation</th>
																		<th class="searchable">Department</th>
																		<th class="searchable">Contact Person</th>
																		<th class="searchable">Email Id</th>
																		<th class="searchable">Contact Number</th>
																		<th class="searchable">Alternate Contact Number</th>
																		<th class="searchable">Note for Person</th>
																</tr>
															</tfoot>
																<tbody>
																	<?php
																	$no = 0;
																	foreach ($contact_details as $row) :
																		$no++;
																		$contact_id = $row->entity_id;
																	?>
																		<tr>
																			<td><?php echo $no; ?></td>
																			<td style="display: none;" class="contact_relation_entity_id" id="contact_relation_entity_id"><?php echo $contact_id; ?></td>

																			<td>
																				<input type="text" class="form-control" value="<?php echo $row->designation; ?>" id="designation" name="designation" style="width: 100px;" onchange="change_designation(this);">
																			</td>
																			<td>
																				<input type="text" class="form-control" value="<?php echo $row->department; ?>" id="department" name="department" style="width: 100px;" onchange="change_department(this);">
																			</td>
																			<td>
																				<input type="text" required class="form-control" value="<?php echo $row->contact_person; ?>" id="contact_person" name="contact_person" style="width: 200px;" onchange="change_contactperson(this);">
																			</td>
																			<td>
																				<input type="email" required class="form-control" value="<?php echo $row->email_id; ?>" id="email_id" name="email_id" style="width: 200px;" onchange="change_emailid(this);">
																			</td>
																			<td>
																				<input type="text" required class="form-control first_contact_no" value="<?php echo $row->first_contact_no; ?>" id="first_contact_no" name="first_contact_no" style="width: 150px;">
																				<!-- onchange="change_contactnumber(this);"> -->
																				<span class="error lblError"></span>
																			</td>
																			<td>
																				<input type="text" class="form-control" value="<?php echo $row->second_contact_no; ?>" id="second_contact_no" name="second_contact_no" style="width: 150px;" onchange="change_alternatecontactnumber(this);">
																			</td>
																			<td>
																				<input type="text" class="form-control" value="<?php echo $row->contact_note; ?>" id="contact_note" name="contact_note" style="width: 250px;" onchange="change_contact_note(this);">
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

										<div class="row">
											<div class="col-sm-4">
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Customer Status</label>
													<select class="form-control select2bs4" style="width: 100%;" id="customer_status" name="customer_status" required>
														<option value="">No Selected</option>
														<option value="1">Active</option>
														<option value="2">In-Active</option>
													</select>
												</div>
											</div>
										</div>
										<div class="card-body">
											<center>
												<button type="submit" id="customer_submit" name="customer_submit" class="btn btn-success toastrDefaultSuccess">
													Submit
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
	<div class="modal fade" id="modal-lg-bill-to">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Write Customer Contact Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form role="form" name="customer_address" id="customer_address" method="post">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label> <span style="color: #FF0000;"> Designation * </span> </label>
									<input type="text" name="pop_up_designation" id="pop_up_designation" class="form-control" size="50" placeholder="Enter Designation">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label> <span style="color: #FF0000;"> Department * </span> </label>
									<input type="text" name="pop_up_department" id="pop_up_department" class="form-control" size="50" placeholder="Enter Department">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label> <span style="color: #FF0000;"> Contact Person * </span> </label>
									<input type="text" name="pop_up_contact_person" id="pop_up_contact_person" class="form-control" size="50" placeholder="Enter Contact Person" required>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label> <span style="color: #FF0000;"> Email Id * </span> </label>
									<input type="email" name="pop_up_contact_person_email_id" id="pop_up_contact_person_email_id" class="form-control" size="50" placeholder="Enter Customer Email Id" required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label> <span style="color: #FF0000;"> Contact Number * </span> </label>
									<input type="text" name="pop_up_first_contact_no" id="pop_up_first_contact_no" class="form-control" size="50" placeholder="Enter Contact Number" required>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label> Alternate Contact Number </label>
									<input type="text" name="pop_up_second_contact_no" id="pop_up_second_contact_no" class="form-control" size="50" placeholder="Enter Alternate Contact Number">
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label> Note for Person </label>
									<input type="text" name="pop_up_contact_note" id="pop_up_contact_note" class="form-control" size="50" placeholder="Enter Note">
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
		</div>
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
		$(document).ready(function() {
			$('#example1 tfoot .searchable ').each(function() {
				var title = $(this).text();
				$('#example1 tfoot .searchable').html('<input type="text" style="width: 150px;" placeholder="Search ' + title + '" />');
			});


			var table = $('#example1').dataTable({
				initComplete: function() {
					// Apply the search
					this.api()
						.columns()
						.every(function() {
							var that = this;

							$('input', this.footer()).on('keyup change clear', function() {
								if (that.search() !== this.value) {
									that.search(this.value).draw();
								}
							});
						});
				},
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {

			// $("#example1").DataTable();

			//call function get data edit
			get_data_edit();
			//get_city_data_edit();

			//load data for edit
			function get_data_edit() {
				var entity_id = $('[name="entity_id"]').val();

				$.ajax({
					url: "<?php echo site_url('master/customer_master/get_all_data_by_id'); ?>",
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
								$('[name="customer_name"]').val(data[i].customer_name);
							$('[name="customer_type"]').val(data[i].customer_type).trigger('change');
							$('[name="address"]').val(data[i].address);
							$('[name="state_id"]').val(data[i].state_id).trigger('change');
							$('[name="city_id"]').val(data[i].city_id).trigger('change');
							$('[name="state_code"]').val(data[i].state_code);
							$('[name="customer_pin_code"]').val(data[i].pin_code);
							$('[name="customer_gst_number"]').val(data[i].gst_no);
							$('[name="customer_note"]').val(data[i].customer_note);

							$('[name="customer_status"]').val(data[i].status).trigger('change');
						});
					}
				});
			}

			$('#state_id').change(function() {
				var id = $(this).val();
				var city_id = "<?php echo $city_id; ?>";

				$.ajax({
					url: "<?php echo site_url('master/customer_master/get_city_name'); ?>",
					method: "POST",
					data: {
						id: id
					},
					async: true,
					dataType: 'json',

					success: function(response) {

						// Remove options 
						$('#city_id').find('option').not(':first').remove();

						// Add options
						$.each(response, function(index, data) {
							if (city_id == data.entity_id) {
								$('#city_id').append('<option value="' + data['entity_id'] + '" selected>' + data['city_name'] + '</option>').trigger('change');

							} else {
								$('#city_id').append('<option value="' + data['entity_id'] + '">' + data['city_name'] + '</option>');

							}
						});
					}

				});
				return false;
			});

			$('#state_id').change(function() {
				var id = $(this).val();
				$.ajax({
					url: "<?php echo site_url('master/customer_master/get_state_id'); ?>",
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
						});
					}
				});
				return false;
			});

		});
	</script>

	<script type="text/javascript">
		$('#customer_name').change(function() {
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
					$("#customer_name").val('');
				}
			});
			return false;
		});
	</script>

	<script type="text/javascript">
		$(document).on('click', '#add_address', function() {

			var entity_id = $('[name="entity_id"]').val();

			var designation = $("#pop_up_designation").val();
			var department = $("#pop_up_department").val();
			var contact_person = $("#pop_up_contact_person").val();
			var contact_person_email_id = $("#pop_up_contact_person_email_id").val();
			var first_contact_no = $("#pop_up_first_contact_no").val();
			var second_contact_no = $("#pop_up_second_contact_no").val();
			var contact_note = $("#pop_up_contact_note").val();

			if (entity_id != "" && contact_person != "" && contact_person_email_id != "" && first_contact_no != "") {
				$.ajax({
					url: "<?php echo site_url('master/customer_master/save_address_at_edit_page'); ?>",
					type: "POST",
					data: {
						'entity_id': entity_id,
						'designation': designation,
						'department': department,
						'contact_person': contact_person,
						'contact_person_email_id': contact_person_email_id,
						'first_contact_no': first_contact_no,
						'second_contact_no': second_contact_no,
						'contact_note': contact_note
					},
					success: function(data) {
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
	</script>

	<script type="text/javascript">
		$(document).ready(function() {


			$(document).on("change keyup", ".first_contact_no", function() {


				var contact_no = $(this).val();
				var contact_relation_entity_id = $(this).closest('tr').find('.contact_relation_entity_id ').text();
				//  alert(contact_no);
				var regex = /^(?:(?:\+|0{1})91(\s|\-)?)?(\d{10})$/;
				var html = "Invalid Number - Please check 'Acceptable Formats' ";

				if (regex.test(contact_no)) {
					$(".lblError").css("display", "none");
					$('#customer_submit').attr('disabled', false);
					contact_no = regex.exec(contact_no)[0];

					$.ajax({
						url: "<?php echo site_url('master/customer_master/update_contactnumber'); ?>",
						method: "POST",
						data: {
							'contact_no': contact_no,
							'contact_relation_entity_id': contact_relation_entity_id
						},
						async: true,
						dataType: 'json',
						success: function(data) {
							location.reload();
						}
					});
				} else {
					$(".lblError").text(html);
					$('#customer_submit').attr('disabled', true);
				}
			});

		});
		/*function change_state(item)
		{
		   var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
		   var state_id = item.value;
		   
		    $.ajax({
		        url : "<?php echo site_url('master/customer_master/update_state'); ?>",
		        method : "POST",
		        data : {'state_id': state_id,
		                'address_relation_entity_id': address_relation_entity_id},
		        async : true,
		        dataType : 'json',
		        success: function(data){
		            location.reload();
		        }
		    });
		    return false;
		}

		function change_city(item)
		{
		   var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
		   var city_id = item.value;
		   
		    $.ajax({
		        url : "<?php echo site_url('master/customer_master/update_city'); ?>",
		        method : "POST",
		        data : {'city_id': city_id,
		                'address_relation_entity_id': address_relation_entity_id},
		        async : true,
		        dataType : 'json',
		        success: function(data){
		            location.reload();
		        }
		    });
		    return false;
		}

		function change_address(item)
		{
		   var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
		   var address = item.value;
		   
		    $.ajax({
		        url : "<?php echo site_url('master/customer_master/update_address'); ?>",
		        method : "POST",
		        data : {'address': address,
		                'address_relation_entity_id': address_relation_entity_id},
		        async : true,
		        dataType : 'json',
		        success: function(data){
		            location.reload();
		        }
		    });
		    return false;
		}

		function change_pincode(item)
		{
		   var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
		   var pin_code = item.value;
		   
		    $.ajax({
		        url : "<?php echo site_url('master/customer_master/update_pincode'); ?>",
		        method : "POST",
		        data : {'pin_code': pin_code,
		                'address_relation_entity_id': address_relation_entity_id},
		        async : true,
		        dataType : 'json',
		        success: function(data){
		            location.reload();
		        }
		    });
		    return false;
		}

		function change_statecode(item)
		{
		   var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
		   var state_code = item.value;
		   
		    $.ajax({
		        url : "<?php echo site_url('master/customer_master/update_statecode'); ?>",
		        method : "POST",
		        data : {'state_code': state_code,
		                'address_relation_entity_id': address_relation_entity_id},
		        async : true,
		        dataType : 'json',
		        success: function(data){
		            location.reload();
		        }
		    });
		    return false;
		}

		function change_gstnumber(item)
		{
		   var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
		   var gst_no = item.value;
		   
		    $.ajax({
		        url : "<?php echo site_url('master/customer_master/update_gstnumber'); ?>",
		        method : "POST",
		        data : {'gst_no': gst_no,
		                'address_relation_entity_id': address_relation_entity_id},
		        async : true,
		        dataType : 'json',
		        success: function(data){
		            location.reload();
		        }
		    });
		    return false;
		}

		function change_pannumber(item)
		{
		   var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
		   var pan_no = item.value;
		   
		    $.ajax({
		        url : "<?php echo site_url('master/customer_master/update_pannumber'); ?>",
		        method : "POST",
		        data : {'pan_no': pan_no,
		                'address_relation_entity_id': address_relation_entity_id},
		        async : true,
		        dataType : 'json',
		        success: function(data){
		            location.reload();
		        }
		    });
		    return false;
		}*/

		function change_designation(item) {
			var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
			var designation = item.value;

			$.ajax({
				url: "<?php echo site_url('master/customer_master/update_designation'); ?>",
				method: "POST",
				data: {
					'designation': designation,
					'contact_relation_entity_id': contact_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_department(item) {
			var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
			var department = item.value;

			$.ajax({
				url: "<?php echo site_url('master/customer_master/update_department'); ?>",
				method: "POST",
				data: {
					'department': department,
					'contact_relation_entity_id': contact_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_contactperson(item) {
			var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
			var contact_person = item.value;

			$.ajax({
				url: "<?php echo site_url('master/customer_master/update_contactperson'); ?>",
				method: "POST",
				data: {
					'contact_person': contact_person,
					'contact_relation_entity_id': contact_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_emailid(item) {
			var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
			var email_id = item.value;

			$.ajax({
				url: "<?php echo site_url('master/customer_master/update_emailid'); ?>",
				method: "POST",
				data: {
					'email_id': email_id,
					'contact_relation_entity_id': contact_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		//   function change_contactnumber(item)
		//   {

		//      var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
		//      var contact_no = item.value;
		//      var regex = /^(?:(?:\+|0{1})91(\s|\-)?)?(\d{10})$/;

		//       if (regex.test(contact_no)) {
		//           $(".lblError").css("display", "none");
		//           $('#customer_submit').attr('disabled', false);
		//           contact_no =regex.exec(contact_no)[0];

		//       $.ajax({
		//           url : "<?php echo site_url('master/customer_master/update_contactnumber'); ?>",
		//           method : "POST",
		//           data : {'contact_no': contact_no,
		//                   'contact_relation_entity_id': contact_relation_entity_id},
		//           async : true,
		//           dataType : 'json',
		//           success: function(data){
		//               location.reload();
		//           }
		//       });
		//   } else {
		//     $(".lblError").css("display", "block");
		//       $('#customer_submit').attr('disabled', true);
		//   }
		// }

		function change_alternatecontactnumber(item) {
			var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
			var alternate_contact_no = item.value;

			$.ajax({
				url: "<?php echo site_url('master/customer_master/update_alternatecontactnumber'); ?>",
				method: "POST",
				data: {
					'alternate_contact_no': alternate_contact_no,
					'contact_relation_entity_id': contact_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_contact_note(item) {
			var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
			var contact_note = item.value;

			$.ajax({
				url: "<?php echo site_url('master/customer_master/update_contact_note'); ?>",
				method: "POST",
				data: {
					'contact_note': contact_note,
					'contact_relation_entity_id': contact_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_whatsupcontactnumber(item) {
			var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
			var whatsup_contact_no = item.value;

			$.ajax({
				url: "<?php echo site_url('master/customer_master/update_whatsupcontactnumber'); ?>",
				method: "POST",
				data: {
					'whatsup_contact_no': whatsup_contact_no,
					'contact_relation_entity_id': contact_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_party_name(item) {
			var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
			var party_name = item.value;

			$.ajax({
				url: "<?php echo site_url('master/customer_master/update_party_name'); ?>",
				method: "POST",
				data: {
					'party_name': party_name,
					'address_relation_entity_id': address_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}
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