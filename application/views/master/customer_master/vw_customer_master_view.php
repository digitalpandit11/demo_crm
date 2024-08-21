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
	<title>View Customer Master</title>
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

		$session_employee_id = $this->session->userdata['emp_id'];
		date_default_timezone_set('Asia/Kolkata');
		$today_date = date('Y-m-d');
		

		?>
		<div class="content-wrapper">
			<!-- Content Wrapper. Contains page content -->
			<section class="content-header">
				<div class="container-fluid">
					<br>
					<!-- <div class="card" style="background-color: #20c997;"> -->
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">View Customer Master</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_erp_product_vw_customer_master' ?>">Customer Master</a></li>
									<li class="breadcrumb-item">View Customer Details</li>
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
									<form role="form" name="customer_master" action="<?php echo site_url('master/customer_master/view_customer_master_data'); ?>" method="post">

										<input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id ?>" required>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label> Customer Name <span style="color: #FF0000;">* Mandatory Field</span></label>
													<input type="text" name="customer_name" id="customer_name" class="form-control" size="50" placeholder="Enter Customer Name" disabled>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Customer Type <span style="color: #FF0000;">* Mandatory Field</span></label>
													<select class="form-control select2bs4" style="width: 100%;" id="customer_type" name="customer_type" disabled>
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
													<textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address" disabled></textarea>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>State Name <span style="color: #FF0000;">* Mandatory Field</span> </label>
													<select class="form-control select2bs4" style="width: 100%;" id="state_id" name="state_id" disabled>
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
													<select class="form-control select2bs4" style="width: 100%;" id="city_id" name="city_id" disabled>
														<option value="">Select City</option>
													</select>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label>State Code <span style="color: #FF0000;">* Mandatory</span> </label>
													<input type="text" name="state_code" id="state_code" class="form-control" size="50" placeholder="State Code" disabled>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label> Pin Code <span style="color: #FF0000;">* Mandatory</span> </label>
													<input type="text" name="customer_pin_code" id="customer_pin_code" class="form-control" size="50" placeholder="Enter Customer Pin Code" disabled>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> GST Number </label>
													<input type="text" name="customer_gst_number" id="customer_gst_number" class="form-control" size="50" placeholder="Enter GST Number" disabled>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Pan Number </label>
													<input type="text" name="customer_pan_number" id="customer_pan_number" class="form-control" size="50" placeholder="Enter Pan Number" disabled>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<!-- general form elements disabled -->
												<div class="card card-primary">
													<div class="card-header">
														<h3 class="card-title"> Contact Details</h3>
													</div>
													<div class="card-body">
														<div class="table-responsive">
															<table id="example1" class="table table-bordered table-striped col-md-12">
																<thead>
																	<tr>
																		<th>Sr. No.</th>
																		<th style="display: none;">Cust_address_Entity_id</th>
																		<th>Contact Person</th>
																		<th>Email Id</th>
																		<th>Contact Number</th>
																		<!-- <th>Alternate Contact Number <br> What's Up Number</th> -->
																		<!-- <th>Plan Visit</th> -->
																		<th>Create Quotation</th>
																	</tr>
																</thead>
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
																				<input type="text" required class="form-control" value="<?php echo $row->contact_person; ?>" id="contact_person" name="contact_person" style="width: 100px;" disabled>
																			</td>
																			<td>
																				<input type="email" required class="form-control" value="<?php echo $row->email_id; ?>" id="email_id" name="email_id" style="width: 150px;" disabled>
																			</td>
																			<td>
																				<input type="text" required class="form-control" value="<?php echo $row->first_contact_no; ?>" id="first_contact_no" name="first_contact_no" style="width: 100px;" readonly>
																			</td>
																			<!-- <td>
																				<input type="text" class="form-control" value="<?php echo $row->second_contact_no; ?>" id="second_contact_no" name="second_contact_no" style="width: 100px;" disabled>
																				<br>
																				<input type="text" class="form-control" value="<?php echo $row->whatsup_no; ?>" id="whatsup_no" name="whatsup_no" style="width: 100px;" disabled>
																			</td> -->
																			<!-- <td>
																				<a data-toggle="modal" data-target="#modal-plan-visit" data-id="<?php echo $contact_id; ?>" class="btn btn-warning plan_visit_btn">Plan Visit</a>
																			</td> -->
																			<td style="text-align:center;" >
																				<!-- <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
																							<a href="<?php echo site_url('create_customer_enquiry/' . $contact_id); ?>" class="btn btn-block btn-primary">
																							Create Lead
																							</a>
																					</div> -->
																				<a href="<?php echo site_url('create_offer_from_contact/' . $contact_id); ?>" class="btn btn-sm btn-warning">Create Quotation</a>
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
													<select class="form-control select2bs4" style="width: 100%;" id="customer_status" name="customer_status" disabled>
														<option value="">No Selected</option>
														<option value="1">Active</option>
														<option value="2">In-Active</option>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="card card-primary">
													<div class="card-header">
														<h3 class="card-title">Leads And Offers Details</h3>
													</div>

													<div class="card-body">
														<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
															<li class="nav-item">
																<a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Create Offer </a>
															</li>
															<li class="nav-item">
																<a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Pending Order</a>
															</li>
															<li class="nav-item">
																<a class="nav-link" id="custom-content-below-order-tab" data-toggle="pill" href="#custom-content-below-order" role="tab" aria-controls="custom-content-below-order" aria-selected="false">Order List</a>
															</li>
															<!--
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" id="custom-content-below-lost-tab" data-toggle="pill" href="#custom-content-below-lost" role="tab" aria-controls="custom-content-below-lost" aria-selected="false">Lost Enquiry</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" id="custom-content-below-invoice-tab" data-toggle="pill" href="#custom-content-below-invoice" role="tab" aria-controls="custom-content-below-invoice" aria-selected="false">Invoice Created</a>
                                                                    </li>-->
														</ul>

														<div class="tab-content" id="custom-content-below-tabContent">
															<div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
																<!-- <div>
                                                                            
                                                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                                                <a href="<?php echo base_url(); ?>create_offer_without_lead/<?php echo $this->uri->segment(2); ?>" class="btn btn-md btn-success" > Create Offer Without Lead</a>
                                                                            </div>
                                                                        </div> -->
																<div class="card-body">

																	<div class="table-responsive">
																		<table id="example4" class="table table-bordered table-striped">
																			<thead>
																				<tr>
																					<th>Sr. No.</th>
																					<th>Lead Number</th>
																					<th>Lead Description</th>
																					<th>Lead Type</th>
																					<th>Lead Date</th>
																					<th>Lead Status</th>
																					<th>Action</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				$no = 0;
																				foreach ($enquiry_details as $row) :
																					$no++;
																					$entity_id = $row->entity_id;
																					$Enquiry_status = $row->enquiry_status;
																					$Enquiry_type = $row->enquiry_type;

																					if ($Enquiry_status == 1) {
																						$en_status = "Pending";
																					}

																					if ($Enquiry_type == 1) {
																						$Enq_type = "Pull Cord (MH)";
																					} elseif ($Enquiry_type == 2) {
																						$Enq_type = "Porximity (PS)";
																					} elseif ($Enquiry_type == 3) {
																						$Enq_type = "Vibrator Control (VC)";
																					} elseif ($Enquiry_type == 4) {
																						$Enq_type = "Treading (TD)";
																					} elseif ($Enquiry_type == 5) {
																						$Enq_type = "Other (OT)";
																					} elseif ($Enquiry_type == 6) {
																						$Enq_type = "CUH & TD-MH";
																					} elseif ($Enquiry_type == 7) {
																						$Enq_type = "TD-PS";
																					} elseif ($Enquiry_type == 8) {
																						$Enq_type = "TD-VC";
																					} else {
																						$Enq_type = "NA";
																					}
																				?>
																					<tr>
																						<td><?php echo $no; ?></td>
																						<td><?php echo $row->enquiry_no; ?></td>
																						<td><?php echo $row->enquiry_short_desc; ?></td>
																						<td><?php echo $Enq_type; ?></td>
																						<td><?php echo date("d-m-Y", strtotime($row->enquiry_date)); ?></td>
																						<td><?php echo $en_status; ?></td>
																						<td style="text-align: center;" >
																							<div class="btn-group">

																								<a onclick="return confirm('Are You Sure To Make Offer?')" href="<?php echo site_url('setoffer/' . $entity_id); ?>" class="btn btn-sm btn-warning">Create Quotation</a>
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
																				<tr>
																					<th>Sr. No.</th>
																					<th>Quotation No. </th>
																					<th>Lead No. </th>
																					<th>Employee Name</th>
																					<th>Quotation Date</th>
																					<th>Quote Stage</th>
																					<th>Quote Value</th>
																					<th>Action</th>
																					<th>Operation</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				$no = 0;
																				foreach ($offer_details as $row) :
																					$no++;
																					$entity_id = $row->entity_id;

																					$status = $row->status;

																					if ($status == 2) {
																						$Status_data = "Active";
																					} elseif ($status == 6) {
																						$Status_data = "Win";
																					} elseif ($status == 7) {
																						$Status_data = "On Hold";
																					} elseif ($status == 8) {
																						$Status_data = "A";
																					} elseif ($status == 9) {
																						$Status_data = "B";
																					} else {
																						$Status_data = "NA";
																					}

																					$this->db->select_sum('total_amount_with_gst');
																					$this->db->from('offer_product_relation');
																					$where1 = '(offer_product_relation.offer_id = "' . $entity_id . '")';
																					$this->db->where($where1);
																					$query = $this->db->get();
																					$total_offer_amount = $query->row();

																					if (!empty($total_offer_amount)) {
																						$total_offer_amount_final = $total_offer_amount->total_amount_with_gst;
																						$final_offer_amount = number_format($total_offer_amount_final, 2, '.', '');
																					} else {
																						$final_offer_amount = 0;
																					}
																				?>
																					<tr>
																						<td><?php echo $no; ?></td>
																						<td><?php echo $row->offer_no; ?></td>
																						<td><?php echo $row->enquiry_no; ?></td>

																						<td><?php echo $row->emp_first_name; ?></td>
																						<td><?php echo date("d-m-Y", strtotime($row->offer_date)); ?></td>
																						<td><?php echo $Status_data; ?></td>
																						<td><?php echo $final_offer_amount; ?></td>
																						<td>
																							<div class="btn-group">
																								<a href="<?php echo site_url('update_offer_data/' . $entity_id); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>

																								<a href="<?php echo site_url('view_offer_data/' . $entity_id); ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>

																								<a href="<?php echo site_url('download_offer/' . $entity_id); ?>" target="_blank" class="btn btn-secondary"><i class="fa fa-print"></i></a>
																							</div>
																						</td>

																						<td>
																							<a onclick="return confirm('Are You Sure To Make Order?')" href="<?php echo site_url('setorder/' . $entity_id); ?>" class="btn btn-block btn-warning">Make Order</a>
																							<a onclick="return confirm('Are You Sure To Make Order?')" href="<?php echo site_url('set_revision_offer/' . $entity_id); ?>" class="btn btn-block btn-warning">Make Revision</a>
																						</td>
																					</tr>
																				<?php endforeach; ?>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>

															<div class="tab-pane fade" id="custom-content-below-order" role="tabpanel" aria-labelledby="custom-content-below-order-tab">
																<div class="card-body">
																	<div class="table-responsive">
																		<table id="example3" class="table table-bordered table-striped">
																			<thead>
																				<tr>
																					<th>Sr. No.</th>
																					<th>Order No. </th>
																					<th>Offer No. </th>
																					<th>Enquiry No. </th>
																					<th>Sales Consultant</th>
																					<th>Order Date</th>
																					<th>Action</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				$no = 0;
																				foreach ($order_details as $row) :
																					$no++;
																					$entity_id = $row->entity_id;
																					$offer_id = $row->offer_id;

																					if ($offer_id == NULL || empty($offer_id)) {
																						$offer_no = 'NA';
																						$enquiry_no = 'NA';
																					} else {
																						$this->db->select('offer_register.*');
																						$this->db->from('offer_register');
																						$where = '(offer_register.entity_id = "' . $offer_id . '" )';
																						$this->db->where($where);
																						$query = $this->db->get();
																						$offer_id_result =  $query->row_array();
																						$offer_no = $offer_id_result['offer_no'];
																						$enquiry_id = $offer_id_result['enquiry_id'];

																						$this->db->select('enquiry_register.*');
																						$this->db->from('enquiry_register');
																						$where = '(enquiry_register.entity_id = "' . $enquiry_id . '" )';
																						$this->db->where($where);
																						$query = $this->db->get();
																						$enquiry_id_result =  $query->row_array();
																						$enquiry_no = $enquiry_id_result['enquiry_no'];
																					}
																				?>
																					<tr>
																						<td><?php echo $no; ?></td>
																						<td><?php echo $row->sales_order_no; ?></td>
																						<td><?php echo $offer_no ?></td>
																						<td><?php echo $enquiry_no; ?></td>

																						<td><?php echo $row->emp_first_name; ?></td>
																						<td><?php echo date("d-m-Y", strtotime($row->sales_order_date)); ?></td>
																						<td>
																							<div class="btn-group">
																								<a href="<?php echo site_url('view_sales_order_data/' . $entity_id); ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
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

	<!----//modal offer create confirmation---->


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
					<div class="modal-body">

						<!-- FORM COMMON FIELDS	 -->
						<div class="form-group">
							<input type="hidden" class="form-control" id="pop_up_contact_id" name="pop_up_contact_id" required>
						</div>

						<div class="row">
							<div class="col">
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

							<div class="col">
								<div class="form-group">
									<label style="color: #FF0000;"> Visit Date *</label>
									<input type="date" class="form-control visit_modal" id="pop_up_visit_date" name="pop_up_visit_date" value="<?php echo $today_date; ?>" required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col">
								<div class="form-group">
									<label> Visit Purpose</label>
									<input type="text" class="form-control visit_modal" id="pop_up_visit_purpose" name="pop_up_visit_purpose">
								</div>
							</div>
							<div class="col">

								<div class="form-group">
									<label> Visit Outcome</label>
									<input type="text" class="form-control visit_modal" id="pop_up_visit_outcome" name="pop_up_visit_outcome">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">

								<div class="form-group">
									<label> Visit Status</label>
									<select class="form-control select2bs4" style="width: 100%;" id="pop_up_visit_status" name="pop_up_visit_status">
										<option value="1">Plan</option>
										<option value="2">Held</option>
									</select>
								</div>
							</div>
						</div>


						<!-- END -->



					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="save_visit_plan">Save</button>
					</div>
				</div>
			</div>
			<!-- /.modal-dialog -->
		</div>
	</div>
	<!-- end of Plan Visit Modal -->

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
							$('[name="address"]').val(data[i].address);
							$('[name="state_code"]').val(data[i].state_code);
							$('[name="customer_pin_code"]').val(data[i].pin_code);
							$('[name="customer_gst_number"]').val(data[i].gst_no);
							$('[name="customer_pan_number"]').val(data[i].pan_no);

							$('[name="customer_type"]').val(data[i].customer_type).trigger('change');
							$('[name="state_id"]').val(data[i].state_id).trigger('change');
							$('[name="city_id"]').val(data[i].city_id).trigger('change');
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

	<script>
		$(document).ready(function() {

			//fetching contact id on visit plan pop up
			$(document).on("click", ".plan_visit_btn", function() {

				var this_contact = $(this).closest('tr');
				var contact_id = $(this).data('id');


				$('#pop_up_contact_id').val(contact_id);
			});

			//saving visit plan pop up

			$(document).on("click", "#save_visit_plan", function() {

				var contact_id = $('#pop_up_contact_id').val();
				var employee_id = $('#pop_up_employee_id').val();
				var visit_date = $('#pop_up_visit_date').val();
				var visit_purpose = $('#pop_up_visit_purpose').val();
				var visit_outcome = $('#pop_up_visit_outcome').val();
				var visit_status = $('#pop_up_visit_status').val();

				if (contact_id != "" && visit_date != "" && employee_id != "") {

					$.ajax({
						url: "<?php echo site_url('sales/visit_register/save_visit_from_customer'); ?>",
						method: "POST",
						data: {
							contact_id: contact_id,
							employee_id: employee_id,
							visit_date: visit_date,
							visit_purpose: visit_purpose,
							visit_outcome: visit_outcome,
							visit_status: visit_status
						},
						async: true,
						dataType: 'json',
						success: function(data) {

							$('#modal-plan-visit').modal('hide');
							$('.visit_modal').val('');
							alert('Visit saved as ' + data);
						},
						error: function(data) {
							alert("Customer Already Exist");
							//location.reload();
							$("#customer_name").val('');
						}
					});

				} else {
					alert('Please fill mandatory Fields');;
				}





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
