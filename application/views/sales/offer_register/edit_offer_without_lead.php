<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
   header("location:welcome");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit Quotation</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Data Tables -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css'?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/fontawesome-free/css/all.min.css'?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.css'?>">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'?>">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'?>">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'?>">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/select2/css/select2.min.css'?>">
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'?>">
        <!-- Bootstrap4 Duallistbox -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/adminlte.min.css'?>">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php 
                $this->load->view('header_sidebar');

                $this->db->select('offer_register.*');
                $this->db->from('offer_register');
                $this->db->where('entity_id', $entity_id);
                $query = $this->db->get();
                $query_result = $query->row_array();

                $customer_id = $query_result['customer_id'];
                $contact_person_id = $query_result['contact_person_id'];

            ?> 
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Edit Quotation</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_offer_data'?>">Quotation Register</a></li>
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
                                            <h3 class="card-title">Quotation Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="offer_form" enctype="multipart/form-data" action="<?php echo site_url('sales/offer_register/offer_without_lead_data_save');?>" method="post">
                                                
                                                <input type="hidden" id="enquiry_entity_id" name="enquiry_entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Quotation Number </label>
                                                            <input type="text" name="offer_number" id="offer_number" class="form-control"  size="50" placeholder="Enter Quotation Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Customer Name </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="customer_name" name="customer_name" >
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($customer_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Contact Person *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="contact_id" name="contact_id" required>
                                                            <option value="">Select Contact Person</option>
                                                            </select>
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
                                                                            <input type="text" name="enquiry_contact_person" id="enquiry_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="enquiry_email_id" id="enquiry_email_id" class="form-control" readonly size="50" placeholder="Customer Email Id">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="enquiry_contact_number" id="enquiry_contact_number" class="form-control" readonly size="50" placeholder="Customer Contact Number">
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
                                                            <label style="color: #FF0000;"> Select Sales Engineer Name *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="employee_id" name="employee_id" required>
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($employee_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->Emp_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
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
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Quotation Type *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="offer_type" name="offer_type" required>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Budgatory</option>
                                                                <option value="2">One Time Offer</option>
                                                                <option value="3">Rate Contract</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Quotation Date *</label>
                                                            <input type="date" name="offer_date" id="offer_date" class="form-control" size="50" required>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Freight </label>
                                                            <select class="form-control" style="width: 100%;" id="offer_freight" name="offer_freight">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hideFreight()">Customer Scope</option>
                                                                <option value="2" onClick="showFreight()">Company Scope</option>
                                                            </select>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <!-- Take Freight changes in Price basic column -->
                                                            <label style="color: #FF0000;"> Freight *</label>
                                                            <input type="text" name="price_basis" id="price_basis" class="form-control" size="50" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Transportation & Insurance *</label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="transport_insurance" name="transport_insurance" rows="3" placeholder="Enter Transportation & Insurance"></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-sm-3" id="Freight_charges_form" style="display: none">
                                                        <div class="form-group">
                                                            <label> Freight Charges <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <input type="text" name="freight_charges" id="freight_charges" class="form-control" placeholder="Enter Freight Charges" size="50">
                                                        </div>
                                                    </div>  -->
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Tax *</label>
                                                            <textarea class="form-control" id="tax" name="tax" rows="3" placeholder="Enter Tax"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Delivery Schedule *</label>
                                                            <textarea class="form-control" id="delivery_schedule" name="delivery_schedule" rows="3" placeholder="Enter Delivery Schedule"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Mode of Payment *</label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="mode_of_payment" name="mode_of_payment" rows="3" placeholder="Enter Mode Of Payment"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Validity *</label>
                                                            <textarea class="form-control" id="validity" name="validity" rows="3" placeholder="Enter Validity"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label > Dispatch Address </label>
                                                            <textarea class="form-control" id="dispatch_address" name="dispatch_address" rows="3" placeholder="Enter Dispatch Address"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Delivery Instruction </label>
                                                            <textarea class="form-control" id="delivery_instruction" name="delivery_instruction" rows="3" placeholder="Enter Delivery Instruction"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Packing & Forwarding *</label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="packing_forwarding" name="packing_forwarding" rows="3" placeholder="Enter Packing & Forwarding Charges"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Guarantee/Waranty *</label>
                                                            <textarea class="form-control" id="guarantee_warrenty" name="guarantee_warrenty" rows="3" placeholder="Enter Guarantee/Waranty"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Payment Term *</label>
                                                            <!-- <select class="form-control select2bs4" style="width: 100%;" id="payment_term" name="payment_term" required>
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($payment_term_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->payement_terms_category;?></option>
                                                                <?php endforeach;?>
                                                            </select> -->

                                                            <textarea class="form-control" id="payment_term" name="payment_term" rows="3" placeholder="Enter Payment Term" ></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Special Instruction </label>
                                                            <textarea class="form-control" id="special_instruction" name="special_instruction" rows="3" placeholder="Enter Special Instruction"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Price Condition</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="price_condition" name="price_condition">
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Ex Works</option>
                                                                <option value="2">FOR Site</option>
                                                                <option value="3">Other- Please refer note</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Your Reference</label>
                                                            <textarea class="form-control" id="your_reference" name="your_reference" rows="3" placeholder="Enter Your Reference"></textarea>
                                                        </div>
                                                    </div>
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
                                                                <p style="color: #FF0000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Please Check HSN Code Of Product Before Submiting Offer</p>
                                                                <!-- <div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
                                                                    <a data-toggle="modal" data-target="#modal-lg-product-add" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
                                                                    Add New Product
                                                                    </a>
                                                                </div> -->
                                                            </div>
                                                            <div class="card-body">
                                                                <div  class="table-responsive">
                                                                   <table id="example1" class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="display: none;">Entity Id</th>
                                                                                <th>Sr. No.</th>
                                                                                <th>Name</th>
                                                                                <th>Make</th>
                                                                                <th>Description</th>
                                                                                <!-- <th>Delivery Period</th> -->
                                                                                <!-- <th>Warranty</th> -->
                                                                                <th>Price</th>
                                                                                <th>Qty</th>
                                                                                <th>Basic Amount</th>
                                                                                 <th>Discount(%)</th>
                                                                                <th>Discount(Amt)</th> 
                                                                                <th>Unit Discounted(Amt)</th>
                                                                                <th>Total Amount Without GST</th>
                                                                                <th>HSN Code</th>
                                                                                <th>CGST%</th>
                                                                                <th>SGST%</th>
                                                                                <th>IGST%</th>
                                                                                <th>Tax Amount</th>
                                                                                <th>Total Amount</th>
                                                                                <th>Remark</th>
                                                                                <th>Internal Remark</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $no = 0;
                                                                                foreach ($offer_product_list as $row):
                                                                                  $no++;
                                                                                  $offer_reational_entity_id = $row->entity_id;
                                                                                  $product_name = $row->product_name;
                                                                                  $product_description = $row->product_custom_description;
                                                                                  $product_id = "Product Id :- ".$row->product_id;
                                                                                  /*$product_hsn_code = "Product HSN Code :- ".$row->hsn_code;*/
                                                                                  $hsn_id = $row->hsn_id;

                                                                                  $product_qty = $row->rfq_qty;
                                                                                  $product_price = $row->price;
                                                                                  $product_basic_value = $product_qty * $product_price;
                                                                                  $cgst_amount = "CGST :- ".$row->cgst_amt;
                                                                                  $sgst_amount = "SGST :- ".$row->sgst_amt;
                                                                                  $igst_amount = "IGST :- ".$row->igst_amt;
                                                                                  $P_Name = $product_name."\n".$product_id."\n";
                                                                            ?>
                                                                            <tr>
                                                                                <td style="display: none;" class="offer_relation_entity_id" id="offer_relation_entity_id"><?php echo $offer_reational_entity_id;?></td>
                                                                                <td><?php echo $no;?></td>
                                                                                <td>
                                                                                    <textarea class="form-control" disabled style="width: 300px;" rows="3"><?php echo $P_Name;?></textarea>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control select2bs4" id="product_make" name="product_make" placeholder="Enter Product Make" style="width: 100px;" disabled>
                                                                                        <option value="">SELECT MAKE</option>
                                                                                        <?php 
                                                                                            foreach($make_list as $make ):?>
                                                                                                <option value="<?php echo $make->entity_id;?>" <?php echo ($make->entity_id == $row->product_make)?'selected':'';?>><?php echo $make->make_name;?></option>
                                                                                                <?php
                                                                                            endforeach;
                                                                                        ?>
                                                                                    </select>   
                                                                                </td>

                                                                                <td>
                                                                                    <textarea class="form-control" id="product_description" name="product_description" style="width: 150px;" rows="3" placeholder="Enter Product Description" onchange="change_ProductDescription(this);"><?php if($product_description){
                                                                                      echo $product_description;
                                                                                    }else{
                                                                                      echo $P_Name;}?></textarea>   
                                                                                </td>
                                                                                <!-- <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->delivery_period;?>" id="offer_product_delivery_period" name="offer_product_delivery_period" placeholder="Enter Delivery Period" style="width: 100px;" onchange="change_DeliveryPeriod(this);">    
                                                                                </td> -->
                                                                                <!-- <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->product_warranty;?>" id="product_warranty" name="product_warranty" placeholder="Enter Warranty" style="width: 100px;" onchange="change_Warranty(this);">   
                                                                                </td> -->
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->price;?>" id="product_price" name="product_price" placeholder="Enter Price" style="width: 100px;" onchange="change_Price(this);">   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->rfq_qty;?>" id="product_qty" name="product_qty" placeholder="Enter Qty" style="width: 100px;" onchange="change_ProductQty(this);">   
                                                                                </td>
                                                                                <td><?php echo $product_basic_value;?></td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->discount;?>" id="product_dis_per" name="product_dis_per" placeholder="Enter Discount%" style="width: 100px;" onchange="change_ProductDisPercentage(this);">
                                                                                </td>
                                                                                <!-- <td><?php echo $row->discount_amt;?></td>  -->
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->discount_amt;?>" id="discount_amt" name="discount_amt" placeholder="Enter Discount Amount" style="width: 100px;" onchange="change_ProductDisAmount(this);">
                                                                                </td>
                                                                                <td><?php echo $row->unit_discounted_price;?></td>
                                                                                <td><?php echo $row->total_amount_without_gst;?></td>

                                                                                <td class="hsn_id" id="hsn_id">
                                                                                    <select class="form-control" style="width: 150px;"  id="hsn_id" name="hsn_id" onchange="change_hsn(this);">
                                                                                        <option value="">Not Selected</option>
                                                                                        <?php foreach($product_detail_hsn_code as $hsn_row):?>
                                                                                        <option value="<?php echo $hsn_row->entity_id;?>"<?php if ($hsn_row->entity_id == $hsn_id) echo ' selected="selected"'; ?>><?php echo $hsn_row->hsn_code;?></option>
                                                                                        <?php endforeach;?>
                                                                                    </select>
                                                                                </td>

                                                                                <td><?php echo $row->cgst_discount;?></td>
                                                                                <td><?php echo $row->sgst_discount;?></td>
                                                                                <td><?php echo $row->igst_discount;?></td>
                                                                                <td><?php echo $cgst_amount;?><br><br><?php echo $sgst_amount;?><br><br><?php echo $igst_amount;?></td>
                                                                                <td><?php echo $row->total_amount_with_gst;?></td>
                                                                                <td>
                                                                                    <textarea class="form-control" id="product_remark" name="product_remark" style="width: 300px;" rows="3" placeholder="Enter Product Remark" onchange="change_Productremark(this);"><?php echo $row->remark;?></textarea>   
                                                                                </td>

                                                                                <td>
                                                                                    <textarea class="form-control" id="product_internal_remark" name="product_internal_remark" style="width: 300px;" rows="3" placeholder="Enter Product Internal Remark" onchange="change_ProductInternalremark(this);"><?php echo $row->internal_remark;?></textarea>   
                                                                                </td>
                                                                                <td>
                                                                                    <a class="btn btn-sm btn-danger" onclick="delete_offer_product(<?php echo $offer_reational_entity_id; ?>)"><i class="fas fa-trash"></i> </a>
                                                                                </td>
                                                                            </tr>
                                                                           <?php endforeach;?>
                                                                        </tbody>
                                                                   </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Terms & Condition *</label>
                                                            <input type="text" name="offer_terms_condition" id="offer_terms_condition" class="form-control" size="50">
                                                        </div>
                                                    </div> -->

                                                    <div class="col-sm-4">
                                                        <div class="form-group">   
                                                            <label for="offer_attachment">Attachment</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="offer_attachment[]" multiple id="offer_attachment">
                                                                    <label class="custom-file-label" for="offer_attachment">Choose Attachment</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Delivery Period </label>
                                                            <input type="text" name="delivery_period" id="delivery_period" class="form-control" placeholder="Enter Delivery Period" size="50">
                                                        </div>
                                                    </div> -->

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Foot Note </label>
                                                            <textarea class="form-control" id="offer_note" name="offer_note" rows="3" placeholder="Enter Note"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Quotation Close Date *</label>
                                                            <input type="date" name="offer_close_date" id="offer_close_date" class="form-control" size="50" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <center>
                                                        <button type="submit" class="btn btn-success toastrDefaultSuccess">
                                                            Save & Close
                                                        </button>

                                                        <!-- <a data-toggle="modal" data-target="#modal-mail" class="btn btn-primary" style="color: #ffff;">
                                                            Add Mails
                                                        </a> -->
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
            <?php $this->load->view('footer');?>
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <div class="modal fade" id="modal-product">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Select product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                       <div class="modal-body">
                            <div  class="table-responsive">
                                <table id="product_details_table" class="table table-bordered table-striped">
                                    <thead>
                                       <tr>
                                          <th></th>
                                          <th style="display: none;">Entity Id</th>
                                          <th>Product Id</th>
                                          <th>Product Name</th>
                                          <th>Product Description</th>
                                          <th>Product Price</th>  
                                          <th>Unit</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 0;
                                            foreach ($product_list as $row):
                                                $no++;
                                                $entity_id = $row->entity_id;

                                                $unit_id = $row->unit;

                                                $this->db->select('*');
                                                $this->db->from('unit_master');
                                                $where = '(unit_master.entity_id = "'.$unit_id.'" )';
                                                $this->db->where($where);
                                                $query_data = $this->db->get();
                                                $query_result = $query_data->row_array();

                                                if(!empty($query_result))
                                                {
                                                    $unit_name = $query_result['unit_name'];
                                                }else{
                                                    $unit_name = "NA";
                                                }
                                        ?>
                                        <tr id="d1">
                                            <td><input type="checkbox" class="checkboxes" id="product_checkbox" name="product_checkbox" value="<?php echo $row->entity_id ?>"></td>
                                            <td style="display: none;"><?php echo $row->entity_id;?></td>
                                            <td><?php echo $row->product_id;?></td>
                                            <td><?php echo $row->product_name;?></td>
                                            <td><?php echo $row->product_long_description;?></td>
                                            <td><?php echo $row->price;?></td>
                                            <td><?php echo $unit_name;?></td>
                                       </tr>
                                       <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="product_checkbox_select">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
             <!-- /.modal-dialog -->
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
                                        <label>HSN Code <span style="color: #FF0000;">* Mandatory</span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pop_up_hsn_code" name="pop_up_hsn_code">
                                            <option value="">No Selected</option>
                                            <?php foreach($product_detail_hsn_code as $row):?>
                                            <option value="<?php echo $row->entity_id;?>"><?php echo $row->hsn_code;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Category <span style="color: #FF0000;">* Mandatory </span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="category_id" name="category_id">
                                            <option value="">No Selected</option>
                                            <?php foreach($product_category as $row):?>
                                            <option value="<?php echo $row->entity_id;?>"><?php echo $row->category_name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label> Sub Category <span style="color: #FF0000;">* </span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="sub_category_id" name="sub_category_id">
                                            <option value="">No Selected</option>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Product Id</label>
                                        <input type="text" name="product_id" id="product_id" class="form-control" placeholder="Enter Product Id">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Product Name<span style="color: #FF0000;">* Mandatory Field</span></label>
                                        <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter Product Name">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label> Product Long Description <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                        <textarea class="form-control" id="product_long_desc" name="product_long_desc" rows="3" placeholder="Enter Product Long Description"></textarea>
                                    </div>
                                </div>

                                <!-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Product Type</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="product_type" name="product_type">
                                            <option value="">No Selected</option>
                                            <option value="1">FG</option>
                                            <option value="2">RM</option>
                                            <option value="3">BOTH</option>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Sourcing Type</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="product_sourcing_type" name="product_sourcing_type">
                                            <!-- <option value="">No Selected</option> -->
                                            <option value="1">MF</option>
                                            <option value="2">Purchase</option>
                                            <option value="3">BOTH</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Warranty<span style="color: #FF0000;">* Mandatory Field</span></label>
                                        <input type="text" name="product_warranty" id="product_warranty" class="form-control" placeholder="Enter Product Warranty">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Unit<span style="color: #FF0000;">* Mandatory Field</span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="product_unit" name="product_unit">
                                            <option value="">No Selected</option>
                                            <option value="No's">No's</option>
                                            <option value="KG">KG</option>
                                            <option value="Ltr's">Ltr's</option>
                                            <option value="Gram's">Gram's</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Price<span style="color: #FF0000;">* Mandatory Field</span></label>
                                        <input type="text" name="pop_up_product_price" id="pop_up_product_price" class="form-control" placeholder="Enter Product Price" required>
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
        <!-- jQuery -->
        <script src="<?php echo base_url().'assets/plugins/jquery/jquery.min.js'?>"></script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo base_url().'assets/plugins/bootstrap/js/bootstrap.bundle.min.js'?>"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url().'assets/plugins/select2/js/select2.full.min.js'?>"></script>
        <!-- Bootstrap4 Duallistbox -->
        <script src="<?php echo base_url().'assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'?>"></script>
        <!-- InputMask -->
        <script src="<?php echo base_url().'assets/plugins/moment/moment.min.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js'?>"></script>
        <!-- date-range-picker -->
        <script src="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.js'?>"></script>
        <!-- bootstrap color picker -->
        <script src="<?php echo base_url().'assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'?>"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="<?php echo base_url().'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'?>"></script>
        <!-- Bootstrap Switch -->
        <script src="<?php echo base_url().'assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js'?>"></script>
        <!-- bs-custom-file-input -->
        <script src="<?php echo base_url().'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
        <!-- Page script -->
        <script type="text/javascript">
            $(document).ready(function () {
                bsCustomFileInput.init();
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
                //call function get data edit
                get_data_edit();

                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="enquiry_entity_id"]').val();
                    $.ajax({
                        url : "<?php echo site_url('sales/offer_register/get_offer_details_by_offerid');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="offer_number"]').val(data[i].offer_no);

                                $('[name="customer_name"]').val(data[i].customer_id).trigger('change');
                                $('[name="contact_id"]').val(data[i].contact_person_id).trigger('change');

                                $('[name="employee_id"]').val(data[i].offer_engg_name).trigger('change');
                                $('[name="enquiry_descrption"]').val(data[i].offer_description);
                                $('[name="offer_type"]').val(data[i].offer_type).trigger('change');
                                $('[name="offer_date"]').val(data[i].offer_date);
                                $('[name="dispatch_address"]').val(data[i].dispatch_address);
                                $('[name="delivery_instruction"]').val(data[i].delivery_instruction);
                                $('[name="packing_forwarding"]').val(data[i].packing_forwarding).trigger('change');
                                $('[name="payment_term"]').val(data[i].payment_term);
                                $('[name="special_instruction"]').val(data[i].special_packing);
                                $('[name="price_condition"]').val(data[i].price_condition).trigger('change');
                                $('[name="offer_note"]').val(data[i].note);
                                $('[name="your_reference"]').val(data[i].your_reference);
                                $('[name="delivery_period"]').val(data[i].delivery_period);
                                $('[name="offer_terms_condition"]').val(data[i].terms_conditions);
                                $('[name="offer_status"]').val(data[i].status).trigger('change');
                                $('[name="price_basis"]').val(data[i].price_basis);
                                $('[name="transport_insurance"]').val(data[i].transport_insurance);
                                $('[name="tax"]').val(data[i].tax);
                                $('[name="delivery_schedule"]').val(data[i].delivery_schedule);
                                $('[name="mode_of_payment"]').val(data[i].mode_of_payment);
                                $('[name="mode_of_transport"]').val(data[i].mode_of_transport);
                                $('[name="guarantee_warrenty"]').val(data[i].guarantee_warrenty);
                                $('[name="validity"]').val(data[i].validity);
                                $('[name="salutation"]').val(data[i].salutation);
                                $('[name="offer_close_date"]').val(data[i].offer_close_date);

                            });
                        }
                    });
                }

            });

            $('#customer_name').change(function(){ 
                var id=$(this).val();
                var contact_person_id = "<?php echo $contact_person_id;?>";

                $.ajax({
                    url : "<?php echo site_url('master/customer_master/get_contact_person');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',

                    success: function(response){

                        // Remove options 
                        $('#contact_id').find('option').not(':first').remove();

                        // Add options
                        $.each(response,function(index,data){
                            if(contact_person_id==data.entity_id){
                                $('#contact_id').append('<option value="'+data['entity_id']+'" selected>'+data['contact_person']+'</option>').trigger('change');

                            }else{
                                $('#contact_id').append('<option value="'+data['entity_id']+'">'+data['contact_person']+'</option>');

                            }
                        });
                    }

                });
                return false;
            });
        </script>

        <script type="text/javascript">
            $(document).on('click', '#add_hsn', function () {

                var hsn_code = document.getElementById('pop_up_new_hsn_code').value;
                var hsn_percentage = document.getElementById('pop_up_new_hsn_percentage').value;

                if(hsn_code != "" && hsn_percentage != "")
                {
                    $.ajax({
                        url:"<?php echo site_url('sales/offer_register/add_hsn_data');?>",
                        type: 'POST',
                        data: {'hsn_code' : hsn_code , 'hsn_percentage' : hsn_percentage},
                        success: function(data){
                            data = data.trim();
                            location.reload();
                        },
                        error: function(){
                            alert("Fail");
                            location.reload();
                        }
                    });
                }else{
                  alert("Enter Proper Details.............");
                }
            });
        </script>

        <script type="text/javascript">
            //load data for edit
            $('#contact_id').change(function(){
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/enquiry_register/get_all_customer_data');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            if (data.length == null) {}else{
                            $val = 
                            $('[name="enquiry_contact_person"]').val(data[i].contact_person);
                            $('[name="enquiry_email_id"]').val(data[i].email_id);
                            $('[name="enquiry_contact_number"]').val(data[i].first_contact_no);
                            $('[name="enquiry_customer_state"]').val(data[i].state_name);
                            $('[name="enquiry_customer_city"]').val(data[i].city_name);
                            $('[name="pop_up_mail_to"]').val(data[i].email_id);
                        }
                        })
                    }
                });
                return false;
            });
        </script>

        <script>
            $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
              theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
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
            $('#daterange-btn').daterangepicker(
              {
                ranges   : {
                  'Today'       : [moment(), moment()],
                  'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                  'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                  'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                  'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
              },
              function (start, end) {
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

            $("input[data-bootstrap-switch]").each(function(){
              $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

          })
        </script>

        <script>
            $(function () {
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

        <script>
            var table = $('#product_details_table').dataTable( {
                "pageLength": 10
            } );


           $(function()
           {
                $("#product_checkbox_select").on('click', function(event)
                {
                    $("#product_checkbox_select").attr("disabled", true);

                    var entity_id = document.getElementById('enquiry_entity_id').value;

                    var enquiry_descrption = document.getElementById('enquiry_descrption').value;
                    var employee_id = document.getElementById('employee_id').value;
                    var salutation = document.getElementById('salutation').value;
                    var offer_type = document.getElementById('offer_type').value;
                    var offer_date = document.getElementById('offer_date').value; 
                    var price_basis = document.getElementById('price_basis').value;
                    var transport_insurance = document.getElementById('transport_insurance').value;
                    var tax = document.getElementById('tax').value;
                    var delivery_schedule = document.getElementById('delivery_schedule').value;
                    var mode_of_payment = document.getElementById('mode_of_payment').value;
                    var validity = document.getElementById('validity').value;
                    var dispatch_address = document.getElementById('dispatch_address').value;
                    var delivery_instruction = document.getElementById('delivery_instruction').value;
                    var packing_forwarding = document.getElementById('packing_forwarding').value;
                    var guarantee_warrenty = document.getElementById('guarantee_warrenty').value;
                    var payment_term = document.getElementById('payment_term').value;
                    var special_instruction = document.getElementById('special_instruction').value;
                    var price_condition = document.getElementById('price_condition').value;
                    var your_reference = document.getElementById('your_reference').value;

                    var product_checkbox = table.$('input[type="checkbox"]').serializeArray();

                    $.ajax({
                        url:"<?php echo site_url('sales/offer_register/update_offer_product');?>",
                        type: 'POST',
                        data: {'entity_id': entity_id, 'product_checkbox': product_checkbox,'enquiry_descrption': enquiry_descrption, 'employee_id': employee_id, 'offer_type': offer_type, 'offer_date': offer_date, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'payment_term': payment_term, 'special_instruction': special_instruction, 'price_condition': price_condition, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'your_reference': your_reference, 'validity': validity, 'guarantee_warrenty': guarantee_warrenty},
                        success: function(data){
                            location.reload();
                        },
                        error: function(){
                           alert("Fail")
                        }
                    });
                });
            });
        </script>

        <script type="text/javascript">
            function change_ProductDescription(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var product_desc = item.value;
               var gst_percentage = 18;
              //  var gst_amount = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_description');?>",
                    method : "POST",
                    data : {'product_desc': product_desc,
                            'gst_percentage': gst_percentage,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_ProductMake(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var product_make = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_make');?>",
                    method : "POST",
                    data : {'product_make': product_make,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_DeliveryPeriod(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var delivery_period = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_delivery_period');?>",
                    method : "POST",
                    data : {'delivery_period': delivery_period,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_Warranty(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var warranty = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_warranty');?>",
                    method : "POST",
                    data : {'warranty': warranty,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_Price(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var price = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_price');?>",
                    method : "POST",
                    data : {'price': price,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_ProductQty(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var product_qty = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_qty');?>",
                    method : "POST",
                    data : {'product_qty': product_qty,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_ProductDisPercentage(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var discount_percentage = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_discount_percentage');?>",
                    method : "POST",
                    data : {'discount_percentage': discount_percentage,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_hsn(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var hsn_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_hsn_id');?>",
                    method : "POST",
                    data : {'hsn_id': hsn_id,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_Productremark(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var product_remark = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_remark');?>",
                    method : "POST",
                    data : {'product_remark': product_remark,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_ProductInternalremark(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var internal_remark = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_internalremark');?>",
                    method : "POST",
                    data : {'internal_remark': internal_remark,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function delete_offer_product(d){
                var id=d;
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/delete_offer_product');?>",
                    type : "POST",
                    data: {'id': id},
                    success : function(data) {
                        location.reload();
                    },
                    error : function(data) {
                        alert("Failed!!");
                    }
                });
            }
            
            function change_ProductDisAmount(item)
            {
               var offer_relation_entity_id = $(item).closest('tr').find('.offer_relation_entity_id ').text();
               var discount_amount = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_discount_amount');?>",
                    method : "POST",
                    data : {'discount_amount': discount_amount,
                            'offer_relation_entity_id': offer_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }
        </script>

        <script type="text/javascript">
            $(document).on('click', '#update_new_product', function () {

                var enquiry_entity_id = $("#enquiry_entity_id").val();
                var enquiry_descrption = document.getElementById('enquiry_descrption').value;
                var employee_id = document.getElementById('employee_id').value;
                var offer_type = document.getElementById('offer_type').value;
                var offer_date = document.getElementById('offer_date').value;
                //var offer_freight = document.getElementById('offer_freight').value;
                //var freight_charges = document.getElementById('freight_charges').value;
                var dispatch_address = document.getElementById('dispatch_address').value; 
                var delivery_instruction = document.getElementById('delivery_instruction').value;
               
                //var packing_forwarding_charges = document.getElementById('packing_forwarding_charges').value;
               
                var special_instruction = document.getElementById('special_instruction').value;
                //var offer_insurance = document.getElementById('offer_insurance').value;
                //var insurance_charges = document.getElementById('insurance_charges').value;
                var price_condition = document.getElementById('price_condition').value;

                var salutation = document.getElementById('salutation').value;
                var price_basis = document.getElementById('price_basis').value;


                var transport_insurance = document.getElementById('transport_insurance').value;
                var tax = document.getElementById('tax').value;
                var delivery_schedule = document.getElementById('delivery_schedule').value;
                var mode_of_payment = document.getElementById('mode_of_payment').value;
                /*var mode_of_transport = document.getElementById('mode_of_transport').value;*/
                /*var guarantee_warrenty = document.getElementById('guarantee_warrenty').value;*/
                var payment_term = document.getElementById('payment_term').value;
                var packing_forwarding = document.getElementById('packing_forwarding').value;
                var your_reference = document.getElementById('your_reference').value;

                var pop_up_hsn_code = $("#pop_up_hsn_code").val();
                var category_id = $("#category_id").val();
                /*var sub_category_id = $("#sub_category_id").val();*/
                var product_id = $("#product_id").val();
                var product_name = $("#product_name").val();
                var product_long_desc = $("#product_long_desc").val();
                var product_sourcing_type = $("#product_sourcing_type").val();
                var product_warranty = $("#product_warranty").val();
                var product_unit = $("#product_unit").val();
                var product_price = $("#pop_up_product_price").val();

                if(enquiry_entity_id != "" && pop_up_hsn_code != "" && category_id != "" && product_id !="" && product_name != "" && product_long_desc != "" && product_warranty != "" && product_unit != "" && product_price !="")
                {   
                    $.ajax({
                            url : "<?php echo site_url('sales/offer_register/update_new_product_with_offer');?>",
                            type : "POST",
                            data: {'enquiry_entity_id': enquiry_entity_id,'enquiry_descrption': enquiry_descrption, 'employee_id': employee_id, 'offer_type': offer_type, 'offer_date': offer_date, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'payment_term': payment_term, 'special_instruction': special_instruction, 'price_condition': price_condition, 'pop_up_hsn_code': pop_up_hsn_code, 'category_id': category_id, 'product_id': product_id, 'product_name': product_name, 'product_long_desc': product_long_desc, 'product_sourcing_type': product_sourcing_type, 'product_warranty': product_warranty, 'product_unit': product_unit, 'product_price': product_price, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'your_reference': your_reference},
                            success : function(data) {
                                location.reload();
                            },
                            error : function(data) {
                                alert("Product Already Exist");
                            }
                    });
                }else{
                    alert("Enter All Details");
                }
            });
        </script>
    </body>
</html>