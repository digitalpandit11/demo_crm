<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
    $data = site_url('dashboard');
    header("location:$data");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Approve Sales Order</title>
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
                                    <h1 class="card-title">Approve Sales Order</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_pending_sales_order_data'?>">Pending Sales Order Register</a></li>
                                            <li class="breadcrumb-item"> Sales Order Details Of Id :- <?php  echo $entity_id; ?> </li>
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
                                            <form role="form" name="offer_form" enctype="multipart/form-data" action="<?php echo site_url('sales/sales_order_register/approve_sales_order');?>" method="post">
                                                
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
                                                            <label> Order Description </label>
                                                            <textarea class="form-control" id="order_descrption" name="order_descrption" rows="3" placeholder="Enter Order Description" disabled></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Select Employee </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="employee_id" name="employee_id" disabled>
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
                                                            <select class="form-control select2bs4" style="width: 100%;" id="special_customer" name="special_customer" disabled>
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
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Terms & Condition </label>
                                                            <!-- <select class="form-control select2bs4" style="width: 100%;" id="order_terms_condition" name="order_terms_condition" disabled>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">A</option>
                                                                <option value="2">B</option>
                                                            </select> -->
                                                            <input type="text" name="terms_conditions" id="terms_conditions" class="form-control" placeholder="Enter Terms & Condition" size="50" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Delivery Period </label>
                                                            <input type="text" name="delivery_period" id="delivery_period" class="form-control" placeholder="Enter Delivery Period" size="50" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Freight </label>
                                                            <select class="form-control" style="width: 100%;" id="order_freight" name="order_freight" disabled>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Customer Scope</option>
                                                                <option value="2">Company Scope</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Freight Charges</label>
                                                            <input type="text" name="freight_charges" id="freight_charges" class="form-control" placeholder="Enter Freight Charges" size="50" disabled>
                                                        </div>
                                                    </div> 
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Dispatch Address </label>
                                                            <textarea class="form-control" id="dispatch_address" name="dispatch_address" rows="3" placeholder="Enter Dispatch Address" disabled></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Delivery Instruction </label>
                                                            <textarea class="form-control" id="delivery_instruction" name="delivery_instruction" rows="3" placeholder="Enter Delivery Instruction" disabled></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Packing & Forwarding </label>
                                                            <select class="form-control" style="width: 100%;" id="order_pf" name="order_pf" disabled>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Customer Scope</option>
                                                                <option value="2">Company Scope</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                     <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> P & F Charges </label>
                                                            <input type="text" name="packing_forwarding_charges" id="packing_forwarding_charges" class="form-control" placeholder="Enter Packing & Forwarding Charges" size="50" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Payment Term </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="payment_term" name="payment_term" disabled>
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($payment_term_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->payement_terms_category;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Special Instruction </label>
                                                            <textarea class="form-control" id="special_instruction" name="special_instruction" rows="3" placeholder="Enter Special Instruction" disabled></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Insurance </label>
                                                            <select class="form-control" style="width: 100%;" id="order_insurance" name="order_insurance" disabled>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Customer Scope</option>
                                                                <option value="2">Company Scope</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                     <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Insurance Charges </label>
                                                            <input type="text" name="insurance_charges" id="insurance_charges" class="form-control" placeholder="Enter Insurance Charges" size="50" disabled>
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
                                                                                    <?php echo $row->product_custom_description;?>  
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $row->delivery_period;?>
                                                                                       
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $row->product_warranty;?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $row->price;?>   
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $row->rfq_qty;?>  
                                                                                </td>
                                                                                <td><?php echo $product_basic_value;?></td>
                                                                                <td>
                                                                                    <?php echo $row->discount;?>
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
                                                                                    <input type="text" class="form-control" value="<?php echo $row->price;?>" id="product_price" name="product_price" placeholder="Enter Price" disabled style="width: 100px;" >   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->qty;?>" id="product_qty" name="product_qty" placeholder="Enter Qty" disabled style="width: 100px;" >   
                                                                                </td>
                                                                                <td><?php echo $product_basic_value;?></td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->discount;?>" id="product_dis_per" name="product_dis_per" placeholder="Enter Discount%"  disabled style="width: 100px;" >
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
                                                            <label> Purchase Order Number </label>
                                                            <input type="text" name="purchase_order_number" id="purchase_order_number" class="form-control"  size="50" placeholder="Enter Purchase Order Number" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Purchase Order Date </label>
                                                            <input type="date" name="purchase_order_date" id="purchase_order_date" class="form-control" size="50" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">   
                                                            <label for="order_attachment">Attachment</label>
                                                            
                                                            <?php 
                                                                foreach ($image_attachment_name as $key => $value) {
                                                            ?>
                                                            <p>
                                                            <a target="_blank" href="<?php echo base_url();?>assets/order_attachment/<?php echo $value;?>"><?php echo $value;?></a>
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">   
                                                            <label for="order_attachment">Offer Copy</label>
                                                            
                                                            <?php 
                                                                foreach ($image_attachment_name as $key => $value) {
                                                            ?>
                                                            <p>
                                                            <a target="_blank" href="<?php echo base_url();?>assets/order_attachment/<?php echo $value;?>"><?php echo $value;?></a>
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group">
                                                        <label>Approval Status</label>
                                                        <div class="col-sm-3">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- radio -->
                                                            <div class="form-group">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" id="customRadio6" name="approval_status" checked="checked" value="1" onclick="hideR()">
                                                                    <label for="customRadio6" class="custom-control-label">Approved</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <!-- radio -->
                                                            <div class="form-group">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" id="customRadio7" name="approval_status" value="3" onclick="showR()">
                                                                    <label for="customRadio7" class="custom-control-label">Rejected</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- <div class="col-sm-4">
                                                    </div> -->

                                                    <!-- <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Approval Status *</label>
                                                            <select class="form-control" id="approval_status" name="approval_status" required>
                                                                <option value="">Not Selected</option>
                                                                <option value="1" onClick="hideRejection()"> Approved</option>
                                                                <option value="3" onClick="showRejection()"> Rejected</option>
                                                            </select>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-sm-6" id="Rejection_reason_form" style="display: none">
                                                    <div class="form-group">
                                                        <label style="color: #FF0000;">Reason *</label>
                                                        <textarea class="form-control" id="rejected_reason" name="rejected_reason" rows="3" placeholder="Enter Order Rejection Reason"></textarea>
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
                        url : "<?php echo site_url('sales/sales_order_register/get_order_details_by_orderid');?>",
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
                                $('[name="rejected_reason"]').val(data[i].order_execution_status_remark);
                                $('[name="ship_to_company_name"]').val(data[i].customer_ship_to_name);
                                $('[name="bill_to_contact_person"]').val(data[i].customer_bill_to_contact_person);
                                $('[name="bill_to_email_id"]').val(data[i].customer_bill_to_contact_person_mail);
                                $('[name="bill_to_contact_number"]').val(data[i].customer_bill_to_contact_person_no);
                                $('[name="bill_to_address"]').val(data[i].customer_bill_to_address);
                                $('[name="special_customer"]').val(data[i].special_customer).trigger('change');
                                $('[name="bill_to_gst_number"]').val(data[i].customer_bill_to_gst_no);
                                $('[name="bill_to_company_name"]').val(data[i].customer_bill_to_name);
                                $('[name="ship_to_contact_person"]').val(data[i].customer_ship_to_contact_person);
                                $('[name="ship_to_address"]').val(data[i].customer_ship_to_address);
                                $('[name="ship_to_email_id"]').val(data[i].customer_ship_to_contact_person_mail);
                                $('[name="ship_to_contact_number"]').val(data[i].customer_ship_to_contact_person_no);
                                $('[name="ship_to_gst_number"]').val(data[i].customer_ship_to_gst_no);
                            });
                        }
                    });
                }
            });
        </script>

        <!-- <script type="text/javascript">
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
            function showRejection(){
               document.getElementById('Rejection_reason_form').style.display = "block";
            }

            function hideRejection(){
                $('#Rejection_reason_form').hide();  
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
                $('#accessories_details_table').DataTable();
            } );
        </script>

        <script type="text/javascript">
            function showR(){
               document.getElementById('Rejection_reason_form').style.display = "block";
            }

            function hideR(){
                $('#Rejection_reason_form').hide();  
            }
        </script>
    </body>
</html>
