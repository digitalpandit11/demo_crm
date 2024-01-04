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
        <title>View Sales Order</title>
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
            <?php $this->load->view('header_sidebar');?> 
            <?php 
                $attachment_data = $order_result->row_array();
                $attachment_img = $attachment_data['attachment'];
                $image_attachment_name = explode(',',$attachment_img);
                array_pop($image_attachment_name);
            ?>
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">View Sales Order</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_sales_order_data'?>">Sales Order Register</a></li>
                                            <li class="breadcrumb-item">View Sales Order Details Of Id :- <?php  echo $entity_id; ?> </li>
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
                                            <h3 class="card-title">Sales Order Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="offer_form" enctype="multipart/form-data" action="<?php echo site_url('sales/sales_order_register/update_sales_order');?>" method="post">
                                                
                                                <input type="hidden" id="order_entity_id" name="order_entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> Sales Order Number </label>
                                                            <input type="text" name="sales_order_number" id="sales_order_number" class="form-control"  size="50" placeholder="Enter Sales Order Number" readonly>
                                                        </div>
                                                    </div>

                                                    

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> Customer Name </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="customer_name" name="customer_name" disabled>
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($customer_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Customer Ship To Address Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Company </label>
                                                                            <input type="text" name="ship_to_company_name" id="ship_to_company_name" class="form-control" size="50" placeholder="Enter Ship To Company" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <input type="text" name="ship_to_contact_person" id="ship_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="ship_to_email_id" id="ship_to_email_id" class="form-control" size="50" placeholder="Customer Email Id" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Address</label>
                                                                            <textarea class="form-control" id="ship_to_address" name="ship_to_address" rows="3" placeholder="Enter Ship To Address" disabled></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="ship_to_contact_number" id="ship_to_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> GST Number </label>
                                                                            <input type="text" name="ship_to_gst_number" id="ship_to_gst_number" class="form-control" size="50" placeholder="Customer GST Number" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Customer Bill To Address Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Company </label>
                                                                            <input type="text" name="bill_to_company_name" id="bill_to_company_name" class="form-control" size="50" placeholder="Enter Bill To Company" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <input type="text" name="bill_to_contact_person" id="bill_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="bill_to_email_id" id="bill_to_email_id" class="form-control" size="50" placeholder="Customer Email Id" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Address</label>
                                                                            <textarea class="form-control" id="bill_to_address" name="bill_to_address" rows="3" placeholder="Enter Bill To Address" disabled></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="bill_to_contact_number" id="bill_to_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> GST Number </label>
                                                                            <input type="text" name="bill_to_gst_number" id="bill_to_gst_number" class="form-control" size="50" placeholder="Customer GST Number" disabled>
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
                                                            <label style="color: #FF0000;"> Order Description * </label>
                                                            <textarea class="form-control" id="order_descrption" name="order_descrption" rows="3" placeholder="Enter Enquiry Description" required readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Select Employee *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="employee_id" name="employee_id" required disabled>
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($employee_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->Emp_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Special Customer</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="special_customer" name="special_customer" required disabled>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">S-Sayali</option>
                                                                <option value="2">M-Maitri</option>
                                                                <option value="3">E-ESPL</option>
                                                                <option value="4">K-Kanha</option>
                                                                <option value="5">A-ACG</option>
                                                                <option value="6">X-Not Specified</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Salutation * </label>
                                                            <textarea class="form-control" id="salutation" name="salutation" rows="3" placeholder="Enter Salutation" required readonly></textarea>
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
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Price Basis*</label>
                                                            <input type="text" name="price_basis" id="price_basis" class="form-control" size="50" required readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Transportation & Insurance *</label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="transport_insurance" name="transport_insurance" rows="3" placeholder="Enter Transportation & Insurance" readonly></textarea>
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
                                                            <textarea class="form-control" id="tax" name="tax" rows="3" placeholder="Enter Tax" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Delivery Schedule *</label>
                                                            <textarea class="form-control" id="delivery_schedule" name="delivery_schedule" rows="3" placeholder="Enter Delivery Schedule" readonly></textarea>
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
                                                            <textarea class="form-control" id="mode_of_payment" name="mode_of_payment" rows="3" placeholder="Enter Mode Of Payment" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Mode of Transport *</label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="mode_of_transport" name="mode_of_transport" rows="3" placeholder="Enter Mode Of Transport" readonly></textarea>
                                                        </div>
                                                    </div>

                                                     <!-- <div class="col-sm-3" id="Packing_forwarding_form" style="display: none">
                                                        <div class="form-group">
                                                            <label> P & F Charges <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <input type="text" name="packing_forwarding_charges" id="packing_forwarding_charges" class="form-control" placeholder="Enter Packing & Forwarding Charges" size="50">
                                                        </div>
                                                    </div> -->
                                                </div>







                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label > Dispatch Address </label>
                                                            <textarea class="form-control" id="dispatch_address" name="dispatch_address" rows="3" placeholder="Enter Dispatch Address" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Delivery Instruction </label>
                                                            <textarea class="form-control" id="delivery_instruction" name="delivery_instruction" rows="3" placeholder="Enter Delivery Instruction" readonly></textarea>
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
                                                            <textarea class="form-control" id="packing_forwarding" name="packing_forwarding" rows="3" placeholder="Enter Packing & Forwarding Charges" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Guarantee/Waranty *</label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="guarantee_warrenty" name="guarantee_warrenty" rows="3" placeholder="Enter Guarantee/Waranty" readonly></textarea>
                                                        </div>
                                                    </div>

                                                     <!-- <div class="col-sm-3" id="Packing_forwarding_form" style="display: none">
                                                        <div class="form-group">
                                                            <label> P & F Charges <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <input type="text" name="packing_forwarding_charges" id="packing_forwarding_charges" class="form-control" placeholder="Enter Packing & Forwarding Charges" size="50">
                                                        </div>
                                                    </div> -->
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Payment Term *</label>
                                                            <!-- <select class="form-control select2bs4" style="width: 100%;" id="payment_term" name="payment_term" required>
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($payment_term_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->payement_terms_category;?></option>
                                                                <?php endforeach;?>
                                                            </select> -->

                                                            <textarea class="form-control" id="payment_term" name="payment_term" rows="3" placeholder="Enter Payment Term" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Special Instruction </label>
                                                            <textarea class="form-control" id="special_instruction" name="special_instruction" rows="3" placeholder="Enter Special Instruction" readonly></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Terms & Condition *</label>
                                                            <input type="text" name="terms_conditions" id="terms_conditions" class="form-control" size="50" required readonly>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Insurance </label>
                                                            <select class="form-control" style="width: 100%;" id="offer_insurance" name="offer_insurance">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hideInsurance()">Customer Scope</option>
                                                                <option value="2" onClick="showInsurance()">Company Scope</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                     <div class="col-sm-3" id="Insurance_form" style="display: none">
                                                        <div class="form-group">
                                                            <label> Insurance Charges <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <input type="text" name="insurance_charges" id="insurance_charges" class="form-control" placeholder="Enter Insurance Charges" size="50">
                                                        </div>
                                                    </div> -->

                                                    <!-- <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Price Condition</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="price_condition" name="price_condition">
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Ex Works</option>
                                                                <option value="2">FOR Site</option>
                                                                <option value="3">Other- Please refer note</option>
                                                            </select>
                                                        </div>
                                                    </div> -->
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                      <!-- general form elements disabled -->
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Product Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div  class="table-responsive">
                                                                   <table id="example1" class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="display: none;">Entity Id</th>
                                                                                <th>Sr. No.</th>
                                                                                <th>Name</th>
                                                                                <th>Description</th>
                                                                                <th>Delivery Period</th>
                                                                                <th>Warranty</th>
                                                                                <th>Price</th>
                                                                                <th>Qty</th>
                                                                                <th>Basic Amount</th>
                                                                                <th>Discount(%)</th>
                                                                                <th>Discount(Amt)</th>
                                                                                <th>Unit Discounted(Amt)</th>
                                                                                <th>Total Amount Without GST</th>
                                                                                <th>CGST%</th>
                                                                                <th>SGST%</th>
                                                                                <th>IGST%</th>
                                                                                <th>Tax Amount</th>
                                                                                <th>Total Amount</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $no = 0;
                                                                                foreach ($order_product_list as $row):
                                                                                  $no++;
                                                                                  $order_reational_entity_id = $row->entity_id;
                                                                                  $product_name = $row->product_name;
                                                                                  $product_id = "Product Id :- ".$row->product_id;
                                                                                  $product_hsn_code = "Product HSN Code :- ".$row->hsn_code;
                                                                                  $product_qty = $row->rfq_qty;
                                                                                  $product_price = $row->price;
                                                                                  $product_basic_value = $product_qty * $product_price;
                                                                                  $cgst_amount = "CGST :- ".$row->cgst_amount;
                                                                                  $sgst_amount = "SGST :- ".$row->sgst_amount;
                                                                                  $igst_amount = "IGST :- ".$row->igst_amount;
                                                                            ?>
                                                                            <tr>
                                                                                <td style="display: none;" class="order_relation_entity_id" id="order_relation_entity_id"><?php echo $order_reational_entity_id;?></td>
                                                                                <td><?php echo $no;?></td>
                                                                                <td><?php echo $product_name;?><br><br><?php echo $product_id;?><br><br><?php echo $product_hsn_code;?></td>
                                                                                <td>
                                                                                    <textarea class="form-control" id="product_description" name="product_description" style="width: 300px;" rows="3" placeholder="Enter Product Description" readonly onchange="change_ProductDescription(this);"><?php echo $row->product_custom_description; ?></textarea>   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->delivery_period;?>" id="offer_product_delivery_period" name="offer_product_delivery_period" placeholder="Enter Delivery Period" style="width: 200px;" onchange="change_DeliveryPeriod(this);" readonly>    
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->product_warranty;?>" id="product_warranty" name="product_warranty" placeholder="Enter Warranty" style="width: 150px;" onchange="change_Warranty(this);" readonly>   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->price;?>" id="product_price" name="product_price" placeholder="Enter Price" style="width: 100px;" onchange="change_Price(this);" readonly>   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->rfq_qty;?>" id="product_qty" name="product_qty" placeholder="Enter Qty" style="width: 100px;" onchange="change_ProductQty(this);" readonly>   
                                                                                </td>
                                                                                <td><?php echo $product_basic_value;?></td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->discount;?>" id="product_dis_per" name="product_dis_per" placeholder="Enter Discount%" style="width: 100px;" onchange="change_ProductDisPercentage(this);" readonly>
                                                                                </td>
                                                                                <td><?php echo $row->discount_amt;?></td>
                                                                                <td><?php echo $row->unit_discounted_price;?></td>
                                                                                <td><?php echo $row->total_amount_without_gst;?></td>
                                                                                <td><?php echo $row->cgst_discount;?></td>
                                                                                <td><?php echo $row->sgst_discount;?></td>
                                                                                <td><?php echo $row->igst_discount;?></td>
                                                                                <td><?php echo $cgst_amount;?><br><br><?php echo $sgst_amount;?><br><br><?php echo $igst_amount;?></td>
                                                                                <td><?php echo $row->total_amount_with_gst;?></td>
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
                                                    <div class="col-md-12">
                                                      <!-- general form elements disabled -->
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Product Accessories Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div  class="table-responsive">
                                                                   <table id="accessories_details_table" class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="display: none;">Entity Id</th>
                                                                                <th>Sr. No.</th>
                                                                                <th>Accessories For</th>
                                                                                <th>Accessories Name</th>
                                                                                <th>Price</th>
                                                                                <th>Qty</th>
                                                                                <th>Basic Amount</th>
                                                                                <th>Discount(%)</th>
                                                                                <th>Discount(Amt)</th>
                                                                                <th>Unit Discounted(Amt)</th>
                                                                                <th>Total Amount Without GST</th>
                                                                                <th>CGST%</th>
                                                                                <th>SGST%</th>
                                                                                <th>IGST%</th>
                                                                                <th>Tax Amount</th>
                                                                                <th>Total Amount</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $no = 0;
                                                                                foreach ($order_accessories_list as $row):
                                                                                  $no++;
                                                                                  $order_accessories_reational_entity_id = $row->entity_id;
                                                                                  $product_name = $row->product_name;
                                                                                  $product_id = "Product Id :- ".$row->product_id;
                                                                                  $product_hsn_code = "Product HSN Code :- ".$row->hsn_code;
                                                                                  $product_qty = $row->qty;
                                                                                  $product_price = $row->price;
                                                                                  $product_basic_value = $product_qty * $product_price;
                                                                                  $cgst_amount = "CGST :- ".$row->cgst_amount;
                                                                                  $sgst_amount = "SGST :- ".$row->sgst_amount;
                                                                                  $igst_amount = "IGST :- ".$row->igst_amount;

                                                                                  $accessories_for_id = $row->sales_order_product_id;

                                                                                    $this->db->select('sales_order_product_relation.*,
                                                                                        product_master.product_name,
                                                                                        product_master.product_id,
                                                                                        product_hsn_master.hsn_code');
                                                                                    $this->db->from('sales_order_product_relation');
                                                                                    $this->db->join('product_master', 'sales_order_product_relation.product_id = product_master.entity_id', 'INNER');
                                                                                    $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
                                                                                    $where = '(sales_order_product_relation.entity_id = "'.$accessories_for_id.'" )';
                                                                                    $this->db->where($where);
                                                                                    $query = $this->db->get();
                                                                                    $query_data_result = $query->row();

                                                                                    $Accessories_for_product_name = $query_data_result->product_name;
                                                                                    $Accessories_for_product_id = "Product Id :- ".$query_data_result->product_id;
                                                                                    $Accessories_for_product_hsn_code = "Product HSN Code :- ".$query_data_result->hsn_code;

                                                                                    $Accessories_for_product_product_custom_description = $query_data_result->product_custom_description;
                                                                            ?>
                                                                            <tr>
                                                                                <td style="display: none;" class="order_accessories_relation_entity_id" id="order_accessories_relation_entity_id"><?php echo $order_accessories_reational_entity_id;?></td>
                                                                                <td><?php echo $no;?></td>
                                                                                <td><?php echo $Accessories_for_product_name;?><br><br><?php echo $Accessories_for_product_id;?><br><br><?php echo $Accessories_for_product_hsn_code;?><br><br><?php echo $Accessories_for_product_product_custom_description;?></td>
                                                                                <td><?php echo $product_name;?><br><br><?php echo $product_id;?><br><br><?php echo $product_hsn_code;?></td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->price;?>" id="product_price" name="product_price" placeholder="Enter Price" style="width: 100px;" onchange="change_accessories_Price(this);" readonly>   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->qty;?>" id="product_qty" name="product_qty" placeholder="Enter Qty" style="width: 100px;" onchange="change_accessories_Qty(this);" readonly>   
                                                                                </td>
                                                                                <td><?php echo $product_basic_value;?></td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->discount;?>" id="product_dis_per" name="product_dis_per" placeholder="Enter Discount%" style="width: 100px;" onchange="change_accessories_DisPercentage(this);" readonly>
                                                                                </td>
                                                                                <td><?php echo $row->discount_amount;?></td>
                                                                                <td><?php echo $row->unit_discounted_price;?></td>
                                                                                <td><?php echo $row->total_amount_without_gst;?></td>
                                                                                <td><?php echo $row->cgst_percentage;?></td>
                                                                                <td><?php echo $row->sgst_percentage;?></td>
                                                                                <td><?php echo $row->igst_percentage;?></td>
                                                                                <td><?php echo $cgst_amount;?><br><br><?php echo $sgst_amount;?><br><br><?php echo $igst_amount;?></td>
                                                                                <td><?php echo $row->total_amount_with_gst;?></td>
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
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Purchase Order Number * </label>
                                                            <input type="text" name="purchase_order_number" id="purchase_order_number" class="form-control"  size="50" placeholder="Enter Purchase Order Number" required readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Purchase Order Date *</label>
                                                            <input type="date" name="purchase_order_date" id="purchase_order_date" class="form-control" size="50" required readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">   
                                                            <label for="order_attachment">Attachment</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="order_attachment[]" multiple id="order_attachment" readonly>
                                                                    <label class="custom-file-label" for="order_attachment">Choose Attachment</label>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                                foreach ($image_attachment_name as $key => $value) {
                                                            ?>
                                                            <p>
                                                            <a target="_blank" href="<?php echo base_url();?>assets/order_attachment/<?php echo $value;?>"><?php echo $value;?></a>
                                                            <!-- <a href="delete.php?<?php echo $value;?>"><input type="button" value="Delete"> -->
                                                            <?php if(!empty($value)){ ?>
                                                            <a href="<?php echo site_url('delete_attach_order_image/'.$value.'-'.$entity_id);?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></p>
                                                            <?php }}?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Order Status *</label>
                                                            <select class="form-control" style="width: 100%;" id="order_status" name="order_status" required readonly>
                                                                <option value="">Not Selected</option>
                                                                <!-- <option value="1">Pending Offers</option> -->
                                                                <option value="2">Order Created</option>
                                                                <option value="3">Order Canceled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="card-body">
                                                    <center>
                                                        <button type="submit" class="btn btn-success toastrDefaultSuccess">
                                                            Submit
                                                        </button>
                                                    </center>
                                                </div> -->
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
                                       </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 0;
                                            foreach ($product_list as $row):
                                              $no++;
                                              $entity_id = $row->entity_id;
                                        ?>
                                        <tr id="d1">
                                            <td><input type="checkbox" class="checkboxes" id="product_checkbox" name="product_checkbox" value="<?php echo $row->entity_id ?>"></td>
                                            <td style="display: none;"><?php echo $row->entity_id;?></td>
                                            <td><?php echo $row->product_id;?></td>
                                            <td><?php echo $row->product_name;?></td>
                                            <td><?php echo $row->product_short_description;?></td>
                                            <td><?php echo $row->price;?></td>
                                       </tr>
                                       <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="product_checkbox_submited">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
             <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-product-accessories">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enter Accessories Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="pop_up_accessories_form" id="pop_up_accessories_form" method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label> Accessories For <span style="color: #FF0000;">* Mandatory Field</span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="accessories_for" id="accessories_for">
                                            <option value="">No Selected</option>
                                                <?php foreach($order_product_list as $row):?>
                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->product_name;?></option>
                                                <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label> Accessories <span style="color: #FF0000;">* Mandatory Field</span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="accessories" id="accessories">
                                            <option value="">No Selected</option>
                                                <?php foreach($accessories_list as $row):?>
                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->product_name;?></option>
                                                <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Accessories Rate</label>
                                        <input type="text" class="form-control" name="accessories_rate" id="accessories_rate" placeholder="EnterAccessories Rate">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Accessories Quantity</label>
                                        <input type="text" class="form-control" name="accessories_qty" id="accessories_qty" placeholder="Enter Accessories Quantity">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        
                        <button type="submit" name="add_new_accessories" id="add_new_accessories" class="btn btn-primary">Save</button>
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
                    var entity_id = $('[name="order_entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('sales/sales_order_register/get_order_details_by_orderid_without_offer');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="offer_number"]').val(data[i].offer_no);
                                $('[name="sales_order_number"]').val(data[i].sales_order_no);
                                $('[name="enquiry_number"]').val(data[i].enquiry_no);
                                $('[name="customer_name"]').val(data[i].customer_id).trigger('change');
                                $('[name="employee_id"]').val(data[i].order_engg_name).trigger('change');
                                $('[name="order_descrption"]').val(data[i].sales_order_description);
                                $('[name="terms_conditions"]').val(data[i].terms_conditions);
                                $('[name="delivery_period"]').val(data[i].delivery_period);
                                $('[name="order_freight"]').val(data[i].transportation).trigger('change');
                                $('[name="freight_charges"]').val(data[i].transportation_price);
                                $('[name="dispatch_address"]').val(data[i].dispatch_address);
                                $('[name="delivery_instruction"]').val(data[i].delivery_instruction);
                                $('[name="order_pf"]').val(data[i].packing_forwarding).trigger('change');
                                $('[name="packing_forwarding_charges"]').val(data[i].packing_forwarding_price);
                                $('[name="payment_term"]').val(data[i].payment_term).trigger('change');
                                $('[name="special_instruction"]').val(data[i].special_packing);
                                $('[name="order_insurance"]').val(data[i].insurance).trigger('change');
                                $('[name="insurance_charges"]').val(data[i].insurance_price);
                                $('[name="purchase_order_number"]').val(data[i].po_no);
                                $('[name="purchase_order_date"]').val(data[i].po_date);
                                $('[name="order_status"]').val(data[i].status);
                                $('[name="ship_to_company_name"]').val(data[i].customer_ship_to_name);
                                $('[name="bill_to_contact_person"]').val(data[i].customer_bill_to_contact_person);
                                $('[name="bill_to_email_id"]').val(data[i].customer_bill_to_contact_person_mail);
                                $('[name="bill_to_contact_number"]').val(data[i].customer_bill_to_contact_person_no);
                                $('[name="bill_to_address"]').val(data[i].customer_bill_to_address);
                                $('[name="bill_to_gst_number"]').val(data[i].customer_bill_to_gst_no);
                                $('[name="bill_to_company_name"]').val(data[i].customer_bill_to_name);
                                $('[name="ship_to_contact_person"]').val(data[i].customer_ship_to_contact_person);
                                $('[name="ship_to_address"]').val(data[i].customer_ship_to_address);
                                $('[name="ship_to_email_id"]').val(data[i].customer_ship_to_contact_person_mail);
                                $('[name="ship_to_contact_number"]').val(data[i].customer_ship_to_contact_person_no);
                                $('[name="ship_to_gst_number"]').val(data[i].customer_ship_to_gst_no);
                                $('[name="special_customer"]').val(data[i].special_customer).trigger('change');

                                $('[name="price_basis"]').val(data[i].price_basis);
                                $('[name="transport_insurance"]').val(data[i].transport_insurance);
                                $('[name="tax"]').val(data[i].tax);
                                $('[name="delivery_schedule"]').val(data[i].delivery_schedule);
                                $('[name="mode_of_payment"]').val(data[i].mode_of_payment);
                                $('[name="mode_of_transport"]').val(data[i].mode_of_transport);
                                $('[name="guarantee_warrenty"]').val(data[i].guarantee_warrenty);
                                $('[name="packing_forwarding"]').val(data[i].packing_forwarding);
                                $('[name="payment_term"]').val(data[i].payment_term);
                                $('[name="salutation"]').val(data[i].salutation);
                                $('[name="terms_conditions"]').val(data[i].terms_conditions);
                            });
                        }
                    });
                }
            });
        </script>

        <!-- <script type="text/javascript">
            //load data for edit
                $('#customer_name').change(function(){
                    var id=$(this).val();
                    $.ajax({
                        url : "<?php echo site_url('sales/sales_order_register/get_all_customer_address_data');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val = 
                                $('[name="bill_to_contact_person"]').val(data[i].Bill_to_contact_person);
                                $('[name="bill_to_email_id"]').val(data[i].Bill_to_email_id);
                                $('[name="bill_to_contact_number"]').val(data[i].Bill_to_contact_no);
                                $('[name="bill_to_address"]').val(data[i].Bill_to_address);
                                $('[name="bill_to_customer_state"]').val(data[i].Bill_to_state);
                                $('[name="bill_to_customer_city"]').val(data[i].Bill_to_city);
                                $('[name="ship_to_contact_person"]').val(data[i].Ship_to_contact_person);
                                $('[name="ship_to_address"]').val(data[i].Ship_to_address);
                                $('[name="ship_to_email_id"]').val(data[i].Ship_to_email_id);
                                $('[name="ship_to_contact_number"]').val(data[i].Ship_to_contact_no);
                                $('[name="ship_to_customer_state"]').val(data[i].Ship_to_state);
                                $('[name="ship_to_customer_city"]').val(data[i].Ship_to_city);
                            })
                        }
                    });
                    return false;
                });
        </script> -->

        <script type="text/javascript">
            function showFreight(){
               document.getElementById('Freight_charges_form').style.display = "block";
            }

            function hideFreight(){
                $('#Freight_charges_form').hide();  
            }

            function showPackFor(){
               document.getElementById('Packing_forwarding_form').style.display = "block";
            }

            function hidePackFor(){
                $('#Packing_forwarding_form').hide();  
            }

            function showInsurance(){
               document.getElementById('Insurance_form').style.display = "block";
            }

            function hideInsurance(){
                $('#Insurance_form').hide();  
            }
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
            $(document).ready( function () {
                $('#example1').DataTable();
                $('#product_details_table').DataTable();
                $('#accessories_details_table').DataTable();
            } );
        </script>

        <script>
           $(function()
           {
                $("#product_checkbox_submited").on('click', function(event){
                    var order_entity_id = document.getElementById('order_entity_id').value;
                    var order_descrption = document.getElementById('order_descrption').value;
                    var employee_id = document.getElementById('employee_id').value;
                    var order_terms_condition = document.getElementById('terms_conditions').value;
                    var delivery_period = document.getElementById('delivery_period').value;
                    var order_freight = document.getElementById('order_freight').value;
                    var freight_charges = document.getElementById('freight_charges').value;
                    var dispatch_address = document.getElementById('dispatch_address').value; 
                    var delivery_instruction = document.getElementById('delivery_instruction').value;
                    var order_pf = document.getElementById('order_pf').value;
                    var special_customer = document.getElementById('special_customer').value;
                    var packing_forwarding_charges = document.getElementById('packing_forwarding_charges').value;
                    var payment_term = document.getElementById('payment_term').value;
                    var special_instruction = document.getElementById('special_instruction').value;
                    var order_insurance = document.getElementById('order_insurance').value;
                    var insurance_charges = document.getElementById('insurance_charges').value;

                    var product_checkbox = [];
                    $.each($("input[name='product_checkbox']:checked"), function(){            
                        product_checkbox.push($(this).val());
                    });

                    $.ajax({
                        url:"<?php echo site_url('sales/sales_order_register/update_order_product');?>",
                        type: 'POST',
                        data: {'order_entity_id': order_entity_id, 'product_checkbox': product_checkbox,'order_descrption': order_descrption, 'employee_id': employee_id, 'order_terms_condition': order_terms_condition, 'delivery_period': delivery_period, 'order_freight': order_freight, 'freight_charges': freight_charges, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'order_pf': order_pf, 'special_customer': special_customer,'packing_forwarding_charges': packing_forwarding_charges, 'payment_term': payment_term, 'special_instruction': special_instruction, 'order_insurance': order_insurance, 'insurance_charges': insurance_charges},
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
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var product_desc = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_product_description');?>",
                    method : "POST",
                    data : {'product_desc': product_desc,
                            'order_relation_entity_id': order_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_DeliveryPeriod(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var delivery_period = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_product_delivery_period');?>",
                    method : "POST",
                    data : {'delivery_period': delivery_period,
                            'order_relation_entity_id': order_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_Warranty(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var warranty = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_product_warranty');?>",
                    method : "POST",
                    data : {'warranty': warranty,
                            'order_relation_entity_id': order_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_Price(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var price = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_product_price');?>",
                    method : "POST",
                    data : {'price': price,
                            'order_relation_entity_id': order_relation_entity_id},
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
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var product_qty = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_product_qty');?>",
                    method : "POST",
                    data : {'product_qty': product_qty,
                            'order_relation_entity_id': order_relation_entity_id},
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
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var discount_percentage = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_product_discount_percentage');?>",
                    method : "POST",
                    data : {'discount_percentage': discount_percentage,
                            'order_relation_entity_id': order_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function delete_order_product(d){
                var id=d;
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/delete_order_product');?>",
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
        </script>

        <script type="text/javascript">
            $(document).on('click', '#add_new_accessories', function () {

                var entity_id = $('[name="order_entity_id"]').val();
                var accessories_for = $("#accessories_for").val();
                var accessories = $("#accessories").val();
                var accessories_rate = $("#accessories_rate").val();
                var accessories_qty = $("#accessories_qty").val();

                if(entity_id != "" && accessories_for != "" && accessories != "" && accessories_rate != "" && accessories_qty != "")
                {
                    $.ajax({
                            url : "<?php echo site_url('sales/sales_order_register/save_order_accessories_from_order');?>",
                            type : "POST",
                            
                            data: {'entity_id': entity_id , 'accessories_for': accessories_for , 'accessories': accessories , 'accessories_rate': accessories_rate , 'accessories_qty': accessories_qty},
                            success : function(data) {
                                location.reload();
                            },
                            error : function(data) {
                                alert("Accessories Already Exist");
                            }
                    });
                }else{
                    alert("Enter All Details");
                }
            });
        </script>

        <script type="text/javascript">
            function change_accessories_Price(item)
            {
               var order_accessories_relation_entity_id = $(item).closest('tr').find('.order_accessories_relation_entity_id ').text();
               var accessories_price = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_accessories_price');?>",
                    method : "POST",
                    data : {'accessories_price': accessories_price,
                            'order_accessories_relation_entity_id': order_accessories_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_accessories_Qty(item)
            {
               var order_accessories_relation_entity_id = $(item).closest('tr').find('.order_accessories_relation_entity_id ').text();
               var accessories_qty = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_accessories_qty');?>",
                    method : "POST",
                    data : {'accessories_qty': accessories_qty,
                            'order_accessories_relation_entity_id': order_accessories_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_accessories_DisPercentage(item)
            {
               var order_accessories_relation_entity_id = $(item).closest('tr').find('.order_accessories_relation_entity_id ').text();
               var accessories_discount_percentage = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_accessories_discount_percentage');?>",
                    method : "POST",
                    data : {'accessories_discount_percentage': accessories_discount_percentage,
                            'order_accessories_relation_entity_id': order_accessories_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function delete_order_product_accessories(d){
                var id=d;
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/delete_order_accessories');?>",
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
        </script>

        <script type="text/javascript">
            function change_bill_to_gst_number(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var bill_to_gst_number = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_gst_number');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'bill_to_gst_number' : bill_to_gst_number},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_bill_to_contact_number(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var bill_to_contact_number = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_contact_number');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'bill_to_contact_number' : bill_to_contact_number},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_bill_to_address(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var bill_to_address = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_address');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'bill_to_address' : bill_to_address},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_bill_to_email_id(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var bill_to_email_address = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_email');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'bill_to_email_address' : bill_to_email_address},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_bill_to_contact_person(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var bill_to_contact_person = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_contact_person');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'bill_to_contact_person' : bill_to_contact_person},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }
            
            function change_ship_to_gst_number(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var ship_to_gst_number = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_gst_number');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'ship_to_gst_number' : ship_to_gst_number},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_ship_to_contact_number(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var ship_to_contact_number = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_contact_number');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'ship_to_contact_number' : ship_to_contact_number},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_ship_to_address(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var ship_to_address = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_address');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'ship_to_address' : ship_to_address},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_ship_to_email_id(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var ship_to_email_address = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_email');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'ship_to_email_address' : ship_to_email_address},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_ship_to_contact_person(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var ship_to_contact_person = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_contact_person');?>",
                    method : "POST",
                    data : {'entity_id' : entity_id,
                            'ship_to_contact_person' : ship_to_contact_person},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }
        </script>

        <script type="text/javascript">
            function ship_to_company_name_change(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var ship_to_company_name = item.value;
               
                 $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_company_name');?>",
                    method : "POST",
                    data : {'entity_id': entity_id,
                            'ship_to_company_name': ship_to_company_name},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function bill_to_company_name_change(item)
            {
                var entity_id = $('[name="order_entity_id"]').val();
                var bill_to_company_name = item.value;
               
                 $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_company_name');?>",
                    method : "POST",
                    data : {'entity_id': entity_id,
                            'bill_to_company_name': bill_to_company_name},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }
        </script>
    </body>
</html>
