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
        <title>Update Sales Order</title>
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
                                    <h1 class="card-title">Update Sales Order</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_sales_order_data'?>">Sales Order Register</a></li>
                                            <li class="breadcrumb-item">Update Sales Order Details Of Id :- <?php  echo $entity_id; ?> </li>
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
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Sales Order Number </label>
                                                            <input type="text" name="sales_order_number" id="sales_order_number" class="form-control"  size="50" placeholder="Enter Sales Order Number" readonly>
                                                        </div>
                                                    </div>

                                                    

                                                    <div class="col-sm-3">
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

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Contact Person </label>
                                                            <input type="text" name="ship_to_contact_person" id="ship_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person"  required readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Contact Number </label>
                                                            <input type="text" name="ship_to_contact_number" id="ship_to_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" required readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="display: none;">
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Customer Ship To Address Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label style="color: #FF0000;"> Ship To Company * </label>
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="ship_to_party_id" name="ship_to_party_id" required>
                                                                                <option value="">Not Selected</option>
                                                                                <?php foreach($ship_to_party as $row):?>
                                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->party_name;?></option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <input type="text" name="ship_to_contact_person" id="ship_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" onchange="change_ship_to_contact_person(this);" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="ship_to_email_id" id="ship_to_email_id" class="form-control" size="50" placeholder="Customer Email Id" onchange="change_ship_to_email_id(this);" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Address</label>
                                                                            <textarea class="form-control" id="ship_to_address" name="ship_to_address" rows="3" placeholder="Enter Ship To Address" onchange="change_ship_to_address(this);" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="ship_to_contact_number" id="ship_to_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" onchange="change_ship_to_contact_number(this);" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> GST Number </label>
                                                                            <input type="text" name="ship_to_gst_number" id="ship_to_gst_number" class="form-control" size="50" placeholder="Customer GST Number" readonly >
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
                                                                            <label style="color: #FF0000;"> Bill To Company * </label>
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bill_to_party_id" name="bill_to_party_id" required>
                                                                                <option value="">Not Selected</option>
                                                                                <?php foreach($bill_to_party as $row):?>
                                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->party_name;?></option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <input type="text" name="bill_to_contact_person" id="bill_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" onchange="change_bill_to_contact_person(this);" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="bill_to_email_id" id="bill_to_email_id" class="form-control" size="50" placeholder="Customer Email Id" onchange="change_bill_to_email_id(this);" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Address</label>
                                                                            <textarea class="form-control" id="bill_to_address" name="bill_to_address" rows="3" placeholder="Enter Bill To Address" onchange="change_bill_to_address(this);" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="bill_to_contact_number" id="bill_to_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" onchange="change_bill_to_contact_number(this);" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> GST Number </label>
                                                                            <input type="text" name="bill_to_gst_number" id="bill_to_gst_number" class="form-control" size="50" placeholder="Customer GST Number" readonly>
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
                                                            <label style="color: #FF0000;"> Select Employee * </label>
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
                                                            <label style="color: #FF0000;"> Special Customer *</label>
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
                                                            <select class="form-control select2bs4" style="width: 100%;" id="sales_order_type" name="sales_order_type" required disabled>
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
                                                            <textarea class="form-control" id="tax" name="tax" rows="3" placeholder="Enter Tax">GST Extra As per applicable rate</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Delivery Schedule </label>
                                                            <textarea class="form-control" id="delivery_schedule" name="delivery_schedule" rows="3" placeholder="Enter Delivery Schedule">Within 2 -3 weeks</textarea>
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
                                                            <label> Mode of Transport</label>
                                                            <!-- <select class="form-control" style="width: 100%;" id="offer_pf" name="offer_pf">
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hidePackFor()">Customer Scope</option>
                                                                <option value="2" onClick="showPackFor()">Company Scope</option>
                                                            </select> -->
                                                            <textarea class="form-control" id="mode_of_transport" name="mode_of_transport" rows="3" placeholder="Enter Mode Of Transport">By Road through reputed transport on freight paid basis</textarea>
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
                                                            <textarea class="form-control" id="packing_forwarding" name="packing_forwarding" rows="3" placeholder="Enter Packing & Forwarding Charges">Included</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label >Guarantee/Waranty</label>
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
                                                            <label > Payment Term </label>
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
                                                            <label > Terms & Condition</label>
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
                                                                                    <textarea class="form-control" id="product_description" name="product_description" style="width: 300px;" rows="3" placeholder="Enter Product Description" onchange="change_ProductDescription(this);"><?php echo $row->product_custom_description;?></textarea>   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->delivery_period;?>" id="offer_product_delivery_period" name="offer_product_delivery_period" placeholder="Enter Delivery Period" style="width: 200px;" onchange="change_DeliveryPeriod(this);">    
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->product_warranty;?>" id="product_warranty" name="product_warranty" placeholder="Enter Warranty" style="width: 150px;" onchange="change_Warranty(this);">   
                                                                                </td>
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
                                                                                <td><?php echo $row->discount_amt;?></td>
                                                                                <td><?php echo $row->unit_discounted_price;?></td>
                                                                                <td><?php echo $row->total_amount_without_gst;?></td>
                                                                                <td><?php echo $row->cgst_discount;?></td>
                                                                                <td><?php echo $row->sgst_discount;?></td>
                                                                                <td><?php echo $row->igst_discount;?></td>
                                                                                <td><?php echo $cgst_amount;?><br><br><?php echo $sgst_amount;?><br><br><?php echo $igst_amount;?></td>
                                                                                <td><?php echo $row->total_amount_with_gst;?></td>
                                                                                <td>
                                                                                    <a class="btn btn-sm btn-danger" onclick="delete_order_product(<?php echo $order_reational_entity_id; ?>)"><i class="fas fa-trash"></i> </a>
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
                                                    <div class="col-md-12">
                                                      <!-- general form elements disabled -->
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Product Accessories Details</h3>
                                                            </div>
                                                            <div>
                                                                <div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
                                                                <a data-toggle="modal" data-target="#modal-product-accessories" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
                                                                Add Accessories
                                                                </a>
                                                            </div>
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
                                                                                <th>Action</th>
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
                                                                                    <input type="text" class="form-control" value="<?php echo $row->price;?>" id="product_price" name="product_price" placeholder="Enter Price" style="width: 100px;" onchange="change_accessories_Price(this);">   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->qty;?>" id="product_qty" name="product_qty" placeholder="Enter Qty" style="width: 100px;" onchange="change_accessories_Qty(this);">   
                                                                                </td>
                                                                                <td><?php echo $product_basic_value;?></td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->discount;?>" id="product_dis_per" name="product_dis_per" placeholder="Enter Discount%" style="width: 100px;" onchange="change_accessories_DisPercentage(this);">
                                                                                </td>
                                                                                <td><?php echo $row->discount_amount;?></td>
                                                                                <td><?php echo $row->unit_discounted_price;?></td>
                                                                                <td><?php echo $row->total_amount_without_gst;?></td>
                                                                                <td><?php echo $row->cgst_percentage;?></td>
                                                                                <td><?php echo $row->sgst_percentage;?></td>
                                                                                <td><?php echo $row->igst_percentage;?></td>
                                                                                <td><?php echo $cgst_amount;?><br><br><?php echo $sgst_amount;?><br><br><?php echo $igst_amount;?></td>
                                                                                <td><?php echo $row->total_amount_with_gst;?></td>
                                                                                <td>
                                                                                    <a class="btn btn-sm btn-danger" onclick="delete_order_product_accessories(<?php echo $order_accessories_reational_entity_id; ?>)"><i class="fas fa-trash"></i> </a>
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
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Purchase Order Number *</label>
                                                            <input type="text" name="purchase_order_number" id="purchase_order_number" class="form-control"  size="50" placeholder="Enter Purchase Order Number" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Purchase Order Date *</label>
                                                            <input type="date" name="purchase_order_date" id="purchase_order_date" class="form-control" size="50" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">   
                                                            <label for="order_attachment">Attachment</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="order_attachment[]" multiple id="order_attachment">
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
                                                            <select class="form-control" style="width: 100%;" id="order_status" name="order_status" required>
                                                                <option value="">Not Selected</option>
                                                                <!-- <option value="1">Pending Offers</option> -->
                                                                <option value="2">Order Created</option>
                                                                <option value="3">Order Canceled</option>
                                                            </select>
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
                                            

                                            <div class="card-body">
                                                <center>

                                                    <button type="submit" id="refreshsssss" class="btn btn-primary" style="margin-top: -145px; margin-left: -200px;">
                                                        Refresh
                                                    </button>
                                                </center>
                                            </div>
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
                                <!-- <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="product_checkbox_submited">Save</button>
                                </div> -->
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Accessories For *</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="accessories_for" id="accessories_for">
                                            <option value="">No Selected</option>
                                                <?php foreach($order_product_list as $row):?>
                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->product_name;?></option>
                                                <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Accessories *</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="accessories" id="accessories">
                                            <option value="">No Selected</option>
                                                <?php foreach($accessories_list as $row):?>
                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->Product_name;?></option>
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
                                <div class="col-sm-3">
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

                                <div class="col-sm-3">
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

                                <div class="col-sm-3">
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
                                $('[name="sales_order_type"]').val(data[i].sales_order_type).trigger('change');

                                $('[name="bill_to_party_id"]').val(data[i].bill_to_address).trigger('change');
                                $('[name="ship_to_party_id"]').val(data[i].ship_to_address).trigger('change');
                                $('[name="order_status"]').val(data[i].status).trigger('change');

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
            $('#ship_to_party_id').change(function(){
                var entity_id = $('[name="order_entity_id"]').val();
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/get_ship_to_party_data_update_page');?>",
                    method : "POST",
                    data : {id: id , entity_id: entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val = 
                            $('[name="ship_to_contact_person"]').val(data[i].Ship_to_contact_person);
                            $('[name="ship_to_email_id"]').val(data[i].Ship_to_email_id);
                            $('[name="ship_to_address"]').val(data[i].Ship_to_address);
                            $('[name="ship_to_contact_number"]').val(data[i].Ship_to_contact_number);
                            $('[name="ship_to_gst_number"]').val(data[i].Ship_to_gst_no);
                        })
                    }
                });
                return false;
            });
        </script> -->

        <!-- <script type="text/javascript">
            //load data for edit
            $('#bill_to_party_id').change(function(){
                var entity_id = $('[name="order_entity_id"]').val();
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/get_bill_to_party_data_update_page');?>",
                    method : "POST",
                    data : {id: id , entity_id: entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val =
                            $('[name="bill_to_contact_person"]').val(data[i].Bill_to_contact_person);
                            $('[name="bill_to_email_id"]').val(data[i].Bill_to_email_id);
                            $('[name="bill_to_address"]').val(data[i].Bill_to_address);
                            $('[name="bill_to_contact_number"]').val(data[i].Bill_to_contact_number);
                            $('[name="bill_to_gst_number"]').val(data[i].Bill_to_gst_no);
                        })
                    }
                });
                return false;
            });
        </script> -->

        <script type="text/javascript">
            $(document).ready(function(){

                $('#category_id').change(function(){ 
                    var id=$(this).val();
                    $.ajax({
                            url : "<?php echo site_url('master/product_master/get_sub_category');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            /*success: function(data){
                                 
                                var html = '';
                                var i;
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].entity_id+'>'+data[i].vehicle_model_name+'</option>';
                                }
                                $('#pop_up_vehicle_model').html(html);
                            }*/
                            
                            success: function(response){
                                $.each(response,function(index,data){
                                   $('#sub_category_id').append('<option value="'+data['entity_id']+'">'+data['subcategory_name']+'</option>');
                                });
                            }
                        });
                    return false;
                });

                /*$('#sub_category_id').change(function(){ 
                    var category_id = $("#category_id").val();
                    var sub_category_id = $("#sub_category_id").val();
                    $.ajax({
                        url : "<?php echo site_url('master/product_master/get_product_id');?>",
                        method : "POST",
                        data :{'category_id' :category_id , 'sub_category_id' :sub_category_id},
                        async : true,
                        dataType : 'json',
                        success: function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val = 
                                $('[name="product_id"]').val(data[i].product_id);                              
                            })
                        }  
                    });
                });*/

                $('#product_id').change(function(){ 
                    var id=$(this).val();
                    $.ajax({
                        url : "<?php echo site_url('master/product_master/product_id_check');?>",
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
                    var terms_conditions = document.getElementById('terms_conditions').value;
                    //var delivery_period = document.getElementById('delivery_period').value;
                    //var order_freight = document.getElementById('order_freight').value;
                    //var freight_charges = document.getElementById('freight_charges').value;
                    var dispatch_address = document.getElementById('dispatch_address').value; 
                    var delivery_instruction = document.getElementById('delivery_instruction').value;
                    //var order_pf = document.getElementById('order_pf').value;
                    var special_customer = document.getElementById('special_customer').value;
                    //var packing_forwarding_charges = document.getElementById('packing_forwarding_charges').value;
                    var payment_term = document.getElementById('payment_term').value;
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

                    var product_checkbox = [];
                    $.each($("input[name='product_checkbox']:checked"), function(){            
                        product_checkbox.push($(this).val());
                    });

                    $.ajax({
                        url:"<?php echo site_url('sales/sales_order_register/update_order_product');?>",
                        type: 'POST',
                        data: {'order_entity_id': order_entity_id, 'product_checkbox': product_checkbox,'order_descrption': order_descrption, 'employee_id': employee_id, 'terms_conditions': terms_conditions, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'special_customer': special_customer, 'payment_term': payment_term, 'special_instruction': special_instruction, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty},
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
                        //location.reload();
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
                        //location.reload();
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
                        //location.reload();
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
                        //location.reload();
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
                        //location.reload();
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
                        //location.reload();
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
                        //location.reload();
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

            //load data for edit
            $('#accessories_for').change(function(){
                var id=$(this).val();

                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/get_accessories_qty');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val = 
                            $('[name="accessories_qty"]').val(data[i].rfq_qty);
                        })
                    }
                });
                return false;
            });
        </script>

        <script type="text/javascript">
            $(document).on('click', '#update_new_product', function () {

                var entity_id = $("#order_entity_id").val();
                var order_descrption = document.getElementById('order_descrption').value;
                var employee_id = document.getElementById('employee_id').value;
                var special_customer = document.getElementById('special_customer').value;
                var salutation = document.getElementById('salutation').value;
                var price_basis = document.getElementById('price_basis').value;
                var transport_insurance = document.getElementById('transport_insurance').value;
                var tax = document.getElementById('tax').value; 
                var delivery_schedule = document.getElementById('delivery_schedule').value;
                var mode_of_payment = document.getElementById('mode_of_payment').value;
                var mode_of_transport = document.getElementById('mode_of_transport').value;
                var dispatch_address = document.getElementById('dispatch_address').value;
                var delivery_instruction = document.getElementById('delivery_instruction').value;
                var packing_forwarding = document.getElementById('packing_forwarding').value;
                var guarantee_warrenty = document.getElementById('guarantee_warrenty').value;
                var payment_term = document.getElementById('payment_term').value;
                var special_instruction = document.getElementById('special_instruction').value;
                var terms_conditions = document.getElementById('terms_conditions').value;

                var pop_up_hsn_code = $("#pop_up_hsn_code").val();
                var category_id = $("#category_id").val();
                //var sub_category_id = $("#sub_category_id").val();
                var product_id = $("#product_id").val();
                var product_name = $("#product_name").val();
                var product_long_desc = $("#product_long_desc").val();
                var product_sourcing_type = $("#product_sourcing_type").val();
                var product_warranty = $("#product_warranty").val();
                var product_unit = $("#product_unit").val();
                var product_price = $("#pop_up_product_price").val();

                if(entity_id != "" && pop_up_hsn_code != "" && category_id != "" && product_id !="" && product_name != "" && product_long_desc !="" && product_warranty != "" && product_unit != "" && product_price !="")
                {   
                    $.ajax({
                            url : "<?php echo site_url('sales/sales_order_register/update_new_product_in_sales_order');?>",
                            type : "POST",
                            data: {'entity_id': entity_id,'order_descrption': order_descrption, 'employee_id': employee_id, 'terms_conditions': terms_conditions, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'special_customer': special_customer, 'payment_term': payment_term, 'special_instruction': special_instruction, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty,'pop_up_hsn_code': pop_up_hsn_code, 'category_id': category_id, 'product_id': product_id, 'product_name': product_name, 'product_long_desc': product_long_desc, 'product_sourcing_type': product_sourcing_type, 'product_warranty': product_warranty, 'product_unit': product_unit, 'product_price': product_price},
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


        <script type="text/javascript">
            $(document).on("click", "#refreshsssss", function(){
                window.location.reload(true);
            });
        </script>
    </body>
</html>
