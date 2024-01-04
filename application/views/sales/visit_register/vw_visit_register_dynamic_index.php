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
	<title>Visit Register</title>
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

		date_default_timezone_set('Asia/Kolkata');
		$cusrrent_month = date('m');
		
		$state_list = $this->db->select('*')->from('state_master')->get()->result();
		?>
		<!-- <?php
					$first_date_of_month = date("Y-m-01");
					$end_date_of_month = date("Y-m-t");
					?> -->
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
		<div class="content-wrapper">
			<!-- Content Wrapper. Contains page content -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">Visit Register</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_campaign' ?>">Visit Register</a>
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
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Visit Regsiter</h3>
								</div>
								<div class="card-body" style="border-radius: 1.25rem;">
									<form role="form" name="sales_register_report" action="<?php echo site_url('sales/visit_register/'); ?>" method="post">

										<input type="hidden" id="session_employee_id" value="<?php echo $session_employee_id;?>" >
										<div class="btn-group">
											<a id="refresh_btn" class="btn btn-success">
												Refresh
											</a>

											<button type="button" href="#" data-toggle="modal" data-target="#modal-plan-visit" id="plan_btn" class="btn btn-warning">
												Plan Visit
											</button>
										</div>

										<div class="card-body">

											<div class="row">

												<div class="form-group col-3">
													<label> Visit Month</label>
													<select id="selected_month" name="selected_month" class="form-control">
														<?php
														for ($i = 0; $i <= 11; ++$i) {
															$time = strtotime(sprintf('+%d months', $i));
															$label = date('F ', $time);
															$value = date('m', $time);
															echo '<option value="' . $value . '" ';
															if ((isset($_GET['month'])) && ($value == $_GET['month'])) echo 'selected'; // Check if form submitted or not. select the month if yes
															echo '>' . $label . '</option>';
														}
														?>
													</select>
												</div>

												<div class="form-group col-3">
													<label> Visit Year</label>

													<select id="selected_year" name="selected_year" class="form-control">
														<?php
														for ($i = 0; $i <= 12; ++$i) {
															$time = strtotime(sprintf('-%d years', $i));
															$value = date('Y', $time);
															echo '<option value="' . $value . '" ';
															if ((isset($_GET['year'])) && ($value == $_GET['year'])) echo 'selected'; // Check if form submitted or not. select the year if yes
															echo '>' . $value . '</option>';
														}
														?>
													</select>
												</div>




												<!-- <div class=""> -->
												<div class="form-group col-3">
													<label> Sales Engineer<span style="color: #FF0000;"></span></label>
													<select class="form-control select2bs4 " style="width: 100%;" id="employee_id" name="employee_id" required>
														<!-- <option value="">Selected Employee</option> -->
														<?php
														foreach ($employee_list as $emp) : ?>
															<option value="<?php echo $emp->entity_id; ?>" <?php echo ($emp->entity_id == $session_employee_id)? "selected" : ""; ?> ><?php echo $emp->emp_first_name; ?></option>
														<?php
														endforeach;
														?>
													</select>
												</div>
												<!-- </div> -->

											</div>
											<div class="row">
												<div class="form-group">

													<button type="button" id="report_btn" class="form-control btn btn-primary " name="report_btn">Get Report</button>
												</div>
											</div>



										</div>


								</div>
								<div>


									</form>

									<div class="card-body">
										<div class="table-responsive">
											<table id="example1" class="table table-bordered">
												<thead>
													<tr style="background-color: #C0C0C0;">
														<th>Sr. No.</th>
														<th>Visit Date</th>
														<th>Sales Engg Name</th>
														<th>Customer Name</th>
														<th>Customer Address</th>
														<th>Contact Person</th>
														<th>Visit Purpose</th>
														<th>Visit Outcome</th>
														<th>Meeting Status</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody id="visit_report">


												</tbody>
											</table>
										</div>
									</div>
									<!-- /.card-body -->

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
	<!-- Start Plan Visit Modal -->
	<div class="modal fade" id="modal-plan-visit">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Plan Visit</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<div class="modal-body">

							<!-- FORM COMMON FIELDS	 -->
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label style="color: #FF0000;"> Sales Engineer *</label>
										<select class="form-control select2bs4 visit_modal" style="width: 100%;" id="pop_up_employee_id" name="pop_up_employee_id" required>
											<option value="">Not Selected</option>
											<?php foreach ($employee_list as $row) : ?>
												<option value="<?php echo $row->entity_id; ?>" <?php echo ($row->entity_id == $session_employee_id)? "selected" : ""; ?>><?php echo $row->emp_first_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<div class="col-sm-6">

									<div class="form-group">
										<label style="color: #FF0000;"> Visit Date *</label>
										<input type="date" class="form-control visit_modal" id="pop_up_visit_date" name="pop_up_visit_date" required>

									</div>
								</div>
							</div>

							<!-- END -->


							<table id="visit_plan_table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th></th>
										<th style="display: none;">Entity Id</th>
										<th>Customer Name</th>
										<th>City</th>
										<th>Contact Person</th>
										<th>Address</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 0;

									foreach ($customer_contact_list as $row) :
										$no++;
										$entity_id = $row->entity_id;
										// $unit_id = $row->unit;

										// $this->db->select('*');
										// $this->db->from('unit_master');
										// $where = '(unit_master.entity_id = "' . $unit_id . '" )';
										// $this->db->where($where);
										// $query_data = $this->db->get();
										// $query_result = $query_data->row_array();

										// if (!empty($query_result)) {
										// 	$unit_name = $query_result['unit_name'];
										// } else {
										// 	$unit_name = "NA";
										// }
									?>
										<tr id="d1">
											<td><input type="checkbox" class="checkboxes" id="customer_contact_checkbox" name="customer_contact_checkbox" value="<?php echo $row->entity_id ?>"></td>
											<td style="display: none;"><?php echo $row->entity_id; ?></td>
											<td><?php echo $row->customer_name; ?></td>
											<td><?php echo $row->city_name; ?></td>
											<td><?php echo $row->contact_person; ?></td>
											<td><?php echo $row->address; ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="customer_contact_checkbox_submited">Save</button>
					</div>
				</div>
			</div>
			<!-- /.modal-dialog -->
		</div>
	</div>
	<!-- end of Plan Visit Modal -->

	<!-- Start Lock Visit Modal -->
	<div class="modal fade" id="modal-lock-visit">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update & Lok Visit</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<div class="modal-body">

							<!-- FORM COMMON FIELDS	 -->
							<input type="hidden" class="form-control" id="pop_up_visit_relation_id" name="pop_up_visit_relation_id" required>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label style="color: #FF0000;"> Sales Engineer *</label>
										<select class="form-control select2bs4" style="width: 100%;" id="pop_up_employee_id" name="pop_up_employee_id" disabled required>
											<option value="">Not Selected</option>
											<?php foreach ($employee_list as $row) : ?>
												<option value="<?php echo $row->entity_id; ?>"><?php echo $row->emp_first_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<div class="col-sm-6">

									<div class="form-group">
										<label style="color: #FF0000;"> Visit Date *</label>
										<input type="date" class="form-control" id="pop_up_visit_date" name="pop_up_visit_date" disabled required>

									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label style="color: #FF0000;"> Customer *</label>
										<select class="form-control select2bs4" style="width: 100%;" id="pop_up_customer" name="pop_up_customer" disabled required>
											<?php foreach ($customer_contact_list as $row) : ?>
												<option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label style="color: #FF0000;"> Contact Person *</label>
										<select class="form-control select2bs4" style="width: 100%;" id="pop_up_contact_person" name="pop_up_contact_person" disabled required>
											<?php foreach ($customer_contact_list as $row) : ?>
												<option value="<?php echo $row->entity_id; ?>"><?php echo $row->contact_person; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label style="color: #FF0000;"> Visit Status *</label>
										<select class="form-control select2bs4" style="width: 100%;" id="pop_up_visit_status" name="pop_up_visit_status" required>
											<option value="1">Planned</option>
											<option value="2">Held</option>
											<option value="3">Not Held</option>
											<option value="4">Re-Scheduled</option>
										</select>
									</div>
								</div>

								<div class="col-sm-6">

									<div class="form-group">
										<label style="color: #FF0000;"> Re-Schedule Date *</label>
										<input type="date" class="form-control" id="pop_up_reschedule_date" name="pop_up_reschedule_date" disabled>

									</div>
								</div>
							</div>

							<!-- END -->


						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="lock_visit_submited">Save</button>
					</div>
				</div>
			</div>
			<!-- /.modal-dialog -->
		</div>
	</div>
	<!-- end of Lock Visit Modal -->
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
	<script type="text/javascript">
		$(document).ready(function() {
			//call function get data edit
			// fetch_po_products();


			//load data for edit
			$('#report_btn').click(function() {

				$('#plan_btn').attr('disabled', true);
				$('#report_btn').attr('disabled', true);
				$('#employee_id').attr('disabled', true);
				$('#selected_month').attr('disabled', true);
				$('#selected_year').attr('disabled', true);
				fetch_visit_register();
			});

			function fetch_visit_register() {

				var employee_id = $('#employee_id').val();
				var selected_year = $('#selected_year').val();
				var selected_month = $('#selected_month').val() - 1;
				var startDate = moment([selected_year, selected_month, 01]);
				var endDate = startDate.clone().endOf('month');
				var start_date = startDate.format("YYYY-MM-DD");
				var end_date = endDate.format("YYYY-MM-DD");
				var month_days = endDate.diff(startDate, 'days') + 1;

				$.ajax({
					url: "<?php echo site_url('sales/visit_register/fetch_engg_wise_visit_report'); ?>",
					method: "POST",
					data: {
						employee_id: employee_id,
						start_date: start_date,
						end_date: end_date,
						month_days: month_days
					},
					async: true,
					dataType: 'json',
					success: function(data) {
						// console.log(data[1]);

						var html = "";
						var sata = [];
						no = 0;

						for (var i = 0; i < data.length; i++) {

							entity_id = data[i].entity_id;
							visit_date = data[i].visit_date;
							emp_first_name = data[i].emp_first_name;
							customer_name = data[i].customer_name;
							address = data[i].address;
							customer_contact_name = data[i].contact_person;
							if (data[i].visit_purpose == null) {
								visit_purpose = "";
							} else {
								visit_purpose = data[i].visit_purpose;
							}

							if (data[i].visit_outcome == null) {
								visit_outcome = "";
							} else {
								visit_outcome = data[i].visit_outcome;
							}

							activity_type = data[i].activity_type;
							if (activity_type == 1) {
								var meeting_status = "Planned";
							} else if (activity_type == 2) {
								var meeting_status = "Held";
							} else if (activity_type == 3) {
								var meeting_status = "Not Held";
							} else if (activity_type == 4) {
								var meeting_status = "Re-Scheduled";
							} else {
								var meeting_status = activity_type;
							}



							no++;

							if (activity_type == 1) {
								html += '<tr>';
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "entity_id" style = "display: none">' + entity_id + '</td>';
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "sr_no" style="background-color: #DCDCDC;">' + no + '</td>';
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "visit_date"  style="background-color: #DCDCDC;">' + visit_date + '</td>'; //visit_date
								html += '<td class = "table_data " data-row_id = "' + entity_id + '"data-column_name = "emp_first_name"  style="background-color: #DCDCDC;">' + emp_first_name + '</td>'; //employee_id
								html += '<td class = "table_data " data-row_id = "' + entity_id + '"data-column_name = "customer_name"  style="background-color: #DCDCDC;">' + customer_name + '</td>'; //customer_id
								html += '<td class = "table_data " data-row_id = "' + entity_id + '"data-column_name = "address"  style="background-color: #DCDCDC;">' + address + '</td>'; //address
								html += '<td class = "table_data " data-row_id = "' + entity_id + '"data-column_name = "customer_contact_name"  style="background-color: #DCDCDC;">' + customer_contact_name + '</td>'; //customer_contact_id
								html += '<td class = "table_data bg-white" data-row_id = "' + entity_id + '"data-column_name = "visit_purpose" contenteditable>' + visit_purpose + '</td>'; //visit_purpose
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "visit_outcome" contenteditable>' + visit_outcome + '</td>'; //visit_outcome
								html += '<td class = "table_data " data-row_id = "' + entity_id + '"data-column_name = "activity_status" style="background-color: #DCDCDC;">' + meeting_status + '</td>'; //activity_status
								html += '<td class = " " style="background-color: #DCDCDC;"><button type = "button" href="#" data-toggle="modal" data-target="#modal-lock-visit" name = "lock_btn" id = "' + entity_id + '" class = "btn btn-xs btn-warning lock_btn">Update Status & Lock</button></td>';

							} else {

								html += '<tr>';
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "entity_id" style = "display: none">' + entity_id + '</td>';
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "sr_no" style="background-color: #DCDCDC;">' + no + '</td>';
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "visit_date" style="background-color: #DCDCDC;">' + visit_date + '</td>'; //visit_date
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "emp_first_name" style="background-color: #DCDCDC;">' + emp_first_name + '</td>'; //employee_id
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "customer_name"  style="background-color: #DCDCDC;">' + customer_name + '</td>'; //customer_id
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "address"  style="background-color: #DCDCDC;">' + address + '</td>'; //address
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "customer_contact_name"  style="background-color: #DCDCDC;">' + customer_contact_name + '</td>'; //customer_contact_id
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "visit_purpose" style="background-color: #DCDCDC;" >' + visit_purpose + '</td>'; //visit_purpose
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "visit_outcome" style="background-color: #DCDCDC;">' + visit_outcome + '</td>'; //visit_outcome
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "activity_status" style="background-color: #DCDCDC;">' + meeting_status + '</td>'; //visit_status
								html += '<td class = "table_data" data-row_id = "' + entity_id + '"data-column_name = "action"  style="background-color: #DCDCDC;">' + 'Visit Locked' + '</td>';
							}


							// <a href="<?php //echo site_url('delete_city_data/' . $entity_id); 
													?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure ?')"><i class="fas fa-trash"></i></a>

							$('#visit_report').html(html);
						}
						//   $.each(data, function(i, item){
						//        $('[name="po_entity_id"]').val(data[i].entity_id);
						//         $('[name="po_no"]').val(data[i].po_no);
					}
				});

			}

			$('#refresh_btn').click(function() {

				location.reload();

			});

			// end of function 'fetch_visit_register'

			//START==> Update Visits

			$(document).on('blur', '.table_data', function() {
				var entity_id = $(this).data('row_id');
				var table_column = $(this).data('column_name');
				var value = $(this).text();

				$.ajax({
					url: "<?php echo base_url(); ?>sales/visit_register/edit_visit_register",
					method: "POST",
					data: {
						entity_id: entity_id,
						table_column: table_column,
						value: value
					},
					success: function(data) {
						fetch_visit_register();
					}
				});

			});




			$(document).on('click', '.lock_btn', function() {


				//fetching visit details on lock visit pop up
				visit_relation_id = $(this).attr('id');

				$.ajax({
					url: "<?php echo base_url(); ?>sales/visit_register/get_visit_details_by_relation_id",
					method: "POST",
					data: {
						visit_relation_id: visit_relation_id
					},
					async: false,
					dataType: 'json',
					success: function(data) {
						console.log(visit_relation_id);
						console.log(data.entity_id);

						$('[name="pop_up_visit_relation_id"]').val(data.entity_id);
						$('[name="pop_up_employee_id"]').val(data.employee_id).trigger('change');
						$('[name="pop_up_visit_date"]').val(data.visit_date);
						$('[name="pop_up_customer"]').val(data.customer_id).trigger('change');
						$('[name="pop_up_contact_person"]').val(data.customer_contact_id).trigger('change');
						$('[name="pop_up_visit_status"]').val(data.activity_type).trigger('change');

					}
				});

			});

			$('#pop_up_visit_status').change(function(){
				visit_status = $(this).val();
				$("#lock_visit_submited").attr("disabled", false);
				if(visit_status ==4){
					$('#pop_up_reschedule_date').attr('disabled',false);
				}
			});

			$("#lock_visit_submited").on('click', function(event) {

				$("#lock_visit_submited").attr("disabled", true);

				visit_relation_id = $('#pop_up_visit_relation_id').val();
				visit_status = $('#pop_up_visit_status').val();
				reschedule_date = $('#pop_up_reschedule_date').val();

				var field_check = true;
				if(visit_status ==4 & reschedule_date == ""){
					field_check = false;
				}

				if(field_check){
		

				$.ajax({
					url: "<?php echo base_url(); ?>sales/visit_register/lock_visit_register",
					method: "POST",
					data: {
						visit_relation_id: visit_relation_id,
						visit_status: visit_status,
						reschedule_date: reschedule_date
					},
					async: false,
					dataType: 'json',
					success: function(data) {
						$('#modal-lock-visit').modal('hide');
						fetch_visit_register()

					}

				});

							
			}else{
				alert('Re-Scheduel Date in Mandatory"');
				$("#lock_visit_submited").attr("disabled", false);
			}

			});

			var table = $('#visit_plan_table').dataTable({
				"pageLength": 10
			});

			$(function() {
				$("#customer_contact_checkbox_submited").on('click', function(event) {
					$("#customer_contact_checkbox_submited").attr("disabled", true);
					$('#plan_btn').attr('disabled', true);
					$('#report_btn').attr('disabled', true);
					$('#employee_id').attr('disabled', true);
					$('#selected_month').attr('disabled', true);
					$('#selected_year').attr('disabled', true);

					var pop_up_employee_id = document.getElementById('pop_up_employee_id').value;
					var pop_up_visit_date = document.getElementById('pop_up_visit_date').value;
					var customer_contact_checkbox = table.$('input[type="checkbox"]').serializeArray();

					if (pop_up_employee_id != "" && pop_up_visit_date != "" && customer_contact_checkbox != "") {

						$.ajax({
							url: "<?php echo site_url('sales/visit_register/save_visit_plan'); ?>",
							type: 'POST',
							data: {
								'pop_up_employee_id': pop_up_employee_id,
								'customer_contact_checkbox': customer_contact_checkbox,
								'pop_up_visit_date': pop_up_visit_date
							},
							success: function(data) {
								// location.reload();
								$('#modal-plan-visit').modal('hide');
								$('.visit_modal').val('');
								fetch_visit_register();
							},
							error: function() {
								alert("Fail")
							}
						});
					} else {
						alert("All Fields are Mandatory");
					}
				});
			});

		});
	</script>

	<script>

	</script>


	<!-- <script>
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
        /*$(function () {
            $("#example1").DataTable();
            $('#example1').DataTable({
              "paging": true,
              "lengthChange": false,
              "pageLength": 50,
              "searching": false,
              "ordering": true,
              "info": true,
              "autoWidth": false,
            });
        });*/
    </script> -->

	<!-- <script type="text/javascript">
        $(document).ready(function() {
            $("#selectall").click(function() {
                if (this.checked) {
                    $('.checkboxes').each(function() {
                        $(".checkboxes").prop('checked', true);
                    })
                } else {
                    $('.checkboxes').each(function() {
                        $(".checkboxes").prop('checked', false);
                    })
                }
            });
        });

				$('#employee_id').change(function(){

// alert(1);
var employee_id = $('#employee_id').val();
		var selected_year = $('#selected_year').val();
		var selected_month = $('#selected_month').val()-1;
		var startDate = moment([selected_year,selected_month,01]);
		var endDate = startDate.clone().endOf('month');
		console.log(startDate.format("YYYY-MM-DD"));
		console.log(endDate.format("YYYY-MM-DD"));

});

    </script>

    <script type="text/javascript">
        function change_customer(item) {
            var india_mart_id = $(item).closest('tr').find('.relation_id').text();
            var customer_id = item.value;

            $.ajax({
                url: "<?php echo site_url('indiamart_api/update_customer_id'); ?>",
                method: "POST",
                data: {
                    'customer_id': customer_id,
                    'india_mart_id': india_mart_id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    //location.reload();
                }
            });
            return false;
        }

        function change_status(item) {
            var india_mart_id = $(item).closest('tr').find('.relation_id').text();
            var status = item.value;

            $.ajax({
                url: "<?php echo site_url('indiamart_api/update_indiamart_lead_status'); ?>",
                method: "POST",
                data: {
                    'status': status,
                    'india_mart_id': india_mart_id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    //location.reload();
                }
            });
            return false;
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

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
        });
    </script>

    <script type="text/javascript">
        //load data for edit
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
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

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
        });
    </script>

    <script>
        $(function() {
            $("#select_telephone_list").on('click', function(event) {
                $("#select_telephone_list").attr("disabled", true);
                var cmp_name = $('#campaign_name').val();
                var assign = $('#compaign_assign').val();
                var start = $('#start_date').val();
                var end = $('#end_date').val();

                if (!cmp_name) {
                    alert("Please Enter Campaign Name");
                    $("#select_telephone_list").removeAttr("disabled", true);
                } else if (!assign) {
                    alert("Please Assign A Campaign");
                    $("#select_telephone_list").removeAttr("disabled", true);
                } else {
                    var list_id = table.$('input[type="checkbox"]').serializeArray();
                    console.log(list_id);

                    if (list_id.length == 0) {
                        alert('Please Choose At Least Onle Tele-Phone List');
                    } else {
                        $.ajax({
                            url: "<?php echo site_url('sales/campaign_register/create_campaign'); ?>",
                            type: 'POST',
                            data: {
                                'list_id': list_id,
                                'cmp_name': cmp_name,
                                'assign': assign,
                                'start': start,
                                'end': end
                            },
                            success: function(data) {
                                console.log(data);
                                window.location.href = '<?php base_url(); ?>vw_campaign';
                            },
                            error: function() {
                                alert("Fail");
                            }
                        });
                    }
                }
            });
        });
    </script> -->


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