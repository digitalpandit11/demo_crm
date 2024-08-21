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
	<title>Create Quotation</title>
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
	<style>
		#error_message {
			display: none;
			background-color: #dc3545;
			/* Red background color */
			color: white;
			/* White text color */
			padding: 5px;
			/* Padding around the content */
			margin-bottom: 15px;
			/* Bottom margin */
			border-radius: 5px;
			/* Rounded corners */
			margin-top: 25px;
		}
	</style>
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<?php $this->load->view('header_sidebar'); ?>
		<?php
		if (empty($enquiry_result)) {

			$enquiry_attachment_data = NULL;
			$enquiry_attachment_img = NULL;
			$enquiry_image_attachment_name = array('name' => "");
		} else {
			$enquiry_attachment_data = $enquiry_result->row_array();
			$enquiry_attachment_img = @$enquiry_attachment_data['attachment'];
			$enquiry_image_attachment_name = explode(',', $enquiry_attachment_img);
			array_pop($enquiry_image_attachment_name);
		}

		$attachment_data = $offer_result->row_array();
		//print_r($attachment_data);
		$attachment_img = @$attachment_data['attachment'];
		$image_attachment_name = explode(',', $attachment_img);
		array_pop($image_attachment_name);

		$this->db->select('*');
		$this->db->from('offer_register');
		$where = '(offer_register.enquiry_id = "' . $entity_id . '" )';
		$this->db->where($where);
		$this->db->order_by('offer_register.entity_id', 'DESC');
		$this->db->limit(1);
		$query_data = $this->db->get();
		$query_result = $query_data->row_array();

		$offer_entity_id = $entity_id;

		$this->db->select('offer_register.*');
		$this->db->from('offer_register');
		$this->db->where('entity_id', $offer_entity_id);
		$query = $this->db->get();
		$query_result = $query->row_array();

		$contact_person_id = $query_result['contact_person_id'];


		?>
		<div class="content-wrapper">
			<!-- Content Wrapper. Contains page content -->
			<section class="content-header">
				<div class="container-fluid">
					<br>
					<!-- <div class="card" style="background-color: #20c997;"> -->
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">Create Quotation</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_offer_data' ?>">Quotation Register</a></li>
									<li class="breadcrumb-item">Enter Quotation Details</li>
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
									<h3 class="card-title">Quotation Details Form11</h3>
								</div>
								<div class="card-body">
									<form role="form" name="offer_form" enctype="multipart/form-data" action="<?php echo site_url('sales/offer_register/update_offer'); ?>" method="post">

										<input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id ?>" required>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label> Quotation Number </label>
													<input type="text" name="offer_number" id="offer_number" class="form-control" size="50" placeholder="Enter Quotation Number" readonly>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Lead Number </label>
													<input type="text" name="enquiry_number" id="enquiry_number" class="form-control" size="50" placeholder="Enter Lead Number" readonly>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Lead Attachment </label>
													<?php
													foreach ($image_attachment_name as $key => $value) {
													?>
														<p>
															<a target="_blank" href="<?php echo base_url(); ?>assets/enquiry_attachment/<?php echo $value; ?>"><?php echo $value; ?></a>
														</p>
													<?php } ?>
												</div>
											</div>
										</div>

										<div class="row">


											<input type="hidden" id="customer_name" name="customer_name" required>


											<div class="col-sm-4">
												<div class="form-group">
													<label> Customer Name </label>
													<input type="text" name="customer_view_name" id="customer_view_name" class="form-control" readonly size="50" placeholder="Customer Name">
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Contact Person </label>
													<select class="form-control select2bs4" style="width: 100%;" id="contact_id" name="contact_id" required>
														<option value="">Not Selected</option>
														<?php foreach ($contact_person_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->contact_person; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Offer Customer Name </label>
													<input type="text" name="offer_company_name" id="offer_company_name" class="form-control" size="50" placeholder="Customer Name">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="card card-primary">
													<div class="card-header">
														<h3 class="card-title"> Customer Address Details</h3>
													</div>
													<div class="card-body">
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<label> Contact Person </label>
																	<input type="text" name="enquiry_contact_person" id="enquiry_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" readonly onchange="change_contact_person(this);">
																</div>
															</div>

															<div class="col-sm-6">
																<div class="form-group">
																	<label> Customer Email Id </label>
																	<input type="text" name="enquiry_email_id" id="enquiry_email_id" class="form-control" readonly size="50" placeholder="Customer Email Id" onchange="change_email_id(this);">
																</div>
															</div>
														</div>

														<div class="row">
															<div class="col-sm-4">
																<div class="form-group">
																	<label> Contact Number </label>
																	<input type="text" name="enquiry_contact_number" id="enquiry_contact_number" class="form-control" readonly size="50" placeholder="Customer Contact Number" onchange="change_contact_no(this);">
																</div>
															</div>

															<div class="col-sm-4">
																<div class="form-group">
																	<label> State </label>
																	<input type="text" name="enquiry_customer_state" id="enquiry_customer_state" class="form-control" size="50" placeholder="Customer State" readonly>
																</div>
															</div>

															<div class="col-sm-4">
																<div class="form-group">
																	<label> City </label>
																	<input type="text" name="enquiry_customer_city" id="enquiry_customer_city" class="form-control" size="50" placeholder="Customer City" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;"> Quotation Description * </label>
													<textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enter Quotation Description" required></textarea>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Your Reference</label>
													<textarea class="form-control" id="your_reference" name="your_reference" rows="3" placeholder="Enter Your Reference"></textarea>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;"> Salutation * </label>
													<textarea class="form-control" id="salutation" name="salutation" rows="3" placeholder="Enter Salutation" required></textarea>
												</div>
											</div>



										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label> <span style="color: #FF0000;">Quotation For </span><small>(Product Sales / Project Sales / Service Sales)</small> *</label>
													<select class="form-control select2bs4" style="width: 100%;" id="offer_for" name="offer_for" required>
														<option value="">Select Product Group</option>
														<?php foreach ($offer_for_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->offer_for; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label> <span style="color: #FF0000;">Quotation For </span><small>(Product / Brand )</small> *</label>
													<select class="form-control select2bs4" style="width: 100%;" id="offer_for_info" name="offer_for_info" required>
														<option value="">Select Product Group</option>
														<?php foreach ($offer_for_info_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->offer_for_info; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;"> Quotation Date *</label>
													<input type="date" name="offer_date" id="offer_date" class="form-control" size="50" required>
												</div>
											</div>



											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;"> Enquiry Source</label>
													<select class="form-control select2bs4" style="width: 100%;" id="offer_source" name="offer_source" required>
														<option value="">Select</option>
														<option value="">No Selected</option>
														<?php foreach ($source_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->source_name; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;"> Intact CRM Name *</label>
													<select class="form-control select2bs4" style="width: 100%;" id="employee_id" name="employee_id" required>
														<option value="">Not Selected</option>
														<?php foreach ($employee_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->Emp_name; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;"> Intact RM Name *</label>
													<select class="form-control select2bs4" style="width: 100%;" id="rm_employee_id" name="rm_employee_id" required>
														<option value="">Not Selected</option>
														<?php foreach ($employee_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->Emp_name; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;"> Principle Engg *</label>
													<select class="form-control select2bs4" style="width: 100%;" id="principle_engg_id" name="principle_engg_id" required>
														<option value="">Not Selected</option>
														<?php foreach ($principle_engg_list as $row) : ?>
															<option value="<?php echo $row->entity_id; ?>"><?php echo $row->Principle_engg_name; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>



										<div class="row">

										</div>

										<div class="row">
											<div class="col-md-12">
												<!-- general form elements disabled -->
												<div class="card card-primary">
													<div class="card-header">
														<h3 class="card-title"> Product Details</h3>
													</div>
													<div>
														<div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
															<a data-toggle="modal" data-target="#modal-product" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
																Select Product
															</a>
														</div>

														<div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
															<a data-toggle="modal" data-target="#modal-lg-hsn-add" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
																Add HSN Code
															</a>
														</div>

														<!-- <div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
															<a data-toggle="modal" data-target="#modal-lg-product-add" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
																Add Product
															</a>

														</div> -->

														<div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
															<a data-toggle="modal" data-target="#modal-lg-upload-template" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
																Upload Template
															</a>

														</div>

														<div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
															<?php $product_attachment = "working_sheet.csv"; ?>
															<button style="width: 200px; margin: auto;" type="button" class="btn btn-block btn-danger float-right">
																<a style="color: white;" href="<?php echo base_url('assets/' . $product_attachment); ?>" download="<?php echo $product_attachment; ?>">
																	Download Example Sheet
																</a>
															</button>
														</div>


														<p style="color: #FF0000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Please Check HSN Code Of Product Before Submiting Offer</p>

													</div>
													<div class="card-body">
														<div class="table-responsive">
															<table id="example1" class="table table-bordered table-striped">
																<thead>
																	<tr>
																		<th style="display: none;">Entity Id</th>
																		<th style="display: none;">driver</th>
																		<th>Sr. No.</th>
																		<th>Name</th>
																		<th>Make</th>
																		<th>Part No</th>
																		<th>Description</th>
																		<th>Delivery Period</th>
																		<th>Current Stock</th>
																		<th>Price</th>
																		<th>Qty</th>
																		<th>Basic Amount</th>
																		<th>Discount</th>
																		<th>Discount Type</th>
																		<th>Discount(Amt)</th>
																		<th>Unit Discounted(Amt)</th>
																		<th>Total Amount Without GST</th>
																		<th>HSN Code</th>
																		<!-- <th>CGST%</th>
																		<th>SGST%</th>
																		<th>IGST%</th> -->
																		<th>GST%</th>
																		<th>GST Amount</th>
																		<th>Total Amount</th>
																		<th>Remark</th>
																		<th>Internal Remark</th>
																		<th>Action</th>
																	</tr>
																</thead>
																<tbody id="driverbody">
																	<?php

																	$no = 0;
																	foreach ($offer_product_list as $row) :
																		$no++;
																		$offer_reational_entity_id = $row->entity_id;
																		$product_name = $row->product_name;
																		$product_id = "Product Id :- " . $row->product_id;
																		$product_custom_part_no = $row->product_custom_part_no;
																		$product_custom_description = $row->product_custom_description;
																		/*$product_hsn_code = "Product HSN Code :- ".$row->hsn_code;*/
																		$hsn_id = $row->hsn_id;

																		$product_qty = $row->rfq_qty;
																		$product_price = $row->price;
																		$product_basic_value = $product_qty * $product_price;
																		// $cgst_amount = "CGST :- ".$row->cgst_amt;
																		// $sgst_amount = "SGST :- ".$row->sgst_amt;
																		// $igst_amount = "IGST :- ".$row->igst_amt;
																		$P_Name = $product_id . "\n" . $product_name . "\n";
																	?>
																		<tr>
																			<td style="display: none;" class="offer_relation_entity_id"><?php echo $offer_reational_entity_id; ?></td>
																			<td style="display: none;" class="driver" onchange="save_product_line(this)"></td>
																			<td class="no"><?php echo $no; ?></td>
																			<td>
																				<textarea class="form-control product_name" disabled style="width: 300px;" rows="3"><?php echo $P_Name; ?></textarea>
																			</td>
																			<td>
																				<select class="form-control select2bs4 product_make" id="product_make" name="product_make" placeholder="Enter Product Make" style="width: 100px;" onchange="save_product_line(this)">
																					<option value="">SELECT MAKE</option>
																					<?php
																					foreach ($make_list as $make) : ?>
																						<option value="<?php echo $make->entity_id; ?>" <?php echo ($make->entity_id == $row->product_make) ? 'selected' : ''; ?>><?php echo $make->make_name; ?></option>
																					<?php
																					endforeach;
																					?>
																				</select>
																			</td>
																			<td>
																				<textarea class="form-control product_custom_part_no" name="product_custom_part_no" style="width: 200px;" rows="1" onchange="save_product_line(this)"><?php if ($product_custom_part_no) {
																																																																																																echo $product_custom_part_no;
																																																																																															} else {
																																																																																																echo $row->product_id;
																																																																																															} ?></textarea>
																			</td>
																			<td>
																				<textarea class="form-control product_description" name="product_description" style="width: 150px;" rows="3" placeholder="Enter Product Description" onchange="save_product_line(this)"><?php if ($product_custom_description) {
																																																																																																																	echo $product_custom_description;
																																																																																																																} else {
																																																																																																																	echo $P_Name;
																																																																																																																} ?></textarea>
																			</td>
																			<td>
																				<input type="text" class="form-control product_delivery_period" value="<?php echo $row->delivery_period; ?>" id="product_delivery_period" name="product_delivery_period" placeholder="Enter Delivery Period" style="width: 100px;" onchange="save_product_line(this);">
																			</td>
																			<td>
																				<input type="text" class="form-control product_current_stock" value="<?php echo $row->current_stock; ?>" id="product_current_stock" name="product_current_stock" placeholder="Enter Stock" style="width: 100px;" onchange="save_product_line(this);">
																			</td>
																			<td>
																				<input type="text" class="form-control product_price" value="<?php echo $row->price; ?>" name="product_price" placeholder="Enter Price" style="width: 100px;" onchange="save_product_line(this)">

																			</td>
																			<td>
																				<input type="text" class="form-control product_qty" value="<?php echo $row->rfq_qty; ?>" name="product_qty" placeholder="Enter Qty" style="width: 100px;" onchange="save_product_line(this)">
																			</td>
																			<td>
																				<input type="text" class="form-control product_basic_value" name="product_basic_value" value="<?php echo $product_basic_value; ?>" style="width: 100px;" readonly>
																			</td>
																			<td>
																				<input type="text" class="form-control discount_percentage" value="<?php echo $row->discount; ?>" name="discount_percentage" placeholder="Enter Discount%" style="width: 100px;" onchange="save_product_line(this)">
																			</td>
																			<td>
																				<select class="form-control select2bs4 discount_type" name="discount_type" placeholder="Select discount type" style="width: 100px;" onchange="save_product_line(this)">
																					<option value=1 <?php echo ($row->discount_type == 1) ? 'selected' : ''; ?>>Percentage</option>
																					<option value=2 <?php echo ($row->discount_type == 2) ? 'selected' : ''; ?>>Rupees</option>
																				</select>
																			</td>

																			<td>
																				<input type="text" class="form-control discount_amount" name="discount_amount" placeholder="Enter Discount Amount" value="<?php echo $row->discount_amt; ?>" style="width: 100px;" readonly>
																			</td>
																			<td>
																				<input type="text" class="form-control unit_discounted_rate" name="unit_discounted_rate" style="width: 100px;" value="<?php echo $row->unit_discounted_price; ?>" readonly>
																			</td>
																			<td>
																				<input type="text" class="form-control total_amount_without_gst" name="total_amount_without_gst" value="<?php echo $row->total_amount_without_gst; ?>" style="width: 100px;" readonly>
																			</td>
																			</td>
																			<td>
																				<select class="form-control hsn_id" style="width: 150px;" name="hsn_id" onchange="save_product_line(this)">
																					<option value="">Not Selected</option>
																					<?php foreach ($product_detail_hsn_code as $hsn_row) : ?>
																						<option value="<?php echo $hsn_row->entity_id; ?>" <?php if ($hsn_row->entity_id == $hsn_id) echo ' selected="selected"'; ?>><?php echo $hsn_row->hsn_code; ?></option>
																					<?php endforeach; ?>
																				</select>
																			</td>

																			<td>
																				<input type="text" class="form-control gst_percentage" value="<?php if ($row->gst_percentage == NULL) {
																																																				echo $row->total_gst_percentage;
																																																			} else {
																																																				echo $row->gst_percentage;
																																																			} ?>" name="gst_percentage" placeholder="Enter GST Percentage" style="width: 100px;" onchange="save_product_line(this)">

																			</td>

																			<td>
																				<input type="text" class="form-control gst_amount" value="<?php echo $row->gst_amount; ?>" name="gst_amount" style="width: 100px;" readonly>

																			</td>

																			<td>
																				<input type="text" class="form-control total_amount_with_gst" name="total_amount_with_gst" value="<?php echo $row->total_amount_with_gst; ?>" style="width: 100px;" readonly>
																			</td>
																			<td>
																				<textarea class="form-control product_remark" name="product_remark" style="width: 300px;" rows="3" placeholder="Enter Product Remark" onchange="save_product_line(this)"><?php echo $row->remark; ?></textarea>
																			</td>

																			<td>
																				<textarea class="form-control internal_remark" name="internal_remark" style="width: 300px;" rows="3" placeholder="Enter Product Internal Remark" onchange="save_product_line(this)"> <?php echo $row->internal_remark; ?> </textarea>
																			</td>
																			<td>
																				<a class="btn btn-sm btn-danger" onclick="delete_offer_product(<?php echo $offer_reational_entity_id; ?>)"><i class="fas fa-trash"></i> </a>
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
											<div class="col-sm-6">
												<div class="form-group">
													<label style="color: #FF0000;"> Terms & Condition *</label>
													<textarea name="offer_terms_condition" id="offer_terms_condition" class="form-control" rows="5" placeholder="Enter Terms Conditions" required>Prices and stock are valid till stock last
On Lapp cables Tolerance - ±5 to ±7% must be considered
To check stock, whatsapp on below number 7796962133</textarea>
												</div>
											</div>



											<div class="col-sm-6">
												<div class="form-group">
													<label>Foot Note </label>
													<textarea class="form-control" id="offer_note" name="offer_note" rows="5" placeholder="Enter Note"></textarea>
												</div>
											</div>
										</div>
										
										<div class="row" style="display: none;" >
											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;">Tax *</label>
													<input type="text" class="form-control" id="tax" name="tax" placeholder="Enter Tax">
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;">Validity *</label>
													<input type="text" class="form-control" id="validity" name="validity" placeholder="Enter Validity">
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label> Price Condition</label>
													<select class="form-control select2bs4" style="width: 100%;" id="price_condition" name="price_condition">
														<option value="1">Ex Works IAPL</option>
														<option value="2">FOR Site</option>
														<option value="3">Other- Please refer note</option>
													</select>
												</div>
											</div>

										</div>

										<div class="row">

											<div class="col-sm-4">
												<div class="form-group">
													<label style="color: #FF0000;"> Quotation Close Date *</label>
													<input type="date" name="offer_close_date" id="offer_close_date" class="form-control" size="50" required>
												</div>
											</div>

											<div class="col-sm-4">
												<a class="form-group">
													<label for="offer_attachment">Attachment</label>
													<div class="input-group">
														<div class="custom-file">
															<input type="file" class="custom-file-input" name="offer_attachment[]" multiple id="offer_attachment">
															<label class="custom-file-label" for="offer_attachment">Choose Attachment</label>
														</div>
													</div>
													<div>
													<p>
															<a target="_blank" href="<?php echo base_url(); ?>assets/enquiry_attachment/<?php echo $value; ?>"><?php echo $value; ?></a>
														</p>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label style="color: #FF0000;"> Quotation Status *</label>
														<select class="form-control" style="width: 100%;" id="offer_status" name="offer_status" required>
															<option value="">Not Selected</option>
															<?php foreach ($stage_list as $row): ?>
															<option value="<?= $row->status_value; ?>"><?= $row->status_name; ?></option>
														<?php endforeach; ?>
														</select>
													</div>
												</div>
	
												<div class="col-sm-4" id="Offer_reason_text">
													<div class="form-group">
														<label><span style="color: #FF0000;">Won / Loss Reason *</span></label>
														<select class="form-control" style="width: 100%;" id="offer_reason" name="offer_reason" required>
														<option value="99" active >NA</option>
														<?php foreach ($offer_reason_list as $row): ?>
															<option value="<?= $row->status_value; ?>" ><?= $row->status_name; ?></option>
														<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>



										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Quotation Tracking Details Form</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-3">
														<div class="form-group">
															<label> Quotation Tracking Date </label>
															<input type="date" name="tracking_date" id="tracking_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" size="50">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label style="color: #FF0000;"> Tracking Description * </label>
															<textarea class="form-control" id="tracking_descrption" name="tracking_descrption" rows="3" placeholder="Enter Enquiry Tracking Description"></textarea>
														</div>
													</div>

												</div>

												<div class="row">
													<!-- <div class="col-sm-4">
														<div class="form-group">
																<label style="color: #FF0000;"> Next Action * </label>
																<textarea class="form-control" id="tracking_next_action" name="tracking_next_action" rows="3" placeholder="Enter Tracking Next Action"></textarea>
														</div>
												</div> -->

													<div class="col-sm-3">
														<div class="form-group">
															<label style="color: #FF0000;"> Action Due Date *</label>
															<input type="date" name="action_due_date" id="action_due_date" class="form-control" size="50">
														</div>
													</div>

													<!-- <div class="col-sm-4">
															<div class="form-group">
																	<label > Add Reminder </label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	<input type="hidden"><i style="font-size: 20px;" class="fa fa-bell"></i>
															</div>
													</div> -->
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
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="example12" class="table table-bordered table-striped">
											<tr>
												<th>Tracking Number</th>
												<th>Tracking Date</th>
												<th>Tracking Record</th>
												<!-- <th>Next Action</th> -->
												<th>Action Due Date</th>
												<th>Action Status</th>
												<th>Action Remark</th>
												<th>Action</th>
											</tr>
											<tbody>

												<?php
												foreach ($offer_tracking_details as $tracking_details) {
												?>
													<tr>
														<td><?php echo $tracking_details->tracking_number; ?></td>
														<td><?php echo $tracking_details->tracking_date; ?></td>
														<td><?php echo $tracking_details->tracking_record; ?></td>
														<!-- <td><?php echo $tracking_details->next_action; ?></td> -->
														<td><?php echo $tracking_details->action_due_date; ?></td>
														<td><?php echo ($tracking_details->status == 2 && $tracking_details->action_due_date != "") ? "<p class='bg-warning'>Pening</p>" : ""; ?></td>
														<td><?php echo $tracking_details->remark; ?></td>
														<td>
															<div class="btn-group">
																<a href="<?php echo site_url('update_next_action/' . $tracking_details->entity_id); ?>" class="btn btn-block btn-danger"><i class="fas fa-paper-plane"></i></a>
															</div>
														</td>

													</tr>

												<?php
												} ?>

											</tbody>
										</table>
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
	<div class="modal fade" id="modal-product">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Select product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<div class="modal-body">
							<table id="product_details_table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th></th>
										<th style="display: none;">Entity Id</th>
										<th>Part Code Number</th>
										<th>Product Description</th>
										<th>Product Make</th>
										<th>Product Price</th>
										<th>Unit</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 0;
									foreach ($product_list as $row) :
										$no++;
										$entity_id = $row->entity_id;
										$unit_id = $row->unit;

										$this->db->select('*');
										$this->db->from('unit_master');
										$where = '(unit_master.entity_id = "' . $unit_id . '" )';
										$this->db->where($where);
										$query_data = $this->db->get();
										$query_result = $query_data->row_array();

										if (!empty($query_result)) {
											$unit_name = $query_result['unit_name'];
										} else {
											$unit_name = "NA";
										}
									?>
										<tr id="d1">
											<td><input type="checkbox" class="checkboxes" id="product_checkbox" name="product_checkbox" value="<?php echo $row->entity_id ?>"></td>
											<td style="display: none;"><?php echo $row->entity_id; ?></td>
											<td><?php echo $row->product_id; ?></td>
											<td><?php echo $row->product_name; ?></td>
											<td><?php echo $row->make_name; ?></td>
											<td><?php echo $row->price; ?></td>
											<td><?php echo $unit_name; ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="product_checkbox_submited_new">Save</button>
					</div>
				</div>
			</div>
			<!-- /.modal-dialog -->
		</div>
	</div>

	<div class="modal fade" id="modal-lg-upload-template">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Upload Template</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form role="form" name="template_form" id="template_form" enctype="multipart/form-data">
						<input type="hidden" id="offer_id" name="offer_id" value="<?php echo $offer_id; ?>" required>

						<div class="col-lg-12">
							<input type="file" name="template_file" id="template_file" accept=".csv,.xlsx,.xls"><br>

							<div id="error_message" style="display: none;" class="alert alert-danger"></div>

							<div id="csv_data_table" style="display: none;" class="table-responsive col-lg-12">
								<table class="table table-bordered" id="csv_table">
									<thead>
										<!-- Table headers will be dynamically generated -->
									</thead>
									<tbody>
										<!-- CSV data will be dynamically inserted here -->
									</tbody>
								</table>
							</div>
						</div>

						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button id="check_template" class="btn btn-primary" type="button">Check</button>
							<input id="upload_template" class="btn btn-success" type="button" value="Upload" name="upload_template" disabled>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>




	<div class="modal fade" id="modal-lg-product-add">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Enter Product Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form role="form" name="product_pop_up_form" id="product_pop_up_form" method="post">

						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;">Part Code Number *</label>
									<input type="text" class="form-control" name="pop_up_product_id" id="pop_up_product_id" placeholder="Enter Part Code Number" required>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;">Product Name *</label>
									<input type="text" name="pop_up_product_name" id="pop_up_product_name" class="form-control" placeholder="Enter Product Name" required>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;">HSN Code *</label>
									<select class="form-control select2bs4" name="pop_up_hsn_code" id="pop_up_hsn_code" required>
										<option value="">Select HSN Code</option>
										<?php foreach ($product_detail_hsn_code as $row) : ?>
											<option value="<?php echo $row->entity_id; ?>"><?php echo $row->hsn_code; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;">Product Make *</label>
									<select name="pop_up_product_make" id="pop_up_product_make" class="form-control select2bs4" required="required">
										<option value="">Select Make</option>
										<?php
										foreach ($make_list as $make) { ?>
											<option value="<?php echo $make->entity_id; ?>"><?php echo $make->make_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;">Category *</label>
									<select class="form-control select2bs4" style="width: 100%;" id="pop_up_category_id" name="pop_up_category_id" required>
										<option value="">No Selected</option>
										<?php foreach ($product_category as $row) : ?>
											<option value="<?php echo $row->entity_id; ?>"><?php echo $row->category_name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label style="color: #FF0000;"> Product Long Description *</label>
									<textarea class="form-control" id="pop_up_product_long_desc" name="pop_up_product_long_desc" rows="3" placeholder="Enter Product Long Description" required></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Warranty</label>
									<!-- <input type="text" name="product_warranty" id="product_warranty" class="form-control" placeholder="Enter Product Warranty"> -->
									<select class="form-control select2bs4" style="width: 100%;" id="pop_up_product_warranty" name="pop_up_product_warranty">
										<option value="">Select Product Warranty</option>
										<option value="1 year">1 Year</option>
										<option value="3 year">3 Year</option>
										<option value="5 year">5 Year</option>
									</select>

								</div>
							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label style="color: #FF0000;">Unit *</label>
									<!-- <select class="form-control select2bs4" style="width: 100%;" id="pop_up_product_unit" name="pop_up_product_unit" required>
                                            <option value="">No Selected</option>
                                            <option value="No's">No's</option>
                                            <option value="KG">KG</option>
                                            <option value="Ltr's">Ltr's</option>
                                            <option value="Gram's">Gram's</option>
                                            <option value="Gram's">Mtr</option>
                                        </select> -->
									<select class="form-control select2bs4" style="width: 100%;" id="pop_up_product_unit" name="pop_up_product_unit" required>
										<option value="">No Selected</option>
										<?php foreach ($unit_list as $row) : ?>
											<option value="<?php echo $row->entity_id; ?>"><?php echo $row->unit_name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label style="color: #FF0000;">Selling Price *</label>
									<input type="text" name="pop_up_product_price" id="pop_up_product_price" class="form-control" placeholder="Enter Product Price" required>
								</div>
							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label> Internal Remark </label>
									<textarea class="form-control" id="pop_up_internal_remark" name="pop_up_internal_remark" rows="3" placeholder="Enter Product Long Description"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

					<button type="submit" name="update_new_product" id="update_new_product" class="btn btn-primary">Save</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="modal-mail">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Enter Mail Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form role="form" name="mail_form" id="mail_form" method="post">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label> Mail To</label>
									<input type="text" name="pop_up_mail_to" id="pop_up_mail_to" class="form-control" placeholder="Enter Mail To Id">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label> CC</label>
									<input type="text" name="pop_up_mail_cc" id="pop_up_mail_cc" class="form-control" placeholder="Enter Mail CC Id">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label> BCC</label>
									<input type="text" name="pop_up_mail_bcc" id="pop_up_mail_bcc" class="form-control" placeholder="Enter Mail BCC Id">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

					<button type="submit" name="send_mail" id="send_mail" class="btn btn-primary">Save</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="modal-lg-hsn-add">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Enter HSN Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form role="form" name="hsn_pop_up_form" id="hsn_pop_up_form" method="post">

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label style="color: #FF0000;">HSN Code *</label>
									<input type="text" name="pop_up_new_hsn_code" id="pop_up_new_hsn_code" class="form-control" placeholder="Enter HSN Code">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label style="color: #FF0000;">Total HSN Percentage *</label>
									<input type="text" name="pop_up_new_hsn_percentage" id="pop_up_new_hsn_percentage" class="form-control" placeholder="Enter Total HSN Percentage">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

					<button type="submit" name="add_hsn" id="add_hsn" class="btn btn-primary">Save</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="modal-panel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Swap Company</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Swap Company and Contact Person</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Swap Contact Person</a>
						</li>
					</ul>
					<div class="tab-content" id="custom-content-below-tabContent">
						<div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
							<div class="card-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label> Company Name </label>
											<select class="form-control select2bs4" name="company_name_model" id="company_name_model">
												<option>Select Company</option>
												<?php

												foreach ($customer_list as $company) : ?>
													<option value="<?php echo $company->entity_id; ?>"><?php echo $company->customer_name; ?></option>
												<?php
												endforeach;
												?>
											</select>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label> Company Contact Person</label>
											<select class="form-control select2bs4" name="contact_person_model" id="contact_person_model">
												<option>Select Contact Person</option>
												<?php
												foreach ($customer_contact_list as $contact) : ?>
													<option value="<?php echo $contact->entity_id; ?>"><?php echo $contact->contact_person . ' - ' . $contact->email_id . ' - ' . $contact->first_contact_no; ?></option>
												<?php
												endforeach;
												?>
											</select>
										</div>
									</div>
								</div>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button style="margin-left: 500px;" type="button" class="btn btn-primary" id="select_both_swap">Save</button>
							</div>
						</div>

						<div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
							<div class="card-body">

								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label> Company Name <span style="color: #FF0000;">* Mandatory Field</span></label>
											<input type="text" name="company_name" id="company_name" class="form-control" size="50" placeholder="Enter Company Name" required>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label> Company Type <span style="color: #FF0000;">* Mandatory Field</span></label>
											<select class="form-control select2bs4" style="width: 100%;" id="company_type" name="company_type" required>
												<option value="">No Selected</option>
												<option value="1">Dealer</option>
												<option value="2">End User</option>
												<option value="3">OEM</option>
												<option value="4">Trader</option>
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
													<option value="<?php echo $row->entity_id; ?>"><?php echo $row->state_name; ?></option>
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
											<input type="text" name="customer_pin_code" id="customer_pin_code" class="form-control" size="50" placeholder="Enter Customer Pin Code" required>
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
											<label> Pan Number </label>
											<input type="text" name="customer_pan_number" id="customer_pan_number" class="form-control" size="50" placeholder="Enter Pan Number">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label> Company Contact Person <span style="color: #FF0000;">* Mandatory</span> </label>
											<select class="form-control select2bs4" name="contact_person_model_id" id="contact_person_model_id">
												<option>Select Contact Person</option>
												<?php
												foreach ($customer_contact_list as $contact) : ?>
													<option value="<?php echo $contact->entity_id; ?>"><?php echo $contact->contact_person . ' - ' . $contact->email_id . ' - ' . $contact->first_contact_no; ?></option>
												<?php
												endforeach;
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button style="margin-left: 500px;" type="button" class="btn btn-primary" id="save_new_customer">Save</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="modal-customer-update">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Save & Update Customer</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<p>Do you want to save offer and update Customer ?</p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

					<button type="submit" name="save_offer" id="save_offer" class="btn btn-primary">Save Offer</button>

					<button type="submit" name="save_offer_update_customer" id="save_offer_update_customer" class="btn btn-primary">Save Offer And Update Customer</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
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
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data.min.js"></script> -->
	<script src="<?php echo base_url() . 'assets/plugins/moment-timezone/moment-timezone.js'; ?>"></script>
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
	<!-- DataTables -->
	<script src="<?php echo base_url() . 'assets/plugins/datatables/jquery.dataTables.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js' ?>"></script>
	<!-- Page script -->
	<script type="text/javascript">
		$(document).ready(function() {
			bsCustomFileInput.init();
		});
	</script>

	<script type="text/javascript">
		function save_common_form_elements() {

			var offer_entity_id = document.getElementById('entity_id').value;

			var customer_name = document.getElementById('customer_name').value;
			var contact_id = document.getElementById('contact_id').value;
			var offer_company_name = document.getElementById('offer_company_name').value;

			var enquiry_descrption = document.getElementById('enquiry_descrption').value;
			var employee_id = document.getElementById('employee_id').value;
			var rm_employee_id = document.getElementById('rm_employee_id').value;
			var principle_engg_id = document.getElementById('principle_engg_id').value;
			var offer_for = document.getElementById('offer_for').value;
			var offer_for_info = document.getElementById('offer_for_info').value;
			var offer_date = document.getElementById('offer_date').value;
			var offer_terms_condition = document.getElementById('offer_terms_condition').value;
			var offer_source = document.getElementById('offer_source').value;
			var salutation = document.getElementById('salutation').value;
			var tax = document.getElementById('tax').value;
			var price_condition = document.getElementById('price_condition').value;
			var your_reference = document.getElementById('your_reference').value;
			var validity = document.getElementById('validity').value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/save_common_form_elements'); ?>",
				type: 'POST',
				data: {
					'offer_entity_id': offer_entity_id,
					'enquiry_descrption': enquiry_descrption,
					'employee_id': employee_id,
					'rm_employee_id': rm_employee_id,
					'principle_engg_id': principle_engg_id,
					'offer_for': offer_for,
					'offer_for_info': offer_for_info,
					'offer_date': offer_date,
					'offer_terms_condition': offer_terms_condition,
					'offer_source': offer_source,
					'price_condition': price_condition,
					'salutation': salutation,
					'tax': tax,
					'your_reference': your_reference,
					'customer_name': customer_name,
					'contact_id': contact_id,
					'validity': validity,
					'offer_company_name': offer_company_name
				},
				success: function(data) {
					// data = data.trim();
					// location.reload();
				},
				error: function() {
					// alert("Fail");
					// location.reload();
				}
			});

		}

		$(document).on('click', '#upload_template', function() {
			var offer_id = $('#offer_id').val();

			save_common_form_elements();

			var formData = new FormData();
			formData.append('offer_id', offer_id);
			formData.append('template_file', $('#template_file')[0].files[0]);

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/upload_template'); ?>",
				method: "POST",
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function(response) {
					if (response.success) {

						// Redirect to success page or do any other necessary action
						window.location.reload();
						// window.location.href = response.redirect_url;
					} else {
						$('#error_message').html(response.error);
						$('#error_message').show();
						$('#modal-lg-upload-template').modal('show'); // Show the modal
						$('.modal-footer').append('<button type="button" class="btn btn-primary" onclick="goBack()">Go Back</button>');
						$('#upload_template').prop('disabled', true);
					}
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}

			});
		});

		function goBack() {
			window.location.href = "<?php echo base_url() . 'update_offer_data/' . $offer_id; ?>";
		}
	</script>

	<script>
		$(document).on('click', '#check_template', function() {
			var formData = new FormData();
			formData.append('template_file', $('#template_file')[0].files[0]);
			// formData.append('offer_id', $('#offer_id').val());

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/checkIncompleteFields'); ?>",
				method: "POST",
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function(response) {
					console.log(response);
					if (response.success) {
						$('#error_message').hide();
						displayCsvData(response.csv_data, response.header, response.incomplete_fields);
						$('#upload_template').prop('disabled', response.incomplete_fields.length > 0);
					} else {
						$('#error_message').html(response.error);
						$('#error_message').show();
						$('#upload_template').prop('disabled', true);
					}
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		});

		function displayCsvData(csvData, header, incompleteFields) {
			// Clear previous data
			$('#csv_table thead').empty();
			$('#csv_table tbody').empty();

			// Generate table headers
			var headerRow = '<tr>';
			$.each(header, function(index, value) {
				headerRow += '<th>' + value + '</th>';
			});
			headerRow += '</tr>';
			$('#csv_table thead').append(headerRow);

			// Display CSV data rows
			$.each(csvData, function(index, row) {
				var dataRow = '<tr>';
				var isIncompleteRow = false;
				$.each(row, function(cellIndex, value) {
					var columnName = header[cellIndex];
					var isIncomplete = incompleteFields.some(field => field.erp_code === row[2] && field.incomplete_fields.includes(columnName));
					if ((cellIndex === 0 || cellIndex === 4 || cellIndex === 6 || cellIndex === 8 || cellIndex === 9 || cellIndex === 10 || cellIndex === 11 || cellIndex === 13) && (value === null || value === '')) {
						dataRow += '<td></td>';
					} else {
						if (value === null || value === '') {
							dataRow += '<td><span style="color: red;">Data missing</span></td>';
							isIncompleteRow = true;
						} else {
							dataRow += '<td>' + value + '</td>';
						}
					}
				});
				dataRow += '</tr>';
				if (isIncompleteRow) {
					$('#csv_table tbody').append(dataRow);
				} else {
					$('#csv_table tbody').append(dataRow);
				}
			});

			// Show the table
			$('#csv_data_table').show();
		}
	</script>


	<script type="text/javascript">
		$(document).ready(function() {
			//call function get data edit
			get_data_edit();

			// update_product_description();

			//load data for edit
			function get_data_edit() {
				var entity_id = $('[name="entity_id"]').val();
				// alert(entity_id);

				$.ajax({
					url: "<?php echo site_url('sales/offer_register/get_offer_details_by_offer_id'); ?>",
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
								$('[name="offer_number"]').val(data[i].offer_no);
							$('[name="offer_status"]').val(data[i].status).trigger('change');
							$('[name="enquiry_number"]').val(data[i].enquiry_no);

							$('[name="customer_name"]').val(data[i].customer_id);
							$('[name="contact_id"]').val(data[i].contact_person_id).trigger('change');

							$('[name="customer_view_name"]').val(data[i].customer_name);
							$('[name="contact_person_view_name"]').val(data[i].contact_person);
							$('[name="offer_company_name"]').val(data[i].offer_company_name);

							$('[name="employee_id"]').val(data[i].offer_engg_name).trigger('change');
							$('[name="rm_employee_id"]').val(data[i].offer_rm_employee_id).trigger('change');
							$('[name="principle_engg_id"]').val(data[i].offer_principle_engg_id).trigger('change');
							$('[name="enquiry_descrption"]').val(data[i].offer_description);
							$('[name="offer_for"]').val(data[i].offer_for).trigger('change');
							$('[name="offer_for_info"]').val(data[i].offer_for_info).trigger('change');
							$('[name="offer_source"]').val(data[i].offer_source).trigger('change');
							$('[name="offer_date"]').val(data[i].offer_date);
							$('[name="price_condition"]').val(data[i].price_condition).trigger('change');

							$('[name="tax"]').val(data[i].tax);
							$('[name="validity"]').val(data[i].validity);
							$('[name="salutation"]').val(data[i].salutation);
							$('[name="your_reference"]').val(data[i].your_reference);
							$('[name="offer_close_date"]').val(data[i].offer_close_date);
							$('[name="offer_reason"]').val(data[i].reason_for_rejection);
							$('[name="offer_note"]').val(data[i].note);
							$('[name="offer_terms_condition"]').val(data[i].terms_conditions);
							$('[name="contact_person_model"]').val(data[i].contact_person_id).trigger('change');
							$('[name="contact_person_model_id"]').val(data[i].contact_person_id).trigger('change');
							$('[name="company_name_model"]').val(data[i].customer_id).trigger('change');
						});
					}
				});
			}

			function update_product_description() {
				$('#driverbody tr td .driver').each(function() {
					$(this).val() == '1';
				});
			}

			$('#customer_name').change(function() {
				var id = $(this).val();
				var contact_person_id = "<?php echo $contact_person_id; ?>";

				$.ajax({
					url: "<?php echo site_url('master/customer_master/get_contact_person'); ?>",
					method: "POST",
					data: {
						id: id
					},
					async: true,
					dataType: 'json',

					success: function(response) {

						// Remove options 
						$('#contact_id').find('option').not(':first').remove();

						// Add options
						$.each(response, function(index, data) {
							if (contact_person_id == data.entity_id) {
								$('#contact_id').append('<option value="' + data['entity_id'] + '" selected>' + data['contact_person'] + '</option>').trigger('change');

							} else {
								$('#contact_id').append('<option value="' + data['entity_id'] + '">' + data['contact_person'] + '</option>');

							}
						});
					}

				});
				return false;
			});

			//change contact person
			$('#contact_id').change(function() {

				var contact_id = $(this).val();
				var entity_id = $('[name="entity_id"]').val();


				$.ajax({
					url: "<?php echo site_url('sales/offer_register/update_contact_person_in_offer'); ?>",
					method: "POST",
					data: {
						offer_id: entity_id,
						contact_id: contact_id
					},
					async: true,
					dataType: 'json',

					success: function(response) {

						// window.location.reload();

					}

				});

			});

		});
	</script>

	<script type="text/javascript">
		// function showOfferStatus(status) {
		// 	document.getElementById('Offer_reason_text').style.display = "block";

		// }

		// function hideOfferStatus(status) {
		// 	$('#Offer_reason_text').hide();

		// }
	</script>

	<script type="text/javascript">
		// $(document).ready(function() {

		// 	$('#offer_status').change(function() {
		// 		var offer_status = $(this).val();
		// 		// alert(11);
		// 		var today_zone = moment().tz('Asia/Kolkata').format("YYYY-MM-DD");
		// 		if (offer_status == 4 || offer_status == 7) {
		// 			$('#Offer_reason_text').show();
		// 		} else {

		// 			$('#Offer_reason_text').hide();
		// 		}

		// 		//handle cose date

		// 		if (offer_status == 4 || offer_status == 6 || offer_status == 7) {
		// 			var today_zone = moment().tz('Asia/Kolkata').format("YYYY-MM-DD");
		// 			document.getElementById('offer_close_date').value = today_zone;

		// 			console.log(today_zone);
		// 		}



		// 	});
		// });
	</script>

	<script type="text/javascript">
		$(document).on('click', '#add_hsn', function() {

			var offer_entity_id = document.getElementById('entity_id').value;

			var customer_name = document.getElementById('customer_name').value;
			var contact_id = document.getElementById('contact_id').value;
			var offer_company_name = document.getElementById('offer_company_name').value;

			var enquiry_descrption = document.getElementById('enquiry_descrption').value;
			var employee_id = document.getElementById('employee_id').value;
			var offer_for = document.getElementById('offer_for').value;
			var offer_date = document.getElementById('offer_date').value;
			var offer_terms_condition = document.getElementById('offer_terms_condition').value;
			var offer_source = document.getElementById('offer_source').value;
			var salutation = document.getElementById('salutation').value;
			var tax = document.getElementById('tax').value;
			var price_condition = document.getElementById('price_condition').value;
			var your_reference = document.getElementById('your_reference').value;
			var validity = document.getElementById('validity').value;
			var offer_note = document.getElementById('offer_note').value;

			var hsn_code = document.getElementById('pop_up_new_hsn_code').value;
			var hsn_percentage = document.getElementById('pop_up_new_hsn_percentage').value;

			if (hsn_code != "" && hsn_percentage != "") {
				$.ajax({
					url: "<?php echo site_url('sales/offer_register/add_hsn_data'); ?>",
					type: 'POST',
					data: {
						'hsn_code': hsn_code,
						'hsn_percentage': hsn_percentage,
						'offer_entity_id': offer_entity_id,
						'enquiry_descrption': enquiry_descrption,
						'employee_id': employee_id,
						'offer_for': offer_for,
						'offer_date': offer_date,
						'offer_terms_condition': offer_terms_condition,
						'offer_source': offer_source,
						'price_condition': price_condition,
						'salutation': salutation,
						'tax': tax,
						'your_reference': your_reference,
						'customer_name': customer_name,
						'contact_id': contact_id,
						'validity': validity,
						'offer_note': offer_note,
						'offer_company_name': offer_company_name
					},
					success: function(data) {
						data = data.trim();
						location.reload();
					},
					error: function() {
						alert("Fail");
						location.reload();
					}
				});
			} else {
				alert("Enter Proper Details.............");
			}
		});
	</script>

	<script type="text/javascript">
		//load data for edit
		$('#contact_id').change(function() {
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
							$('[name="enquiry_contact_person"]').val(data[i].contact_person);
						$('[name="enquiry_email_id"]').val(data[i].email_id);
						$('[name="enquiry_contact_number"]').val(data[i].first_contact_no);
						$('[name="enquiry_customer_state"]').val(data[i].state_name);
						$('[name="enquiry_customer_city"]').val(data[i].city_name);
						$('[name="pop_up_mail_to"]').val(data[i].email_id);
					})
				}
			});
			return false;
		});
	</script>

	<script type="text/javascript">
		function showFreight() {
			document.getElementById('Freight_charges_form').style.display = "block";
		}

		function hideFreight() {
			$('#Freight_charges_form').hide();
		}

		function showPackFor() {
			document.getElementById('Packing_forwarding_form').style.display = "block";
		}

		function hidePackFor() {
			$('#Packing_forwarding_form').hide();
		}

		function showInsurance() {
			document.getElementById('Insurance_form').style.display = "block";
		}

		function hideInsurance() {
			$('#Insurance_form').hide();
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

	<script type="text/javascript">
		$('#enquiry_email_id').change(function() {
			var id = $(this).val();

			$("#pop_up_mail_to").val(id);

		});
	</script>

	<script>
		$(function() {
			$("#example1").DataTable();
			$('#example2').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false,
			});
		});
	</script>

	<!-- <script>
            $(document).ready( function () {
                
                $('#product_details_table').DataTable();
                
            } );
        </script> -->

	<script>
		var table = $('#product_details_table').dataTable({
			"pageLength": 10
		});

		$(function() {
			$("#product_checkbox_submited_new").on('click', function(event) {
				$("#product_checkbox_submited_new").attr("disabled", true);

				var entity_id = document.getElementById('entity_id').value;

				var customer_name = document.getElementById('customer_name').value;
				var contact_id = document.getElementById('contact_id').value;
				var offer_company_name = document.getElementById('offer_company_name').value;

				var enquiry_descrption = document.getElementById('enquiry_descrption').value;
				var employee_id = document.getElementById('employee_id').value;
				var offer_for = document.getElementById('offer_for').value;
				var offer_date = document.getElementById('offer_date').value;
				var offer_terms_condition = document.getElementById('offer_terms_condition').value;
				var offer_source = document.getElementById('offer_source').value;
				var salutation = document.getElementById('salutation').value;
				var tax = document.getElementById('tax').value;
				var price_condition = document.getElementById('price_condition').value;
				var your_reference = document.getElementById('your_reference').value;
				var validity = document.getElementById('validity').value;
				var offer_note = document.getElementById('offer_note').value;

				var product_checkbox = table.$('input[type="checkbox"]').serializeArray();

				if (customer_name != "" && contact_id != "" && product_checkbox != "") {

					$.ajax({
						url: "<?php echo site_url('sales/offer_register/update_offer_thru_ajax'); ?>",
						type: 'POST',
						data: {
							'entity_id': entity_id,
							'product_checkbox': product_checkbox,
							'enquiry_descrption': enquiry_descrption,
							'employee_id': employee_id,
							'offer_for': offer_for,
							'offer_date': offer_date,
							'offer_terms_condition': offer_terms_condition,
							'offer_source': offer_source,
							'price_condition': price_condition,
							'salutation': salutation,
							'tax': tax,
							'your_reference': your_reference,
							'customer_name': customer_name,
							'contact_id': contact_id,
							'validity': validity,
							'offer_note': offer_note,
							'offer_company_name': offer_company_name
						},
						success: function(data) {
							location.reload();
						},
						error: function() {
							alert("Fail")
						}
					});
				} else {
					alert("Enter All Details");
				}
			});
		});
	</script>

	<script type="text/javascript">
		function save_product_line(item) {


			// 
			var currentrow = $(item).closest('tr');
			var offer_relation_entity_id = currentrow.find('.offer_relation_entity_id').text();
			// var product_description = currentrow.find("td:eq(1) textarea").text();
			var product_make = currentrow.find('.product_make').val();
			var product_description = currentrow.find('.product_description').val();
			var product_custom_part_no = currentrow.find('.product_custom_part_no').val();
			var product_price = currentrow.find('.product_price').val();
			var product_delivery_period = currentrow.find('.product_delivery_period').val();
			var product_current_stock = currentrow.find('.product_current_stock').val();
			var product_qty = currentrow.find('.product_qty').val();

			var product_basic_value = product_price * product_qty;
			currentrow.find('[name="product_basic_value"]').val(product_basic_value);

			var discount_percentage = currentrow.find('.discount_percentage').val();
			var discount_type = currentrow.find('.discount_type').val();
			var discount_amount = '';
			var unit_discounted_rate = '';
			if (discount_type == "" || discount_type == 2) {
				discount_amount = discount_percentage;
				unit_discounted_rate = product_price - discount_percentage;
			} else {
				discount_amount = product_price * discount_percentage / 100;
				unit_discounted_rate = product_price * (1 - discount_percentage / 100);
			}
			currentrow.find('[name="discount_amount"]').val(discount_amount);
			// var discount_amount = currentrow.find('.discount_amt').text();
			// var unit_discounted_rate = product_price - discount_amount;
			currentrow.find('[name="unit_discounted_rate"]').val(unit_discounted_rate);

			var total_amount_without_gst = unit_discounted_rate * product_qty;
			currentrow.find('[name="total_amount_without_gst"]').val(total_amount_without_gst);

			var hsn_id = currentrow.find('.hsn_id').val();
			var gst_percentage = currentrow.find('.gst_percentage').val();


			var gst_amount = total_amount_without_gst * gst_percentage / 100;
			currentrow.find('[name="gst_amount"]').val(gst_amount);


			var total_amount_with_gst = total_amount_without_gst + gst_amount;
			currentrow.find('[name="total_amount_with_gst"]').val(total_amount_with_gst);

			var product_remark = currentrow.find('.product_remark').val();
			var internal_remark = currentrow.find('.internal_remark').val();

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_line'); ?>",
				method: "POST",
				data: {
					'offer_relation_entity_id': offer_relation_entity_id,
					'product_make': product_make,
					'product_custom_part_no': product_custom_part_no,
					'product_description': product_description,
					'product_delivery_period': product_delivery_period,
					'product_current_stock': product_current_stock,
					'product_price': product_price,
					'product_qty': product_qty,
					'discount_percentage': discount_percentage,
					'discount_type': discount_type,
					'discount_amount': discount_amount,
					'unit_discounted_rate': unit_discounted_rate,
					'total_amount_without_gst': total_amount_without_gst,
					'hsn_id': hsn_id,
					'gst_percentage': gst_percentage,
					'gst_amount': gst_amount,
					'total_amount_with_gst': total_amount_with_gst,
					'product_remark': product_remark,
					'internal_remark': internal_remark
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;

		}


		function change_ProductDescription(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var product_desc = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_description'); ?>",
				method: "POST",
				data: {
					'product_desc': product_desc,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;
		}

		function change_ProductMake(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var product_make = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_make'); ?>",
				method: "POST",
				data: {
					'product_make': product_make,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;
		}

		function change_DeliveryPeriod(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var delivery_period = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_delivery_period'); ?>",
				method: "POST",
				data: {
					'delivery_period': delivery_period,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;
		}

		function change_Warranty(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var warranty = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_warranty'); ?>",
				method: "POST",
				data: {
					'warranty': warranty,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;
		}

		function change_Price(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var price = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_price'); ?>",
				method: "POST",
				data: {
					'price': price,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_ProductQty(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var product_qty = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_qty'); ?>",
				method: "POST",
				data: {
					'product_qty': product_qty,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_ProductDisPercentage(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var discount_percentage = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_discount_percentage'); ?>",
				method: "POST",
				data: {
					'discount_percentage': discount_percentage,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_ProductDisAmount(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var discount_amount = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_discount_amount'); ?>",
				method: "POST",
				data: {
					'discount_amount': discount_amount,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_hsn(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var hsn_id = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_hsn_id'); ?>",
				method: "POST",
				data: {
					'hsn_id': hsn_id,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					location.reload();
				}
			});
			return false;
		}

		function change_Productremark(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var product_remark = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_remark'); ?>",
				method: "POST",
				data: {
					'product_remark': product_remark,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;
		}

		function change_ProductInternalremark(item) {
			var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
			var internal_remark = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_product_internalremark'); ?>",
				method: "POST",
				data: {
					'internal_remark': internal_remark,
					'offer_relation_entity_id': offer_relation_entity_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;
		}

		function delete_offer_product(d) {
			var id = d;
			$.ajax({
				url: "<?php echo site_url('sales/offer_register/delete_offer_product'); ?>",
				type: "POST",
				data: {
					'id': id
				},
				success: function(data) {
					location.reload();
				},
				error: function(data) {
					alert("Failed!!");
				}
			});
		}
	</script>

	<!-- <script type="text/javascript">
            $(document).ready(function(){
                $('#product_id').change(function(){ 
                    var id=$(this).val();
                    $.ajax({
                        url : "<?php echo site_url('master/product_master/product_id_check'); ?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success : function(data) {
                                //
                                //location.reload();
                            },
                            error : function(data) {
                                alert("Product Id Already Exist");
                                $("#product_id").val('');
                            }
                        });
                    return false;
                });
            });
        </script> -->

	<script type="text/javascript">
		$(document).on('click', '#update_new_product', function() {

			var offer_entity_id = document.getElementById('entity_id').value;
			var customer_name = document.getElementById('customer_name').value;
			var contact_id = document.getElementById('contact_id').value;
			var offer_company_name = document.getElementById('offer_company_name').value;

			var enquiry_descrption = document.getElementById('enquiry_descrption').value;
			var employee_id = document.getElementById('employee_id').value;
			var offer_for = document.getElementById('offer_for').value;
			var offer_date = document.getElementById('offer_date').value;
			var offer_terms_condition = document.getElementById('offer_terms_condition').value;
			var offer_source = document.getElementById('offer_source').value;
			var salutation = document.getElementById('salutation').value;
			var price_basis = document.getElementById('price_basis').value;
			var tax = document.getElementById('tax').value;
			var price_condition = document.getElementById('price_condition').value;
			var your_reference = document.getElementById('your_reference').value;
			var validity = document.getElementById('validity').value;
			var offer_note = document.getElementById('offer_note').value;

			var product_id = $("#pop_up_product_id").val();
			var product_name = $("#pop_up_product_name").val();
			var hsn_code = $("#pop_up_hsn_code").val();
			var product_make = $("#pop_up_product_make").val();
			var category_id = $("#pop_up_category_id").val();
			var product_long_desc = $("#pop_up_product_long_desc").val();
			var product_warranty = $("#pop_up_product_warranty").val();
			var product_unit = $("#pop_up_product_unit").val();
			var product_price = $("#pop_up_product_price").val();
			var internal_remark = $("#pop_up_internal_remark").val();

			if (offer_entity_id != "" && customer_name != "" && contact_id != "" && product_id != "" && product_name != "" && product_long_desc != "" && hsn_code != "" && product_make != "" && category_id != "" && product_unit != "" && product_price != "") {
				$.ajax({
					url: "<?php echo site_url('sales/offer_register/update_new_product_with_offer'); ?>",
					type: "POST",
					data: {
						'offer_entity_id': offer_entity_id,
						'enquiry_descrption': enquiry_descrption,
						'employee_id': employee_id,
						'offer_for': offer_for,
						'offer_date': offer_date,
						'offer_terms_condition': offer_terms_condition,
						'offer_source': offer_source,
						'price_condition': price_condition,
						'salutation': salutation,
						'tax': tax,
						'your_reference': your_reference,
						'customer_name': customer_name,
						'contact_id': contact_id,
						'validity': validity,
						'offer_note': offer_note,
						'product_id': product_id,
						'product_name': product_name,
						'hsn_code': hsn_code,
						'product_make': product_make,
						'category_id': category_id,
						'product_long_desc': product_long_desc,
						'product_warranty': product_warranty,
						'product_unit': product_unit,
						'product_price': product_price,
						'internal_remark': internal_remark,
						'offer_company_name': offer_company_name
					},
					success: function(data) {
						location.reload();
					},
					error: function(data) {
						alert("Product Already Exist");
					}
				});
			} else {
				alert("Enter All Details");
			}
		});
	</script>

	<script>
		$(function() {
			$("#send_mail").on('click', function(event) {
				var offer_entity_id = document.getElementById('entity_id').value;

				var enquiry_descrption = document.getElementById('enquiry_descrption').value;
				var employee_id = document.getElementById('employee_id').value;
				var salutation = document.getElementById('salutation').value;

				var offer_for = document.getElementById('offer_for').value;
				var offer_date = document.getElementById('offer_date').value;
				var offer_terms_condition = document.getElementById('offer_terms_condition').value;
				var offer_source = document.getElementById('offer_source').value;
				var tax = document.getElementById('tax').value;
				var price_condition = document.getElementById('price_condition').value;
				var your_reference = document.getElementById('your_reference').value;
				var validity = document.getElementById('validity').value;

				var offer_note = document.getElementById('offer_note').value;
				var offer_close_date = document.getElementById('offer_close_date').value;

				var mail_to = document.getElementById('pop_up_mail_to').value;
				var mail_cc = document.getElementById('pop_up_mail_cc').value;
				var mail_bcc = document.getElementById('pop_up_mail_bcc').value;

				if (offer_entity_id != "" && enquiry_descrption != "" && employee_id != "" && salutation != "" && offer_for != "" && offer_date != "" && tax != "" && mail_to != "" && mail_cc != "" && mail_bcc != "") {

					$.ajax({
						url: "<?php echo site_url('sales/offer_register/save_offer_send_mail'); ?>",
						type: 'POST',
						data: {
							'offer_entity_id': offer_entity_id,
							'enquiry_descrption': enquiry_descrption,
							'employee_id': employee_id,
							'salutation': salutation,
							'offer_for': offer_for,
							'offer_date': offer_date,
							'offer_terms_condition': offer_terms_condition,
							'offer_source': offer_source,
							'tax': tax,
							'price_condition': price_condition,
							'your_reference': your_reference,
							'validity': validity,
							'offer_note': offer_note,
							'mail_to': mail_to,
							'mail_cc': mail_cc,
							'mail_bcc': mail_bcc,
							'offer_close_date': offer_close_date
						},
						success: function(data) {
							window.location.href = data;
						},
						error: function() {
							alert("Fail")
						}
					});
				} else {
					alert("Enter All Details");
				}
			});
		});
	</script>

	<script type="text/javascript">
		function change_contact_person(item) {
			var customer_id = document.getElementById('customer_id').value;
			var enquiry_contact_person = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_contact_person'); ?>",
				method: "POST",
				data: {
					'enquiry_contact_person': enquiry_contact_person,
					'customer_id': customer_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;
		}

		function change_email_id(item) {
			var customer_id = document.getElementById('customer_id').value;
			var enquiry_email_id = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_email_id'); ?>",
				method: "POST",
				data: {
					'enquiry_email_id': enquiry_email_id,
					'customer_id': customer_id
				},
				async: true,
				dataType: 'json',
				success: function(data) {
					//location.reload();
				}
			});
			return false;
		}

		function change_contact_no(item) {
			var customer_id = document.getElementById('customer_id').value;
			var enquiry_contact_number = item.value;

			$.ajax({
				url: "<?php echo site_url('sales/offer_register/update_contact_no'); ?>",
				method: "POST",
				data: {
					'enquiry_contact_number': enquiry_contact_number,
					'customer_id': customer_id
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

		$('#select_both_swap').click(function() {
			$('#select_both_swap').attr('disabled');
			var customer_id = $('#company_name_model').val();
			var contact_person = $('#contact_person_model').val();

			$.ajax({
				url: "<?php echo site_url('master/customer_master/swap_company'); ?>",
				type: "POST",
				data: {
					'customer_id': customer_id,
					'contact_person': contact_person
				},
				dataType: 'json',
				async: true,
				success: function(data) {
					//$('#modal-panel').fadeOut();       
					window.location.reload();
				}
			});


		});
	</script>

	<script type="text/javascript">
		$('#save_new_customer').click(function() {
			var enquiry_id = $('#enquiry_id').val();
			var cont_id = $('#contact_person_model_id').val();
			var customer_name = $('#company_name').val();
			var customer_type = $('#company_type').val();
			var address = $('#address').val();
			var state_id = $('#state_id').val();
			var city_id = $('#city_id').val();
			var state_code = $('#state_code').val();
			var customer_pin_code = $('#customer_pin_code').val();
			var customer_gst_number = $('#customer_gst_number').val();
			var customer_pan_number = $('#customer_pan_number').val();
			$.ajax({
				url: '<?php echo site_url(); ?>master/customer_master/save_india_mart_customer',
				method: 'POST',
				data: {
					'enquiry_id': enquiry_id,
					'contact_person_id': cont_id,
					'customer_name': customer_name,
					'customer_type': customer_type,
					'address': address,
					'state_id': state_id,
					'city_id': city_id,
					'state_code': state_code,
					'customer_pin_code': customer_pin_code,
					'customer_gst_number': customer_gst_number,
					'customer_pan_number': customer_pan_number
				},
				dataType: 'json',
				success: function(d) {
					window.location.reload();
				}
			});
		});
	</script>

	<script type="text/javascript">
		$(function() {
			$("#save_offer").on('click', function(event) {
				$("#save_offer").attr("disabled", true);

				var offer_entity_id = document.getElementById('entity_id').value;

				var customer_name = document.getElementById('customer_name').value;
				var contact_id = document.getElementById('contact_id').value;

				var offer_company_name = document.getElementById('offer_company_name').value;
				var enquiry_descrption = document.getElementById('enquiry_descrption').value;
				var employee_id = document.getElementById('employee_id').value;
				var offer_for = document.getElementById('offer_for').value;
				var offer_date = document.getElementById('offer_date').value;
				var offer_source = document.getElementById('offer_source').value;
				var dispatch_address = document.getElementById('dispatch_address').value;
				var delivery_instruction = document.getElementById('delivery_instruction').value;
				var special_instruction = document.getElementById('special_instruction').value;
				var salutation = document.getElementById('salutation').value;
				var price_basis = document.getElementById('price_basis').value;
				var transport_insurance = document.getElementById('transport_insurance').value;
				var tax = document.getElementById('tax').value;
				var delivery_schedule = document.getElementById('delivery_schedule').value;
				var mode_of_payment = document.getElementById('mode_of_payment').value;
				var payment_term = document.getElementById('payment_term').value;
				var packing_forwarding = document.getElementById('packing_forwarding').value;
				var price_condition = document.getElementById('price_condition').value;
				var your_reference = document.getElementById('your_reference').value;
				var validity = document.getElementById('validity').value;
				var guarantee_warrenty = document.getElementById('guarantee_warrenty').value;
				var offer_note = document.getElementById('offer_note').value;
				var offer_close_date = document.getElementById('offer_close_date').value;

				if (customer_name != "" && contact_id != "") {

					$.ajax({
						url: "<?php echo site_url('sales/offer_register/save_offer'); ?>",
						type: 'POST',
						data: {
							'offer_entity_id': offer_entity_id,
							'enquiry_descrption': enquiry_descrption,
							'employee_id': employee_id,
							'offer_for': offer_for,
							'offer_date': offer_date,
							'offer_source': offer_source,
							'dispatch_address': dispatch_address,
							'delivery_instruction': delivery_instruction,
							'packing_forwarding': packing_forwarding,
							'payment_term': payment_term,
							'special_instruction': special_instruction,
							'price_condition': price_condition,
							'salutation': salutation,
							'price_basis': price_basis,
							'transport_insurance': transport_insurance,
							'tax': tax,
							'delivery_schedule': delivery_schedule,
							'mode_of_payment': mode_of_payment,
							'your_reference': your_reference,
							'customer_name': customer_name,
							'contact_id': contact_id,
							'validity': validity,
							'guarantee_warrenty': guarantee_warrenty,
							'offer_company_name': offer_company_name,
							'offer_note': offer_note,
							'offer_close_date': offer_close_date
						},
						success: function(data) {
							window.location.href = data;
						},
						error: function() {
							alert("Fail")
						}
					});
				} else {
					alert("Enter All Details");
				}
			});

			$("#save_offer_update_customer").on('click', function(event) {
				$("#save_offer_update_customer").attr("disabled", true);

				var offer_entity_id = document.getElementById('entity_id').value;

				var customer_name = document.getElementById('customer_name').value;
				var contact_id = document.getElementById('contact_id').value;

				var offer_company_name = document.getElementById('offer_company_name').value;
				var enquiry_descrption = document.getElementById('enquiry_descrption').value;
				var employee_id = document.getElementById('employee_id').value;
				var offer_for = document.getElementById('offer_for').value;
				var offer_date = document.getElementById('offer_date').value;
				var offer_source = document.getElementById('offer_source').value;
				var salutation = document.getElementById('salutation').value;
				var tax = document.getElementById('tax').value;
				var price_condition = document.getElementById('price_condition').value;
				var your_reference = document.getElementById('your_reference').value;
				var validity = document.getElementById('validity').value;
				var offer_note = document.getElementById('offer_note').value;
				var offer_close_date = document.getElementById('offer_close_date').value;

				if (customer_name != "" && contact_id != "") {

					$.ajax({
						url: "<?php echo site_url('sales/offer_register/save_offer_with_update_company'); ?>",
						type: 'POST',
						data: {
							'offer_entity_id': offer_entity_id,
							'enquiry_descrption': enquiry_descrption,
							'employee_id': employee_id,
							'offer_for': offer_for,
							'offer_date': offer_date,
							'offer_source': offer_source,
							'price_condition': price_condition,
							'salutation': salutation,
							'tax': tax,
							'your_reference': your_reference,
							'customer_name': customer_name,
							'contact_id': contact_id,
							'validity': validity,
							'offer_company_name': offer_company_name,
							'offer_note': offer_note,
							'offer_close_date': offer_close_date
						},
						success: function(data) {
							window.location.href = data;
						},
						error: function() {
							alert("Fail")
						}
					});
				} else {
					alert("Enter All Details");
				}
			});
		});
	</script>
</body>

</html>
