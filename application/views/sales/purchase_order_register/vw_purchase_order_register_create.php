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
        <title>Create Purchase Order</title>
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
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Create Purchase Order</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_purchase_order_data'?>">Purchase Order Register</a></li>
                                            <li class="breadcrumb-item">Enter Purchase Order Details</li>
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
                                            <h3 class="card-title">Purchase Order Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="purchase_detail_form" enctype="multipart/form-data" action="<?php echo site_url('sales/purchase_order_register/save_purchase_order');?>" method="post">
                                                
                                                <input type="hidden" id="order_entity_id" name="order_entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Purchase Order Number </label>
                                                            <input type="text" name="purchase_order_number" id="purchase_order_number" class="form-control"  size="50" placeholder="Enter Purchase Order Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Sales Order Number </label>
                                                            <input type="text" name="sales_order_number" id="sales_order_number" class="form-control"  size="50" placeholder="Enter Sales Order Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Vendor Name </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="vendor_id" name="vendor_id" required onchange="change_vendor_id(this);">
                                                                <option value="">Not Selected</option>
                                                                <?php foreach($vendor_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->vendor_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div>
                                                            <div style="margin-top: 30px;">
                                                                <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-lg-vendor">
                                                                  Add Vendor
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Ship To Address Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <!-- <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Company </label>
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="ship_to_party_id" name="ship_to_party_id">
                                                                                <option value="">Not Selected</option>
                                                                                <?php foreach($ship_to_party as $row):?>
                                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->party_name;?></option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Company </label>
                                                                            <input type="text" name="ship_to_company" id="ship_to_company" class="form-control" size="50" placeholder="Enter Ship To Company" onchange="ship_to_company_change(this);">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <input type="text" name="customer_ship_to_contact_person" id="customer_ship_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" onchange="ship_to_contact_personsss(this);">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="ship_to_email_id" id="ship_to_email_id" class="form-control" size="50" placeholder="Customer Email Id" onchange="ship_to_email_idss(this);">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Address</label>
                                                                            <textarea class="form-control" id="ship_to_address" name="ship_to_address" rows="3" placeholder="Enter Ship To Address" onchange="ship_to_addressss(this);"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="ship_to_contact_number" id="ship_to_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" onchange="ship_to_contact_numberss(this);">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Gst No </label>
                                                                            <input type="text" name="ship_to_gst_no" id="ship_to_gst_no" class="form-control" size="50" placeholder="Customer Gst No" onchange="ship_to_gst_noss(this);">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Bill To Address Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <!-- <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Company </label>
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bill_to_party_id" name="bill_to_party_id">
                                                                                <option value="">Not Selected</option>
                                                                                <?php foreach($bill_to_party as $row):?>
                                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->party_name;?></option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Company </label>
                                                                            <input type="text" name="bill_to_company" id="bill_to_company" class="form-control" size="50" placeholder="Enter Bill To Company" onchange="bill_to_company_change(this);">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <input type="text" name="bill_to_contact_person" id="bill_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" onchange="bill_to_contact_personsss(this);">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="bill_to_email_id" id="bill_to_email_id" class="form-control" size="50" placeholder="Customer Email Id" onchange="bill_to_email_idss(this);">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Address</label>
                                                                            <textarea class="form-control" id="bill_to_address" name="bill_to_address" rows="3" placeholder="Enter Bill To Address" onchange="bill_to_addressss(this);"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Number </label>
                                                                            <input type="text" name="bill_to_contact_number" id="bill_to_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" onchange="bill_to_contact_numberss(this);">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Gst No </label>
                                                                            <input type="text" name="bill_to_gst_no" id="bill_to_gst_no" class="form-control" size="50" placeholder="Customer Gst No" onchange="bill_to_gst_noss(this);">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <center>
                                                        <div class="btn-group">
                                                            <a href="<?php echo site_url('vw_purchase_order_data');?>" class="btn btn-block btn-danger">
                                                            Back
                                                            </a>
                                                        </div>
                                                        
                                                        <button type="submit" class="btn btn-success toastrDefaultSuccess">
                                                            Next
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

        <div class="modal fade" id="modal-lg-vendor">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enter Vendor Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="pop_up_customer_master_form" id="pop_up_customer_master_form" method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">Vendor Name * </label>
                                        <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="Enter Vendor Name" required="required">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>GST Number</label>
                                      <input type="text" class="form-control" name="gst_no" id="gst_no" placeholder="Enter GST Number" required="required">
                                    </div>
                                </div>        
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">Phone Number *</label>
                                        <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Enter Phone Number" required="required">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">Contact Person *</label>
                                        <input type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Enter Contact Person Name" required="required">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Mobile Number </label>
                                        <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="Enter Mobile Number" required="required">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">State Name * </label>
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
                                        <label style="color: #FF0000;">Address * </label>
                                        <textarea class="form-control" rows="3" name="address" id="address" placeholder="Please Enter Address"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">State Code* </label>
                                        <input type="text" class="form-control" readonly name="state_code" id="state_code" placeholder="Enter State Code">
                                    </div>
                                </div> 

                              <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">Pincode * </label>
                                        <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode">
                                    </div>
                                </div> 

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="email" class="form-control" name="email_id" id="email_id" placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  
                        <button type="submit" name="add_new_vendor" id="add_new_vendor" class="btn btn-primary">Save</button>
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
                    var entity_id = $('[name="order_entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('sales/purchase_order_register/get_purchase_order_details_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="purchase_order_number"]').val(data[i].po_no);
                                $('[name="sales_order_number"]').val(data[i].sales_order_no);
                                $('[name="enquiry_number"]').val(data[i].enquiry_no);
                                /*$('[name="customer_id"]').val(data[i].customer_id);*/
                                $('[name="vendor_id"]').val(data[i].vendor_id).trigger('change');
                                $('[name="employee_id"]').val(data[i].order_engg_name).trigger('change');
                                $('[name="order_descrption"]').val(data[i].sales_order_description);
                                $('[name="special_customer"]').val(data[i].special_customer).trigger('change');
                                
                                $('[name="terms_conditions"]').val(data[i].terms_conditions);
                                $('[name="delivery_period"]').val(data[i].delivery_period);
                                $('[name="dispatch_address"]').val(data[i].dispatch_address);
                                $('[name="delivery_instruction"]').val(data[i].delivery_instruction);
                                $('[name="special_instruction"]').val(data[i].special_packing);
                                $('[name="price_condition"]').val(data[i].price_condition).trigger('change');

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

                                $('[name="customer_ship_to_contact_person"]').val(data[i].customer_ship_to_contact_person);
                                $('[name="ship_to_email_id"]').val(data[i].customer_ship_to_contact_person_mail);
                                $('[name="ship_to_address"]').val(data[i].customer_ship_to_address);
                                $('[name="ship_to_contact_number"]').val(data[i].customer_ship_to_contact_person_no);
                                $('[name="ship_to_gst_no"]').val(data[i].customer_ship_to_gst_no);

                                $('[name="bill_to_contact_person"]').val(data[i].customer_bill_to_contact_person);
                                $('[name="bill_to_email_id"]').val(data[i].customer_bill_to_contact_person_mail);
                                $('[name="bill_to_address"]').val(data[i].customer_bill_to_address);
                                $('[name="bill_to_contact_number"]').val(data[i].customer_bill_to_contact_person_no);
                                $('[name="bill_to_gst_no"]').val(data[i].customer_bill_to_gst_no);
                                
                                $('[name="ship_to_company"]').val(data[i].customer_ship_to_name);
                                $('[name="bill_to_company"]').val(data[i].customer_bill_to_name);

                                $('[name="sales_order_type"]').val(data[i].sales_order_type).trigger('change');

                            });
                        }
                    });
                }
            });
        </script>

        <!-- <script type="text/javascript">
            $('#ship_to_party_id').change(function(){
                var entity_id = $('[name="offer_entity_id"]').val();
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/get_ship_to_party_data');?>",
                    method : "POST",
                    data : {id: id , entity_id: entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val = 
                            // $('[name="customer_ship_to_contact_person"]').val(data[i].Ship_to_contact_person);
                        })
                    }
                });
                return false;
            });
        </script> -->

        <!-- <script type="text/javascript">
            $('#bill_to_party_id').change(function(){
                var entity_id = $('[name="offer_entity_id"]').val();
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/sales_order_register/get_bill_to_party_data');?>",
                    method : "POST",
                    data : {id: id , entity_id: entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val =
                            // $('[name="bill_to_contact_person"]').val(data[i].Bill_to_contact_person);
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

        <script type="text/javascript">
            $(document).ready(function(){
         
                $('#state_id').change(function(){ 
                    var id=$(this).val();
                    $.ajax({
                        url : "<?php echo site_url('sales/purchase_order_register/get_city_name');?>",
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
            $('#state_id').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/get_state_code');?>",
                    method : "POST",
                    data :{id :id},
                    async : true,
                    dataType : 'json',
                    success : function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val =
                            $('[name="state_code"]').val(data[i].state_code);
                        });
                    }
                });
            }); 
        </script>

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
            $(function()
            {
                $("#add_new_vendor").on('click', function(event)
                {
                    var vendor_name = document.getElementById('vendor_name').value;
                    var gst_no = document.getElementById('gst_no').value;
                    var phone_no = document.getElementById('phone_no').value;
                    var contact_person = document.getElementById('contact_person').value;
                    var mobile_number = document.getElementById('mobile_number').value;
                    var state_id = document.getElementById('state_id').value;
                    var city_id = document.getElementById('city_id').value;
                    var address = document.getElementById('address').value;
                    var state_code = document.getElementById('state_code').value;
                    var pincode = document.getElementById('pincode').value;
                    var email_id = document.getElementById('email_id').value;

                    if(vendor_name != "" && phone_no != "" && contact_person != "" && state_id != "" && city_id != "" && address != "" && state_code != "" && pincode != "")
                    {   
                        $.ajax({
                            url:"<?php echo site_url('sales/purchase_order_register/save_vendor_data');?>",
                            type: 'POST',
                            data: {'vendor_name': vendor_name, 'gst_no': gst_no, 'phone_no': phone_no, 'contact_person': contact_person, 'mobile_number': mobile_number, 'state_id': state_id, 'city_id': city_id, 'address': address, 'state_code': state_code, 'pincode': pincode,'email_id': email_id},
                            success: function(data){
                                location.reload();
                            },
                            error: function(){
                                alert("Fail")
                            }
                        });
                    }else{
                        alert("Enter All Details");
                        location.reload();
                    }
                });
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
            $(document).ready( function () {
                $('#example1').DataTable();
                $('#product_details_table').DataTable();
                $('#accessories_details_table').DataTable();
            } );
        </script>

        <script type="text/javascript">
            $(document).on('click', '#add_new_accessories', function () {

                var entity_id = $('[name="offer_entity_id"]').val();
                var accessories_for = $("#accessories_for").val();
                var accessories = $("#accessories").val();
                var accessories_rate = $("#accessories_rate").val();
                var accessories_qty = $("#accessories_qty").val();

                if(entity_id != "" && accessories_for != "" && accessories != "" && accessories_rate != "" && accessories_qty != "")
                {
                    $.ajax({
                            url : "<?php echo site_url('sales/sales_order_register/save_order_accessories');?>",
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

        <script>
           $(function()
           {
                $("#product_checkbox_submited").on('click', function(event){
                    var offer_entity_id = document.getElementById('offer_entity_id').value;
                    var order_descrption = document.getElementById('order_descrption').value;
                    var employee_id = document.getElementById('employee_id').value;
                    var order_terms_condition = document.getElementById('terms_conditions').value;
                    //var delivery_period = document.getElementById('delivery_period').value;
                    //var order_freight = document.getElementById('order_freight').value;
                    //var freight_charges = document.getElementById('freight_charges').value;
                    var dispatch_address = document.getElementById('dispatch_address').value; 
                    var delivery_instruction = document.getElementById('delivery_instruction').value;
                    //var order_pf = document.getElementById('order_pf').value;
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
                    var special_customer = document.getElementById('special_customer').value;

                    var sales_order_type = document.getElementById('sales_order_type').value;

                    var product_checkbox = [];
                    $.each($("input[name='product_checkbox']:checked"), function(){            
                        product_checkbox.push($(this).val());
                    });

                    $.ajax({
                        url:"<?php echo site_url('sales/sales_order_register/update_order_from_offer');?>",
                        type: 'POST',
                        data: {'offer_entity_id': offer_entity_id, 'product_checkbox': product_checkbox,'order_descrption': order_descrption, 'employee_id': employee_id, 'order_terms_condition': order_terms_condition, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'payment_term': payment_term, 'special_instruction': special_instruction, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty, 'special_customer': special_customer, 'sales_order_type': sales_order_type},
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
            $(document).on('click', '#update_new_product', function () {

                var offer_entity_id = $("#offer_entity_id").val();
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
                var sales_order_type = document.getElementById('sales_order_type').value;

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

                if(offer_entity_id != "" && pop_up_hsn_code != "" && category_id != "" && product_id !="" && product_name != "" && product_long_desc !="" && product_warranty != "" && product_unit != "" && product_price !="")
                {   
                    $.ajax({
                            url : "<?php echo site_url('sales/sales_order_register/create_new_product_in_sales_order');?>",
                            type : "POST",
                            data: {'offer_entity_id': offer_entity_id,'order_descrption': order_descrption, 'employee_id': employee_id, 'terms_conditions': terms_conditions, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'special_customer': special_customer, 'payment_term': payment_term, 'special_instruction': special_instruction, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty,'pop_up_hsn_code': pop_up_hsn_code, 'category_id': category_id, 'product_id': product_id, 'product_name': product_name, 'product_long_desc': product_long_desc, 'product_sourcing_type': product_sourcing_type, 'product_warranty': product_warranty, 'product_unit': product_unit, 'product_price': product_price, 'sales_order_type': sales_order_type},
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
            
            function change_ProductDescription(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var product_desc = item.value;
               //alert(order_relation_entity_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_product_description');?>",
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
                    url : "<?php echo site_url('sales/purchase_order_register/update_product_delivery_period');?>",
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
                    url : "<?php echo site_url('sales/purchase_order_register/update_product_warranty');?>",
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
                    url : "<?php echo site_url('sales/purchase_order_register/update_product_price');?>",
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
                    url : "<?php echo site_url('sales/purchase_order_register/update_product_qty');?>",
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
                    url : "<?php echo site_url('sales/purchase_order_register/update_product_discount_percentage');?>",
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
                    url : "<?php echo site_url('sales/purchase_order_register/delete_order_product');?>",
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

            function change_vendor_id(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var vendor_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_vendor_id_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'vendor_id': vendor_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function ship_to_company_change(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_company_name = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_ship_to_company_name_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
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

            function bill_to_company_change(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_company_name = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_bill_to_company_name_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
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

        <script type="text/javascript">

            function ship_to_contact_personsss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_contact_person = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_ship_to_contact_person_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_contact_person': ship_to_contact_person},
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

            function bill_to_contact_personsss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_contact_person = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_bill_to_contact_person_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_contact_person': bill_to_contact_person},
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

            function ship_to_email_idss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_email_id = item.value;
                // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_ship_to_email_id');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_email_id': ship_to_email_id},
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

            function bill_to_email_idss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_email_id = item.value;
                // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_bill_to_email_id');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_email_id': bill_to_email_id},
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

            function ship_to_addressss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_address = item.value;
                // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_ship_to_address_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_address': ship_to_address},
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

            function bill_to_addressss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_address = item.value;
                // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_bill_to_address_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_address': bill_to_address},
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

            function ship_to_contact_numberss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_contact_number = item.value;
                // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_ship_to_contact_no');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_contact_number': ship_to_contact_number},
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

            function bill_to_contact_numberss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_contact_number = item.value;
                // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_bill_to_contact_no');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_contact_number': bill_to_contact_number},
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

            function ship_to_gst_noss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_gst_no = item.value;
               // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_ship_to_gst_no');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_gst_no': ship_to_gst_no},
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

            function bill_to_gst_noss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_gst_no = item.value;
                // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/purchase_order_register/update_bill_to_gst_no');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_gst_no': bill_to_gst_no},
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
    </body>
</html>
