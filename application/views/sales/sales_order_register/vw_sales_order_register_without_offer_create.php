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
        <title>Create Sales Order</title>
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
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Create Sales Order</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_sales_order_data'?>">Sales Order Register</a></li>
                                            <li class="breadcrumb-item">Enter Sales Order Details</li>
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
                                            <form role="form" name="offer_form" enctype="multipart/form-data" action="<?php echo site_url('sales/sales_order_register/save_sales_order');?>" method="post">
                                                
                                                <!-- <input type="hidden" id="offer_entity_id" name="offer_entity_id" value="<?php echo $entity_id?>" required> -->

                                                <div class="row">
                                                    

                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <label> Customer Name </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="customer_name" name="customer_name">
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($customer_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div>
                                                            <div style="margin-top: 30px;">
                                                                <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-lg-bill-to">
                                                                  Add Customer
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <input type="hidden" id="order_entity_id" name="order_entity_id" value="<?php echo $entity_id?>" required> -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Customer Ship To Address Details</h3>
                                                            </div>
                                                            <input type="hidden" name="customer_id" id="customer_id" class="form-control" size="50" placeholder="Customer Contact Person">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Company </label>
                                                                            <input type="text" name="ship_to_company_name" id="ship_to_company_name" class="form-control" size="50" placeholder="Enter Ship To Company" onchange="ship_to_company_name_change(this);">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <input type="text" name="ship_to_contact_person" id="ship_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="ship_to_email_id" id="ship_to_email_id" class="form-control" size="50" placeholder="Customer Email Id">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Address</label>
                                                                            <textarea class="form-control" id="ship_to_address" name="ship_to_address" rows="3" placeholder="Enter Ship To Address"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="ship_to_contact_number" id="ship_to_contact_number" class="form-control" size="50" placeholder="Customer Contact Number">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Gst No </label>
                                                                            <input type="text" name="customer_ship_to_gst_no" id="customer_ship_to_gst_no" class="form-control" size="50" placeholder="Customer Gst No">
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
                                                                            <input type="text" name="bill_to_company_name" id="bill_to_company_name" class="form-control" size="50" placeholder="Enter Ship To Company" onchange="bill_to_company_name_change(this);">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <input type="text" name="bill_to_contact_person" id="bill_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="bill_to_email_id" id="bill_to_email_id" class="form-control" size="50" placeholder="Customer Email Id">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Address</label>
                                                                            <textarea class="form-control" id="bill_to_address" name="bill_to_address" rows="3" placeholder="Enter Bill To Address"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="bill_to_contact_number" id="bill_to_contact_number" class="form-control" size="50" placeholder="Customer Contact Number">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Gst No </label>
                                                                            <input type="text" name="customer_bill_to_gst_no" id="customer_bill_to_gst_no" class="form-control" size="50" placeholder="Customer Gst No">
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
                                                            <label style="color: #FF0000;"> Order Description *</label>
                                                            <textarea class="form-control" id="order_descrption" name="order_descrption" rows="3" placeholder="Enter Order Description" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Select Employee *</label>
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
                                                            <label style="color: #FF0000;"> Special Customer </label>
                                                            <select class="form-control" style="width: 100%;" id="special_customer" name="special_customer">
                                                                
                                                                <option value="">Not Selected</option>
                                                                <option value="1">S-Sayali</option>
                                                                <option value="2">M-Maitri</option>
                                                                <option value="3">E-ESPL</option>
                                                                <option value="4">K-Kanha</option>
                                                                <option value="5">A-ACG</option>
                                                                <option value="6" selected>X-Not Specified</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Sales Order Type</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="sales_order_type" name="sales_order_type" required>
                                                                <option value="">Select</option>
                                                                <option value="1">Pull Cord (MH)</option>
                                                                <option value="2">Porximity (PS)</option>
                                                                <option value="3">Vibrator Control (VC)</option>
                                                                <option value="4">Treading (TD)</option>    
                                                                <option value="5">Other (OT)</option>
                                                            </select>
                                                        </div>
                                                    </div> -->
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Salutation </label>
                                                            <textarea class="form-control" id="salutation" name="salutation" rows="3" placeholder="Enter Salutation">Dear Sir/Madam, We are pleased to confirm price schedule for your requirement as follows</textarea>
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
                                                            <label> Price Basis</label>
                                                            <input type="text" name="price_basis" id="price_basis" class="form-control" size="50" value="Ex-Works">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Transportation & Insurance </label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="transport_insurance" name="transport_insurance" rows="3" placeholder="Enter Transportation & Insurance">In Buyers Scope</textarea>
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
                                                            <label>Tax </label>
                                                            <textarea class="form-control" id="tax" name="tax" rows="3" placeholder="Enter Tax">GST 18% Extra As per applicable rate</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Delivery Schedule </label>
                                                            <textarea class="form-control" id="delivery_schedule" name="delivery_schedule" rows="3" placeholder="Enter Delivery Schedule">Within 2 weeks</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Mode of Payment </label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="mode_of_payment" name="mode_of_payment" rows="3" placeholder="Enter Mode Of Payment">By Cheque/NEFT</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Mode of Transport </label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="mode_of_transport" name="mode_of_transport" rows="3" placeholder="Enter Mode Of Transport">By Road through reputed transport on freight to pay basis</textarea>
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
                                                            <label> Packing & Forwarding </label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="packing_forwarding" name="packing_forwarding" rows="3" placeholder="Enter Packing & Forwarding Charges">3%</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label >Guarantee/Waranty </label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="guarantee_warrenty" name="guarantee_warrenty" rows="3" placeholder="Enter Guarantee/Waranty">12 months from date of dispatch</textarea>
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
                                                            <label> Payment Term </label>
                                                            <!-- <select class="form-control select2bs4" style="width: 100%;" id="payment_term" name="payment_term" required>
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($payment_term_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->payement_terms_category;?></option>
                                                                <?php endforeach;?>
                                                            </select> -->

                                                            <textarea class="form-control" id="payment_term" name="payment_term" rows="3" placeholder="Enter Payment Term" >100% within 30 days after receipt of material</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Special Instruction </label>
                                                            <textarea class="form-control" id="special_instruction" name="special_instruction" rows="3" placeholder="Enter Special Instruction"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Terms & Condition </label>
                                                            <input type="text" name="terms_conditions" id="terms_conditions" class="form-control" size="50">
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
                                                            <div>
                                                                <div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
                                                                <a data-toggle="modal" data-target="#modal-product" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
                                                                Select Product
                                                                </a>
                                                            </div>

                                                            <div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
                                                                    <a data-toggle="modal" data-target="#modal-lg-product-add" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
                                                                    Add Product
                                                                    </a>
                                                                </div>
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
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                   </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Purchase Order Number *</label>
                                                            <input type="text" name="purchase_order_number" id="purchase_order_number" class="form-control"  size="50" placeholder="Enter Purchase Order Number" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Purchase Order Date *</label>
                                                            <input type="date" name="purchase_order_date" id="purchase_order_date" class="form-control" size="50" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">   
                                                            <label for="order_attachment">Attachment</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="order_attachment[]" multiple id="order_attachment">
                                                                    <label class="custom-file-label" for="order_attachment">Choose Attachment</label>
                                                                </div>
                                                            </div>
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
                                <table id="product_details_tablezz" class="table table-bordered table-striped">
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
                                        <!-- <?php
                                            $no = 0;
                                            foreach ($product_list as $row):
                                              $no++;
                                              $entity_id = $row->entity_id;
                                        ?> -->
                                        <tr id="d1">
                                            <td><input type="checkbox" class="checkboxes" id="product_checkbox" name="product_checkbox" value="<?php echo $row->entity_id ?>"></td>
                                            <td style="display: none;"><?php echo $row->entity_id;?></td>
                                            <td><?php echo $row->product_id;?></td>
                                            <td><?php echo $row->product_name;?></td>
                                            <td><?php echo $row->product_short_description;?></td>
                                            <td><?php echo $row->price;?></td>
                                       </tr>
                                       <!-- <?php endforeach;?> -->
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
        <!-- jQuery -->

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
                                        <label style="color: #FF0000;">HSN Code *</label>
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
                                        <label style="color: #FF0000;">Category *</label>
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
                                        <label style="color: #FF0000;"> Sub Category *</label>
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
                                        <label style="color: #FF0000;"> Product Name *</label>
                                        <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter Product Name">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Product Long Description *</label>
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
                                        <label style="color: #FF0000;">Warranty *</label>
                                        <input type="text" name="product_warranty" id="product_warranty" class="form-control" placeholder="Enter Product Warranty">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">Unit *</label>
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
                                        <label style="color: #FF0000;">Price *</label>
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

                            <!-- <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">Address Type *</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="address_type" name="address_type" required>
                                            
                                            <option value="3">Both(Bill To & Ship To)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Address *</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address" required></textarea>
                                    </div>
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">State Name *</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="state_id" name="state_id" required>
                                            <option value="">No Selected</option>
                                            <?php foreach($state_list as $row):?>
                                            <option value="<?php echo $row->entity_id;?>"><?php echo $row->state_name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div> 

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">City Name *</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="city_id" name="city_id" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">State Code *</label>
                                        <input type="text" name="customer_state_code" id="customer_state_code" class="form-control" size="50" placeholder="State Code" required readonly>
                                    </div>
                                </div>
                            </div> 

                            <!-- <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Pin Code <span style="color: #FF0000;"></span> </label>
                                        <input type="number" name="customer_pin_code" id="customer_pin_code" class="form-control" size="50" placeholder="Enter Customer Pin Code">
                                    </div>
                                </div>

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
                            </div> -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Contact Person *</label>
                                        <input type="text" name="contact_person" id="contact_person" class="form-control" size="50" placeholder="Enter Contact Person" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
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

                                <!-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Alternate Contact Number </label>
                                        <input type="number" name="second_contact_no" id="second_contact_no" class="form-control" size="50" placeholder="Enter Alternate Contact Number">
                                    </div>
                                </div> -->

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> What's up Number </label>
                                        <input type="number" name="whatsup_no" id="whatsup_no" class="form-control" size="50" placeholder="Enter What's up Number">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> GST Number </label>
                                        <input type="text" name="customer_gst_number" id="customer_gst_number" class="form-control" size="50" placeholder="Enter GST Number" required>
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
            //load data for edit
                $('#customer_name').change(function(){
                    var id=$(this).val();
                    $.ajax({
                        url : "<?php echo site_url('sales/sales_order_register/get_all_customer_data_ship_to');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val = 
                                $('[name="ship_to_company_name"]').val(data[i].customer_name);
                                $('[name="customer_id"]').val(data[i].entity_id);
                                $('[name="ship_to_contact_person"]').val(data[i].contact_person);
                                $('[name="ship_to_email_id"]').val(data[i].email_id);
                                $('[name="ship_to_contact_number"]').val(data[i].first_contact_no);
                                $('[name="customer_ship_to_gst_no"]').val(data[i].gst_no);
                                $('[name="ship_to_address"]').val(data[i].address);
                            })
                        }
                    });
                    return false;
                });
        </script>

        <script type="text/javascript">
            //load data for edit
                $('#customer_name').change(function(){
                    var id=$(this).val();
                    $.ajax({
                        url : "<?php echo site_url('sales/sales_order_register/get_all_customer_data_bill_to');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val = 
                                $('[name="bill_to_company_name"]').val(data[i].customer_name);
                                $('[name="bill_to_contact_person"]').val(data[i].contact_person);
                                $('[name="bill_to_email_id"]').val(data[i].email_id);
                                $('[name="bill_to_contact_number"]').val(data[i].first_contact_no);
                                $('[name="customer_bill_to_gst_no"]').val(data[i].gst_no);
                                $('[name="bill_to_address"]').val(data[i].address);
                            })
                        }
                    });
                    return false;
                });
        </script>

        <!-- <script type="text/javascript">
            $(document).ready(function(){
                //call function get data edit
                get_data_edit();

                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="offer_entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('sales/sales_order_register/get_order_details_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="order_entity_id"]').val(data[i].entity_id);
                                $('[name="offer_number"]').val(data[i].offer_no);
                                $('[name="sales_order_number"]').val(data[i].sales_order_no);
                                $('[name="enquiry_number"]').val(data[i].enquiry_no);
                                $('[name="customer_name"]').val(data[i].customer_id).trigger('change');
                                $('[name="employee_id"]').val(data[i].order_engg_name).trigger('change');
                                $('[name="order_descrption"]').val(data[i].sales_order_description);
                                //$('[name="order_terms_condition"]').val(data[i].terms_conditions_id).trigger('change');
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

                                $('[name="ship_to_contact_person"]').val(data[i].customer_ship_to_contact_person);
                                $('[name="ship_to_email_id"]').val(data[i].customer_ship_to_contact_person_mail);
                                $('[name="ship_to_address"]').val(data[i].customer_ship_to_address);
                                $('[name="ship_to_contact_number"]').val(data[i].customer_ship_to_contact_person_no);
                                $('[name="customer_ship_to_gst_no"]').val(data[i].customer_ship_to_gst_no);
                                
                                $('[name="bill_to_contact_person"]').val(data[i].customer_bill_to_contact_person);
                                $('[name="bill_to_email_id"]').val(data[i].customer_bill_to_contact_person_mail);
                                $('[name="bill_to_address"]').val(data[i].customer_bill_to_address);
                                $('[name="bill_to_contact_number"]').val(data[i].customer_bill_to_contact_person_no);
                                $('[name="customer_bill_to_gst_no"]').val(data[i].customer_bill_to_gst_no);

                            });
                        }
                    });
                }
            });
        </script> -->

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

        <!-- <script>
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
        </script> -->

        <script>
            $(document).ready( function () {
                $('#example1').DataTable();
                $('#product_details_tablezz').DataTable();
                $('#accessories_details_table').DataTable();
            } );
        </script>

        <script>
           $(function()
           {
                $("#product_checkbox_submited").on('click', function(event){
                    //var offer_entity_id = document.getElementById('offer_entity_id').value;
                    var customer_id = document.getElementById('customer_id').value;
                    var bill_to_company_name = document.getElementById('bill_to_company_name').value;
                    var bill_to_contact_person = document.getElementById('bill_to_contact_person').value;
                    var bill_to_email_id = document.getElementById('bill_to_email_id').value;
                    var bill_to_address = document.getElementById('bill_to_address').value;
                    var bill_to_contact_number = document.getElementById('bill_to_contact_number').value;
                    var customer_bill_to_gst_no = document.getElementById('customer_bill_to_gst_no').value;
                    var ship_to_company_name = document.getElementById('ship_to_company_name').value;
                    var ship_to_contact_person = document.getElementById('ship_to_contact_person').value;
                    var ship_to_email_id = document.getElementById('ship_to_email_id').value;
                    var ship_to_address = document.getElementById('ship_to_address').value;
                    var ship_to_contact_number = document.getElementById('ship_to_contact_number').value;
                    var customer_ship_to_gst_no = document.getElementById('customer_ship_to_gst_no').value;

                    var order_descrption = document.getElementById('order_descrption').value;
                    var employee_id = document.getElementById('employee_id').value;
                    var terms_conditions = document.getElementById('terms_conditions').value;
                    //var delivery_period = document.getElementById('delivery_period').value;
                    //var order_freight = document.getElementById('order_freight').value;
                    //var freight_charges = document.getElementById('freight_charges').value;
                    var dispatch_address = document.getElementById('dispatch_address').value; 
                    var delivery_instruction = document.getElementById('delivery_instruction').value;
                    //var packing_forwarding = document.getElementById('order_pf').value;
                    var special_customer = document.getElementById('special_customer').value;

                    /*var sales_order_type = document.getElementById('sales_order_type').value;*/
                    //var packing_forwarding_charges = document.getElementById('packing_forwarding_charges').value;
                    //var payment_term = document.getElementById('payment_term').value;
                    var special_instruction = document.getElementById('special_instruction').value;
                    //var order_insurance = document.getElementById('order_insurance').value;
                    //var insurance_charges = document.getElementById('insurance_charges').value;

                    var salutation = document.getElementById('salutation').value;
                    var price_basis = document.getElementById('price_basis').value;
                    var transport_insurance = document.getElementById('transport_insurance').value;
                    var tax = document.getElementById('tax').value;
                    var delivery_schedule = document.getElementById('delivery_schedule').value;
                    var mode_of_payment = document.getElementById('mode_of_payment').value;
                    var mode_of_transport = document.getElementById('mode_of_transport').value;
                    var guarantee_warrenty = document.getElementById('guarantee_warrenty').value;
                    var payment_term = document.getElementById('payment_term').value;
                    var packing_forwarding = document.getElementById('packing_forwarding').value;
                    //var special_customer = document.getElementById('special_customer').value;

                    var product_checkbox = [];
                    $.each($("input[name='product_checkbox']:checked"), function(){            
                        product_checkbox.push($(this).val());
                    });

                    $.ajax({
                        url:"<?php echo site_url('sales/sales_order_register/insert_order_without_offer');?>",
                        type: 'POST',
                        data: {'customer_id': customer_id,'bill_to_company_name': bill_to_company_name,'bill_to_contact_person': bill_to_contact_person,'bill_to_email_id': bill_to_email_id,'bill_to_address': bill_to_address,'bill_to_contact_number': bill_to_contact_number,'customer_bill_to_gst_no': customer_bill_to_gst_no,'ship_to_company_name': ship_to_company_name,'ship_to_contact_person': ship_to_contact_person,'ship_to_email_id': ship_to_email_id,'ship_to_address': ship_to_address,'ship_to_contact_number': ship_to_contact_number,'customer_ship_to_gst_no': customer_ship_to_gst_no,'product_checkbox': product_checkbox,'order_descrption': order_descrption, 'employee_id': employee_id, 'terms_conditions': terms_conditions, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding,'special_customer': special_customer, 'payment_term': payment_term, 'special_instruction': special_instruction, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty},
                            success: function(data){
                                window.location.href = "update_sales_order_data_without_offer/" + data;
                            },
                            error: function(data){
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

            function ship_to_contact_personsss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var ship_to_contact_person = item.value;
               //alert(order_entity_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_contact_person');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_contact_person': ship_to_contact_person},
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

            function ship_to_email_idss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var ship_to_email_id = item.value;
               // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_email_id');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_email_id': ship_to_email_id},
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

            function ship_to_addressss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var ship_to_address = item.value;
               // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_address');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_address': ship_to_address},
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

            function ship_to_contact_numberss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var ship_to_contact_number = item.value;
               // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_contact_no');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_contact_number': ship_to_contact_number},
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

            function ship_to_gst_noss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var customer_ship_to_gst_no = item.value;
               // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_gst_no');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'customer_ship_to_gst_no': customer_ship_to_gst_no},
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

            function bill_to_contact_personsss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var bill_to_contact_person = item.value;
               //alert(order_entity_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_contact_person');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_contact_person': bill_to_contact_person},
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

            function bill_to_email_idss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var bill_to_email_id = item.value;
               // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_email_id');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_email_id': bill_to_email_id},
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

            function bill_to_addressss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var bill_to_address = item.value;
               // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_address');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_address': bill_to_address},
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

            function bill_to_contact_numberss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var bill_to_contact_number = item.value;
               // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_contact_no');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_contact_number': bill_to_contact_number},
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

            function bill_to_gst_noss(item)
            {
               var order_entity_id = $('[name="order_entity_id"]').val();

               var customer_ship_to_gst_no = item.value;
               // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_gst_no');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'customer_ship_to_gst_no': customer_ship_to_gst_no},
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
            function ship_to_company_name_change(item)
            {
               var offer_entity_id = $('[name="offer_entity_id"]').val();

               var ship_to_company_name = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_ship_to_company_name_edit_page');?>",
                    method : "POST",
                    data : {'offer_entity_id': offer_entity_id,
                            'ship_to_company_name': ship_to_company_name},
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

            function bill_to_company_name_change(item)
            {
               var offer_entity_id = $('[name="offer_entity_id"]').val();

               var bill_to_company_name = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/update_bill_to_company_name_edit_page');?>",
                    method : "POST",
                    data : {'offer_entity_id': offer_entity_id,
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

        <script>
            $(document).on('click', '#add_address', function () {

                /*var address_type = $("#address_type").val();
                var address = $("#address").val();*/
                var state_id = $("#state_id").val();
                var city_id = $("#city_id").val();
                /*var customer_pin_code = $("#customer_pin_code").val();*/
                var customer_state_code = $("#customer_state_code").val();
                var customer_gst_number = $("#customer_gst_number").val();
                /*var customer_pan_number = $("#customer_pan_number").val();*/
                var contact_person = $("#contact_person").val();
                var contact_person_email_id = $("#contact_person_email_id").val();
                var first_contact_no = $("#first_contact_no").val();
               /* var second_contact_no = $("#second_contact_no").val();*/
                var whatsup_no = $("#whatsup_no").val();
                var customer_name = $("#pop_up_customer_name").val();
                var customer_type = $("#customer_type").val();
                
                if(state_id != "" && city_id != "" && customer_state_code != "" && contact_person != "" && contact_person_email_id != "" && first_contact_no != "" && customer_name != "" && customer_type != "")
                {
                    $.ajax({
                            url : "<?php echo site_url('master/customer_master/save_pop_up_address');?>",
                            type : "POST",
                            data: {'state_id': state_id , 'city_id': city_id , 'customer_state_code': customer_state_code , 'customer_gst_number': customer_gst_number , 'contact_person': contact_person , 'contact_person_email_id': contact_person_email_id , 'first_contact_no': first_contact_no , 'whatsup_no': whatsup_no , 'customer_name': customer_name , 'customer_type': customer_type},
                            success : function(data) {
                                data = data.trim();
                                location.reload();
                            },
                            error : function(data) {
                                alert("Failed!!");
                            }
                    });
                }else{
                    alert("Enter All Details");
                }
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
         
                $('#state_id').change(function(){ 
                    var id=$(this).val();
                    $.ajax({
                        url : "<?php echo site_url('master/customer_master/get_city_name');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){ 
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                 html += '<option value='+data[i].entity_id+'>'+data[i].city_name+'</option>';
                            }
                                $('#city_id').html(html);
                        }
                    });
                    return false;
                });     
            });
        </script>

        <script type="text/javascript">
            //load data for edit
            $('#state_id').change(function(){
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/get_state_code');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val = 
                            $('[name="customer_state_code"]').val(data[i].state_code);
                        })
                    }
                });
                return false;
            });
        </script>
    </body>
</html>
