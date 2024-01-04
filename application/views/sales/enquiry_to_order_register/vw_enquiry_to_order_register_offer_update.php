<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
    $data = site_url('dashboard');
    $daa = header("location:$data");
    redirect($daa);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Update Offer</title>
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

                $enquiry_attachment_data = $enquiry_result->row_array();
                $enquiry_attachment_img = $enquiry_attachment_data['attachment'];
                $enquiry_image_attachment_name = explode(',',$enquiry_attachment_img);
                array_pop($enquiry_image_attachment_name);


                $attachment_data = $offer_result->row_array();
                //print_r($attachment_data);
                $offer_category = $attachment_data['offer_category'];
                $attachment_img = $attachment_data['attachment'];
                $image_attachment_name = explode(',',$attachment_img);
                array_pop($image_attachment_name);

                $this->db->select_sum('total_amount_with_gst');
                $this->db->from('offer_product_relation');
                $where = '(offer_product_relation.offer_id = "'.$entity_id.'")';
                $this->db->where($where);
                $product_amount = $this->db->get();
                $product_amount_result =  $product_amount->row_array();

                if(!empty($product_amount_result))
                {
                    $product_amount_without_gst_format = $product_amount_result['total_amount_with_gst'];
                    $Product_amt = number_format((float)$product_amount_without_gst_format, 2, '.', '');
                }
                else{
                    $Product_amt = 0;
                }

                
                    $Service_amt = 0;
                
                $Offer_order_val = $Product_amt + $Service_amt;
                $Offer_order_amount = number_format((float)$Offer_order_val, 2, '.', '');

                if(!empty($Offer_order_amount))
                {
                    $Offer_value = $Offer_order_amount;
                }else{
                    $this->db->select('offer_value');
                    $this->db->from('offer_register');
                    $where = '(offer_register.entity_id = "'.$entity_id.'")';
                    $this->db->where($where);
                    $offer_register = $this->db->get();
                    $offer_register_result =  $offer_register->row_array();

                    $Offer_value = number_format((float)$offer_register_result['Offer_value'], 2, '.', '');
                }

                $this->db->select('offer_product_relation.*');
                $this->db->from('offer_product_relation');
                $where = '(offer_product_relation.offer_id = "'.$entity_id.'" )';
                $this->db->where($where);
                $offer_product_relation_count = $this->db->get();
                $offer_product_relation_count_data = $offer_product_relation_count->num_rows();

                date_default_timezone_set("Asia/Calcutta");
                $tracking_date = date('Y-m-d');
            ?>
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Update Offer</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_all_enquiry_to_order_data'?>">Enquiry To Order Register</a></li>
                                            <li class="breadcrumb-item">Update Offer Details Of Id :- <?php  echo $entity_id; ?> </li>
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
                                            <h3 class="card-title">Offer Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="offer_form" id="offer_form" enctype="multipart/form-data" action="<?php echo site_url('sales/enquiry_to_order_register/update_offer');?>" method="post">
                                                
                                                <input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Offer Number </label>
                                                            <input type="text" name="offer_number" id="offer_number" class="form-control"  size="50" placeholder="Enter Offer Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Enquiry Number </label>
                                                            <input type="text" name="enquiry_number" id="enquiry_number" class="form-control"  size="50" placeholder="Enter Enquiry Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" style="display: none;">
                                                        <div class="form-group">
                                                            <label> Customer Id </label>
                                                            <input type="text" name="customer_name" id="customer_id" class="form-control"  size="50" placeholder="Enter Enquiry Number" readonly>
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
                                                            <label>  Enquiry Attachment </label>
                                                            <?php 
                                                                foreach ($enquiry_image_attachment_name as $key => $value) {
                                                            ?>
                                                            <p>
                                                                <a target="_blank" href="<?php echo base_url();?>assets/enquiry_attachment/<?php echo $value;?>"><?php echo $value;?></a>
                                                            </p>
                                                            <?php }?>
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
                                                                            <input type="text" name="enquiry_contact_person" id="enquiry_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" onchange="change_contact_person(this);">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="enquiry_email_id" id="enquiry_email_id" class="form-control" size="50" placeholder="Customer Email Id" onchange="change_email_id(this);">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="enquiry_contact_number" id="enquiry_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" onchange="change_contact_no(this);">
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
                                                            <label style="color: #FF0000;"> Offer Description * </label>
                                                            <textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enter Enquiry Description" required></textarea>
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
                                                            <label style="color: #FF0000;"> Offer Type *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="offer_type" name="offer_type" required>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Budgatory</option>
                                                                <option value="2">One Time Offer</option>
                                                                <option value="3">Rate Contract</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Offer Date *</label>
                                                            <input type="date" name="offer_date" id="offer_date" class="form-control" size="50" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Offer Close Date *</label>
                                                            <input type="date" name="offer_close_date" id="offer_close_date" class="form-control" size="50" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Winning Chance *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="winning_chance" name="winning_chance" required>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Chance A</option>
                                                                <option value="2">Chance B</option>
                                                                <option value="3">Chance C</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-5">
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                           <label style="color: #FF0000;"> BOQ Applicable *</label>
                                                            <div class="col-sm-3">
                                                                <!-- radio -->
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="customRadio1" name="offer_category" value="1" onclick="show_table_details()">
                                                                        <label for="customRadio1" class="custom-control-label">Applicable</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <!-- radio -->
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="customRadio2" name="offer_category" value="2" onclick="show_rough_details()">
                                                                        <label for="customRadio2" class="custom-control-label">Not Applicable</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if($offer_category == 1){ ?>
                                                <!-- <div id="boq_applicable" style="display: none;"> -->
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
                                                                        Add New Product
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
                                                                                    foreach ($offer_product_list as $row):
                                                                                      $no++;
                                                                                      $offer_reational_entity_id = $row->entity_id;
                                                                                      $product_name = $row->product_name;
                                                                                      $product_id = "Product Id :- ".$row->product_id;
                                                                                      $product_hsn_code = "Product HSN Code :- ".$row->hsn_code;
                                                                                      $product_qty = $row->rfq_qty;
                                                                                      $product_price = $row->price;
                                                                                      $product_basic_value = $product_qty * $product_price;
                                                                                      $cgst_amount = "CGST :- ".$row->cgst_amt;
                                                                                      $sgst_amount = "SGST :- ".$row->sgst_amt;
                                                                                      $igst_amount = "IGST :- ".$row->igst_amt;
                                                                                ?>
                                                                                <tr>
                                                                                    <td style="display: none;" class="offer_relation_entity_id" id="offer_relation_entity_id"><?php echo $offer_reational_entity_id;?></td>
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
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label style="color: #FF0000;"> Salutation * </label>
                                                                <textarea class="form-control" id="salutation" name="salutation" rows="3" placeholder="Enter Salutation" ></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label style="color: #FF0000;"> Price Basis*</label>
                                                                <input type="text" name="price_basis" id="price_basis" class="form-control" size="50" >
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label style="color: #FF0000;">Transportation & Insurance *</label>
                                                                <textarea class="form-control" id="transport_insurance" name="transport_insurance" rows="3" placeholder="Enter Transportation & Insurance"></textarea>
                                                            </div>
                                                        </div>
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
                                                                <textarea class="form-control" id="mode_of_payment" name="mode_of_payment" rows="3" placeholder="Enter Mode Of Payment"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label style="color: #FF0000;"> Mode of Transport *</label>
                                                                <textarea class="form-control" id="mode_of_transport" name="mode_of_transport" rows="3" placeholder="Enter Mode Of Transport"></textarea>
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
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label style="color: #FF0000;"> Terms & Condition *</label>
                                                                <input type="text" name="offer_terms_condition" id="offer_terms_condition" class="form-control" placeholder="Enter Delivery Period" size="50">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group">   
                                                                <label for="offer_attachment">Attachment</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" name="offer_attachment[]" multiple  id="offer_attachment">
                                                                        <label class="custom-file-label" for="offer_attachment">Choose Attachment</label>
                                                                    </div>
                                                                </div>
                                                                
                                                                <?php 
                                                                    foreach ($image_attachment_name as $key => $value) {
                                                                ?>
                                                                <p>
                                                                <a target="_blank" href="<?php echo base_url();?>assets/offer_attachment/<?php echo $value;?>"><?php echo $value;?></a>
                                                                <!-- <a href="delete.php?<?php echo $value;?>"><input type="button" value="Delete"> -->
                                                                <?php if(!empty($value)){ ?>
                                                                <a href="<?php echo site_url('delete_attach_image/'.$value.'-'.$entity_id);?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></p>
                                                                <?php }}?>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label> Delivery Period </label>
                                                                <input type="text" name="delivery_period" id="delivery_period" class="form-control" placeholder="Enter Delivery Period" size="50">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label>Foot Note </label>
                                                                <textarea class="form-control" id="offer_note" name="offer_note" rows="3" placeholder="Enter Note"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <!-- </div> -->
                                                <?php } ?>
                                                <?php if($offer_category == 2){ ?>
                                                <!-- <div id="boq_not_applicable"> -->
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label style="color: #FF0000;"> Verbal Offer Details *</label>
                                                                <textarea class="form-control" id="rought_offer_details" name="rought_offer_details" rows="5" placeholder="Enter Verbal Offer Details"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- </div> -->
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-sm-5">
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                           <label style="color: #FF0000;"> Offer Status *</label>
                                                            <div class="col-sm-3">
                                                                <!-- radio -->
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="customRadio3" name="offer_status" value="2" onclick="hideOfferStatus()">
                                                                        <label for="customRadio3" class="custom-control-label">Offer Created</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <!-- radio -->
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="customRadio4" name="offer_status" value="4" onclick="showOfferStatus()">
                                                                        <label for="customRadio4" class="custom-control-label">Offer Loss</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <!-- radio -->
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="customRadio5" name="offer_status" value="5" onclick="showOfferStatus()">
                                                                        <label for="customRadio5" class="custom-control-label">Offer Regrated</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Offer Value </label>
                                                            <input type="text" name="offer_value" id="offer_value" class="form-control" value="<?php echo $Offer_value?>" size="50">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                    </div>

                                                    <div class="col-sm-4" id="Offer_reason" style="display: none">
                                                        <div class="form-group">
                                                            <label> Reason <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <textarea class="form-control" id="offer_reason" name="offer_reason" rows="3" placeholder="Enter Offer Loss/Regrated Reason"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Offer Tracking Details Form</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label> Offer Tracking Date </label>
                                                                    <input type="date" name="tracking_date" id="tracking_date" value="<?php echo $tracking_date; ?>" class="form-control" size="50">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <label style="color: #FF0000;"> Tracking Description * </label>
                                                                    <textarea class="form-control" id="tracking_descrption" name="tracking_descrption" rows="3" placeholder="Enter Enquiry Tracking Description"></textarea>
                                                                </div>
                                                            </div>

                                                            
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <!-- <div class="form-group">
                                                                    <label style="color: #FF0000;"> Next Action * </label>
                                                                    <textarea class="form-control" id="tracking_next_action" name="tracking_next_action" rows="3" placeholder="Enter Tracking Next Action"></textarea>
                                                                </div> -->
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label  style="color: #FF0000;"> Action Due Date *</label>
                                                                    <input type="date" name="action_due_date" id="action_due_date" class="form-control" size="50">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label > Add Reminder </label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="hidden"><i style="font-size: 50px;" class="fa fa-bell"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card-body">
                                                            <center>
                                                                <div class="btn-group">
                                                                    <a href="<?php echo site_url('vw_all_enquiry_to_order_data');?>" class="btn btn-block btn-danger">
                                                                    Back
                                                                    </a>
                                                                </div>

                                                                <button type="submit" class="btn btn-success toastrDefaultSuccess">
                                                                    Submit
                                                                </button>
                                                                <?php if($offer_category == 1 && $offer_product_relation_count_data > 0) {?>
                                                                    <button type="button" class="btn btn-primary toastrDefaultSuccess" data-toggle="modal" data-target="#modal-sm">
                                                                        Save & Create Order
                                                                    </button>
                                                                <?php } ?>
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="card-body">
                                                <div  class="table-responsive">
                                                    <table id="example12" class="table table-bordered table-striped">
                                                        <tr>
                                                            <th> Tracking Number</th>
                                                            <th> Tracking Date</th>
                                                            <th> Tracking Record</th>
                                                            <th> Tracking Next Action</th>
                                                        </tr>
                                                    </table>
                                                </div>
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
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="product_checkbox_submited">Save</button>
                                </div>
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
                                            <td><?php echo $row->product_long_description;?></td>
                                            <td><?php echo $row->price;?></td>
                                       </tr>
                                       <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="product_checkbox_submited_new">Save</button>
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

        <div class="modal fade" id="modal-sm">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm Order</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do You Want To Confirm Created Order? </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" name="confirm_order" id="confirm_order" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </div>
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
                    var entity_id = $('[name="entity_id"]').val();
                    
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
                                $('[name="enquiry_number"]').val(data[i].enquiry_no);
                                $('[name="customer_name"]').val(data[i].customer_id).trigger('change');
                                $('[name="employee_id"]').val(data[i].offer_engg_name).trigger('change');
                                $('[name="enquiry_descrption"]').val(data[i].offer_description);
                                $('[name="offer_type"]').val(data[i].offer_type).trigger('change');
                                $('[name="offer_date"]').val(data[i].offer_date);
                                //$('[name="offer_freight"]').val(data[i].Transportation).trigger('change');
                                //$('[name="freight_charges"]').val(data[i].transportation_price);
                                $('[name="dispatch_address"]').val(data[i].dispatch_address);
                                $('[name="delivery_instruction"]').val(data[i].delivery_instruction);
                                $('[name="packing_forwarding"]').val(data[i].packing_forwarding).trigger('change');
                                //$('[name="packing_forwarding_charges"]').val(data[i].packing_forwarding_price);
                                //$('[name="payment_term"]').val(data[i].payment_term).trigger('change');
                                $('[name="payment_term"]').val(data[i].payment_term);
                                $('[name="special_instruction"]').val(data[i].special_packing);
                                //$('[name="offer_insurance"]').val(data[i].insurance).trigger('change');
                                //$('[name="insurance_charges"]').val(data[i].insurance_price);

                                
                                $('[name="price_condition"]').val(data[i].price_condition).trigger('change');

                                $('[name="offer_note"]').val(data[i].note);
                                $('[name="your_reference"]').val(data[i].your_reference);
                                $('[name="delivery_period"]').val(data[i].delivery_period);
                                //$('[name="offer_terms_condition"]').val(data[i].terms_conditions_id).trigger('change');
                                $('[name="offer_terms_condition"]').val(data[i].terms_conditions);
                                /*$('[name="offer_status"]').val(data[i].status).trigger('change');*/

                                $('[name="price_basis"]').val(data[i].price_basis);
                                $('[name="transport_insurance"]').val(data[i].transport_insurance);
                                $('[name="tax"]').val(data[i].tax);
                                $('[name="delivery_schedule"]').val(data[i].delivery_schedule);
                                $('[name="mode_of_payment"]').val(data[i].mode_of_payment);
                                $('[name="mode_of_transport"]').val(data[i].mode_of_transport);
                                $('[name="guarantee_warrenty"]').val(data[i].guarantee_warrenty);
                                $('[name="salutation"]').val(data[i].salutation);

                                $('[name="rought_offer_details"]').val(data[i].offer_rought_details);
                                if (data[i].offer_category == 1)
                                    $('#offer_form').find(':radio[name=offer_category][value="1"]').prop('checked', true);
                                if (data[i].offer_category == 2)
                                    $('#offer_form').find(':radio[name=offer_category][value="2"]').prop('checked', true);

                                $('[name="offer_close_date"]').val(data[i].offer_close_date);
                                $('[name="winning_chance"]').val(data[i].winning_chance).trigger('change');

                                if (data[i].status == 2)
                                    $('#offer_form').find(':radio[name=offer_status][value="2"]').prop('checked', true);
                                if (data[i].status == 4)
                                    $('#offer_form').find(':radio[name=offer_status][value="4"]').prop('checked', true);
                                if (data[i].status == 5)
                                    $('#offer_form').find(':radio[name=offer_status][value="5"]').prop('checked', true);
                            });
                        }
                    });
                }
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
                //call function get data edit
                get_data_edit();

                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('sales/enquiry_tracking_register/get_offer_tracking_data_by_offer_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success: function(data){
                            console.log(data);
                            var trHTML = '';
                            $.each(data, function (i, item) {
                                //bill_link = 'http://shreeautocare.com/erp/view_invoice/'+ item.Bill_id;
                                trHTML += '<tr><td>' + item.tracking_number + '</td><td>' + item.tracking_date + '</td><td>' + item.tracking_record + '</td><td>' + item.next_action + '</td></tr>';
                            });
                            $('#example12').append(trHTML);
                        }
                    });
                }
            });
        </script>

        <script type="text/javascript">
            //load data for edit
                $('#customer_name').change(function(){
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
                                $val = 
                                $('[name="enquiry_contact_person"]').val(data[i].contact_person);
                                $('[name="enquiry_email_id"]').val(data[i].email_id);
                                $('[name="enquiry_contact_number"]').val(data[i].first_contact_no);
                                $('[name="enquiry_customer_state"]').val(data[i].state_name);
                                $('[name="enquiry_customer_city"]').val(data[i].city_name);
                            })
                        }
                    });
                    return false;
                });
        </script>

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

            function showOfferStatus (){
               document.getElementById('Offer_reason').style.display = "block";
            }

            function hideOfferStatus(){
                $('#Offer_reason').hide();  
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
            $(document).ready( function () {
                
                $('#product_details_table').DataTable();
                
            } );
        </script>

        <script>
           $(function()
           {
                $("#product_checkbox_submited").on('click', function(event){
                    var entity_id = document.getElementById('entity_id').value;
                    var enquiry_descrption = document.getElementById('enquiry_descrption').value;
                    var employee_id = document.getElementById('employee_id').value;
                    var offer_type = document.getElementById('offer_type').value;
                    var offer_date = document.getElementById('offer_date').value;
                    //var offer_freight = document.getElementById('offer_freight').value;
                    //var freight_charges = document.getElementById('freight_charges').value;
                    var dispatch_address = document.getElementById('dispatch_address').value; 
                    var delivery_instruction = document.getElementById('delivery_instruction').value;
                    //var offer_pf = document.getElementById('offer_pf').value;
                    //var packing_forwarding_charges = document.getElementById('packing_forwarding_charges').value;
                    //var payment_term = document.getElementById('payment_term').value;
                    var special_instruction = document.getElementById('special_instruction').value;
                    //var offer_insurance = document.getElementById('offer_insurance').value;
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

                    var price_condition = document.getElementById('price_condition').value;
                    var your_reference = document.getElementById('your_reference').value;

                    /*var offer_terms_condition = document.getElementById('offer_terms_condition').value;
                    var offer_attachment = document.getElementById('offer_attachment').value;
                    var delivery_period = document.getElementById('delivery_period').value;             
                    var offer_note = document.getElementById('offer_note').value;*/

                    var product_checkbox = [];
                    $.each($("input[name='product_checkbox']:checked"), function(){            
                        product_checkbox.push($(this).val());
                    });

                    $.ajax({
                        url:"<?php echo site_url('sales/offer_register/update_offer_product');?>",
                        type: 'POST',
                        data: {'entity_id': entity_id, 'product_checkbox': product_checkbox,'enquiry_descrption': enquiry_descrption, 'employee_id': employee_id, 'offer_type': offer_type, 'offer_date': offer_date, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'payment_term': payment_term, 'special_instruction': special_instruction, 'price_condition': price_condition, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty, 'your_reference': your_reference},
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

        <script>
           $(function()
           {
                $("#product_checkbox_submited_new").on('click', function(event){
                    var entity_id = document.getElementById('entity_id').value;
                    var enquiry_descrption = document.getElementById('enquiry_descrption').value;
                    var employee_id = document.getElementById('employee_id').value;
                    var offer_type = document.getElementById('offer_type').value;
                    var offer_date = document.getElementById('offer_date').value;
                    //var offer_freight = document.getElementById('offer_freight').value;
                    //var freight_charges = document.getElementById('freight_charges').value;
                    var dispatch_address = document.getElementById('dispatch_address').value; 
                    var delivery_instruction = document.getElementById('delivery_instruction').value;
                    //var offer_pf = document.getElementById('offer_pf').value;
                    //var packing_forwarding_charges = document.getElementById('packing_forwarding_charges').value;
                    //var payment_term = document.getElementById('payment_term').value;
                    var special_instruction = document.getElementById('special_instruction').value;
                    //var offer_insurance = document.getElementById('offer_insurance').value;
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

                    var price_condition = document.getElementById('price_condition').value;
                    var your_reference = document.getElementById('your_reference').value;

                    /*var offer_terms_condition = document.getElementById('offer_terms_condition').value;
                    var offer_attachment = document.getElementById('offer_attachment').value;
                    var delivery_period = document.getElementById('delivery_period').value;             
                    var offer_note = document.getElementById('offer_note').value;*/

                    var product_checkbox = [];
                    $.each($("input[name='product_checkbox']:checked"), function(){            
                        product_checkbox.push($(this).val());
                    });

                    $.ajax({
                        url:"<?php echo site_url('sales/offer_register/update_offer_product');?>",
                        type: 'POST',
                        data: {'entity_id': entity_id, 'product_checkbox': product_checkbox,'enquiry_descrption': enquiry_descrption, 'employee_id': employee_id, 'offer_type': offer_type, 'offer_date': offer_date, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'payment_term': payment_term, 'special_instruction': special_instruction, 'price_condition': price_condition, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty, 'your_reference': your_reference},
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
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_product_description');?>",
                    method : "POST",
                    data : {'product_desc': product_desc,
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
                        //location.reload();
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
                        //location.reload();
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
        </script>

        <script type="text/javascript">
            $(document).ready(function(){

                /*$('#category_id').change(function(){ 
                    var id=$(this).val();
                    $.ajax({
                            url : "<?php echo site_url('master/product_master/get_sub_category');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(data){
                                 
                                var html = '';
                                var i;
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].entity_id+'>'+data[i].vehicle_model_name+'</option>';
                                }
                                $('#pop_up_vehicle_model').html(html);
                            }
                            
                            success: function(response){
                                $.each(response,function(index,data){
                                   $('#sub_category_id').append('<option value="'+data['entity_id']+'">'+data['subcategory_name']+'</option>');
                                });
                            }
                        });
                    return false;
                });*/

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

        <script type="text/javascript">
            $(document).on('click', '#update_new_product', function () {

                var entity_id = $("#entity_id").val();
                var enquiry_descrption = document.getElementById('enquiry_descrption').value;
                var employee_id = document.getElementById('employee_id').value;
                var offer_type = document.getElementById('offer_type').value;
                var offer_date = document.getElementById('offer_date').value;
                //var offer_freight = document.getElementById('offer_freight').value;
                //var freight_charges = document.getElementById('freight_charges').value;
                var dispatch_address = document.getElementById('dispatch_address').value; 
                var delivery_instruction = document.getElementById('delivery_instruction').value;
                //var offer_pf = document.getElementById('offer_pf').value;
                //var packing_forwarding_charges = document.getElementById('packing_forwarding_charges').value;
                //var payment_term = document.getElementById('payment_term').value;
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
                var mode_of_transport = document.getElementById('mode_of_transport').value;
                var guarantee_warrenty = document.getElementById('guarantee_warrenty').value;
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

                if(entity_id != "" && pop_up_hsn_code != "" && category_id != "" && product_id !="" && product_name != "" && product_long_desc !="" && product_warranty != "" && product_unit != "" && product_price !="")
                {   
                    $.ajax({
                            url : "<?php echo site_url('sales/offer_register/update_new_product_in_offer');?>",
                            type : "POST",
                            data: {'entity_id': entity_id,'enquiry_descrption': enquiry_descrption, 'employee_id': employee_id, 'offer_type': offer_type, 'offer_date': offer_date, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'payment_term': payment_term, 'special_instruction': special_instruction, 'pop_up_hsn_code': pop_up_hsn_code, 'category_id': category_id, 'product_id': product_id, 'product_name': product_name, 'product_long_desc': product_long_desc, 'product_sourcing_type': product_sourcing_type, 'product_warranty': product_warranty, 'product_unit': product_unit, 'product_price': product_price, 'price_condition': price_condition, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty, 'your_reference': your_reference},
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
            function change_contact_person(item)
            {
               var customer_id = document.getElementById('customer_id').value;
               var enquiry_contact_person = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_contact_person');?>",
                    method : "POST",
                    data : {'enquiry_contact_person': enquiry_contact_person,
                            'customer_id': customer_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_email_id(item)
            {
               var customer_id = document.getElementById('customer_id').value;
               var enquiry_email_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_email_id');?>",
                    method : "POST",
                    data : {'enquiry_email_id': enquiry_email_id,
                            'customer_id': customer_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_contact_no(item)
            {
               var customer_id = document.getElementById('customer_id').value;
               var enquiry_contact_number = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/update_contact_no');?>",
                    method : "POST",
                    data : {'enquiry_contact_number': enquiry_contact_number,
                            'customer_id': customer_id},
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
            function show_rough_details()
            {
                /*document.getElementById('boq_not_applicable').style.display = "display";
                $('#boq_applicable').hide(); */

                /*$('#boq_not_applicable').show(); 
                $('#boq_applicable').hide(); */

                var id = document.getElementById('customRadio2').value;
                var entity_id = document.getElementById('entity_id').value;
                
                $.ajax({
                    url : "<?php echo site_url('sales/enquiry_to_order_register/update_offer_category');?>",
                    method : "POST",
                    data : {'entity_id': entity_id,
                            'id': id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function show_table_details(){
                /*var id = document.getElementsByName("offer_category");*/
                var id = document.getElementById('customRadio1').value;
                var entity_id = document.getElementById('entity_id').value;
                
                $.ajax({
                    url : "<?php echo site_url('sales/enquiry_to_order_register/update_offer_category');?>",
                    method : "POST",
                    data : {'entity_id': entity_id,
                            'id': id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }
        </script>

        <script>
            $(document).on('click', '#confirm_order', function () {

                var entity_id = document.getElementById('entity_id').value;
                var enquiry_descrption = document.getElementById('enquiry_descrption').value;
                var employee_id = document.getElementById('employee_id').value;
                var offer_type = document.getElementById('offer_type').value;
                var offer_date = document.getElementById('offer_date').value;
                var offer_close_date = document.getElementById('offer_close_date').value;
                var winning_chance = document.getElementById('winning_chance').value;
                
                var offer_category = $("input[type='radio'][name='offer_category']:checked").val();

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
                var price_condition = document.getElementById('price_condition').value;
                var your_reference = document.getElementById('your_reference').value;
                var offer_terms_condition = document.getElementById('offer_terms_condition').value;
                var delivery_period = document.getElementById('delivery_period').value;
                var offer_note = document.getElementById('offer_note').value;

                var offer_status = $("input[type='radio'][name='offer_status']:checked").val();
                
                /*var offer_status = document.getElementById('offer_status').value;*/
                var offer_value = document.getElementById('offer_value').value;
                var offer_reason = document.getElementById('offer_reason').value;

                if(entity_id != "" && enquiry_descrption != "" && employee_id != "" && offer_type != "" && offer_date != "" && offer_close_date != "" && winning_chance != "" && offer_category != "" && offer_status != "")
                {
                    $.ajax({
                        url:"<?php echo site_url('sales/enquiry_to_order_register/update_offer_to_save_order');?>",
                        type: 'POST',
                        data: {'entity_id': entity_id , 'enquiry_descrption': enquiry_descrption , 'employee_id': employee_id , 'offer_type': offer_type , 'offer_date': offer_date , 'offer_close_date': offer_close_date , 'winning_chance': winning_chance , 'offer_category': offer_category , 'salutation': salutation , 'price_basis': price_basis , 'transport_insurance': transport_insurance , 'tax': tax , 'delivery_schedule': delivery_schedule , 'mode_of_payment': mode_of_payment , 'mode_of_transport': mode_of_transport , 'dispatch_address': dispatch_address , 'delivery_instruction': delivery_instruction , 'packing_forwarding': packing_forwarding , 'guarantee_warrenty': guarantee_warrenty , 'payment_term': payment_term , 'special_instruction': special_instruction , 'price_condition': price_condition , 'your_reference': your_reference , 'offer_terms_condition': offer_terms_condition , 'delivery_period': delivery_period , 'offer_note': offer_note , 'offer_status': offer_status , 'offer_value': offer_value, 'offer_reason': offer_reason},
                        success: function(data){
                            data = data.trim();
                            window.location.href = data;
                        },
                        error: function(){
                            alert("Fail");
                        }
                    });
                }else{
                  alert("Enter Proper Details.............");
                }
            });
        </script>
    </body>
</html>
