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
	<title>Month Wise Quotation Summary</title>
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

		?>
		<div class="content-wrapper">
			<!-- Content Wrapper. Contains page content -->
			<section class="content-header">
				<div class="container-fluid">
					<br>
					<!-- <div class="card" style="background-color: #20c997;"> -->
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">Monthwise Quotation Summary</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item">Month Wise Quotaiton Summary</li>
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
									<form role="form" name="customer_master" action="<?php echo site_url('vw_month_wise_quotation_summary_report_generate'); ?>" method="post">


										<div>
											<div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
												<a data-toggle="modal" data-target="#modal-add-month" class="btn btn-block btn-primary" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
													Add New Month
												</a>
											</div>
										</div>
										<div class="card-body">
											<div class="table-responsive">

												<table id="example11" class="table table-bordered table-striped">
													<thead>
														<tr>
															<th>Select</th>
															<th>Month-Year</th>
															<th>Working Days</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$no = 0;
														foreach ($month_list as $row) :
															$no++;
															$month_id = $row->entity_id;
														?>
															<tr>
																<td><input type="checkbox" class="checkboxes" id="month" name="month[]" value="<?php echo $month_id ?>"></td>
																<td>
																	<input type="text" class="form-control" value="<?php echo $row->month_name; ?>" id="month_name" name="month_name" readonly>
																</td>
																<td>
																	<input type="text" class="form-control" value="<?php echo $row->working_days; ?>" id="working_days" name="working_days" onchange="change_working_days(this);">
																</td>
															</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>



										<div class="card-body">
											<center>
												<button type="submit" id="btn_submit" name="btn_submit" class="btn btn-success toastrDefaultSuccess">
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
	<div class="modal fade" id="modal-add-month">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Month & Working Days</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form role="form" name="customer_address" id="customer_address" action="<?php echo base_url('add_monthly_working_days'); ?>" method="post">
						<div class="row">

							<div class="col-sm-6">
								<div class="form-group">
									<label> <span style="color: #FF0000;"> Month * </span> </label>
									<select class="form-control select2bs4" style="width: 100%;" id="pop_up_month" name="pop_up_month" required>
										<option value="">Not Selected</option>
										<option value="01">JAN</option>
										<option value="02">FEB</option>
										<option value="03">MAR</option>
										<option value="04">APR</option>
										<option value="05">MAY</option>
										<option value="06">JUN</option>
										<option value="07">JUL</option>
										<option value="08">AUG</option>
										<option value="09">SEP</option>
										<option value="10">OCT</option>
										<option value="11">NOV</option>
										<option value="12">DEC</option>

									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label> <span style="color: #FF0000;"> Year * </span> </label>
									<select class="form-control select2bs4" style="width: 100%;" id="pop_up_year" name="pop_up_year" required>
										<option value="2023">2023</option>
										<option value="2024">2024</option>
										<option value="2025">2025</option>
										<option value="2026">2026</option>
										<option value="2027">2027</option>
										<option value="2028">2028</option>
										<option value="2029">2029</option>
										<option value="2030">2030</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">


							<div class="col-sm-6">
								<div class="form-group">
									<label> <span style="color: #FF0000;"> Month Name * </span> </label>
									<input type="text" name="pop_up_month_name" id="pop_up_month_name" class="form-control" size="50" placeholder="Enter Month Year" required>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label> <span style="color: #FF0000;"> Working Days * </span> </label>
									<input type="number" name="pop_up_working_days" id="pop_up_working_days" class="form-control" size="50" placeholder="Enter working Days" value="22" required>
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

							<button type="submit" name="add_month" id="add_month" class="btn btn-primary">Save</button>
						</div>

					</form>
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
	<scriptc="<?php echo base_url() . 'assets/plugins/moment/moment.min.js' ?>">
		</scriptc=>
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



			});
		</script>

		<script>
			$(document).ready(function() {

				// get month
				$('#pop_up_month').on('change', function() {
					var month = $(this).find("option:selected").text();
					var year = $('#pop_up_year').val();

					var month_year = month + "-" + year;

					$('#pop_up_month_name').val(month_year);

				});


				// get year
				$('#pop_up_year').on('change', function() {
					var year = $(this).val();
					var month = $('#pop_up_month').find("option:selected").text();

					var month_year = month + "-" + year;

					$('#pop_up_month_name').val(month_year);

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
