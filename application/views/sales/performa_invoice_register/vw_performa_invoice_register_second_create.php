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
        <title>Create Performa Invoice</title>
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
                                    <h1 class="card-title">Create Performa Invoice</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_performa_invoice_data'?>">Performa Invoice Register</a></li>
                                            <li class="breadcrumb-item">Enter Performa Invoice Details</li>
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
                                            <h3 class="card-title">Performa Invoice Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="performa_detail_form" enctype="multipart/form-data" action="<?php echo site_url('sales/performa_invoice_register/save_second_page_performa_invoice');?>" method="post">
                                                
                                                <input type="hidden" id="pi_entity_id" name="pi_entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> Performa Invoice Number </label>
                                                            <input type="text" name="performa_number" id="performa_number" class="form-control"  size="50" placeholder="Enter Performa Invoice Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> Sales Order Number </label>
                                                            <input type="text" name="sales_order_number" id="sales_order_number" class="form-control"  size="50" placeholder="Enter Sales Order Number" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Original Customer </label>
                                                            <input type="text" name="original_customer" id="original_customer" class="form-control"  size="50" placeholder="Enter Original Customer Name" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Ship To Customer </label>
                                                            <input type="text" name="ship_to_customer" id="ship_to_customer" class="form-control"  size="50" placeholder="Enter Ship To Customer Name" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Bill To Customer </label>
                                                            <input type="text" name="bill_to_customer" id="bill_to_customer" class="form-control"  size="50" placeholder="Enter Bill To Customer" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
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
                                                                                <!-- <th>Delivery Period</th>
                                                                                <th>Warranty</th> -->
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
                                                                                <!-- <th>Action</th> -->
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
                                                                                  $product_qty = $row->qty;
                                                                                  $product_price = $row->sales_order_price;
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
                                                                                    <textarea class="form-control" id="product_description" name="product_description" style="width: 300px;" rows="3" placeholder="Enter Product Description" onchange="change_ProductDescription(this);"><?php echo $row->sales_order_product_description;?></textarea>   
                                                                                </td>
                                                                                <!-- <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->delivery_period;?>" id="offer_product_delivery_period" name="offer_product_delivery_period" placeholder="Enter Delivery Period" style="width: 200px;" onchange="change_DeliveryPeriod(this);">    
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->product_warranty;?>" id="product_warranty" name="product_warranty" placeholder="Enter Warranty" style="width: 150px;" onchange="change_Warranty(this);">   
                                                                                </td> -->
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->sales_order_price;?>" id="product_price" name="product_price" placeholder="Enter Price" style="width: 100px;" onchange="change_Price(this);">   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->qty;?>" id="product_qty" name="product_qty" placeholder="Enter Qty" style="width: 100px;" onchange="change_ProductQty(this);">   
                                                                                </td>
                                                                                <td><?php echo $product_basic_value;?></td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->discount_percentage;?>" id="product_dis_per" name="product_dis_per" placeholder="Enter Discount%" style="width: 100px;" onchange="change_ProductDisPercentage(this);">
                                                                                </td>
                                                                                <td><?php echo $row->discount_amount;?></td>
                                                                                <td><?php echo $row->unit_discount_price;?></td>
                                                                                <td><?php echo $row->total_amount_without_gst;?></td>
                                                                                <td><?php echo $row->cgst_percentage;?></td>
                                                                                <td><?php echo $row->sgst_percentage;?></td>
                                                                                <td><?php echo $row->igst_percentage;?></td>
                                                                                <td><?php echo $cgst_amount;?><br><br><?php echo $sgst_amount;?><br><br><?php echo $igst_amount;?></td>
                                                                                <td><?php echo $row->total_amount_with_gst;?></td>
                                                                                <!-- <td>
                                                                                    <a class="btn btn-sm btn-danger" onclick="delete_order_product(<?php echo $order_reational_entity_id; ?>)"><i class="fas fa-trash"></i> </a>
                                                                                </td> -->
                                                                            </tr>
                                                                           <?php endforeach;?>
                                                                        </tbody>
                                                                   </table>
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
            <div class="modal-dialog modal-lg">
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
                                            <td><input type="text" class="form-control" value="<?php echo $row->product_name;?>" disabled placeholder="Enter Product Name" style="width: 150px;"></td>
                                            <td><textarea class="form-control" disabled style="width: 300px;" rows="3" placeholder="Enter Product Description"><?php echo $row->product_long_description;?></textarea></td>
                                            <td><?php echo $row->price;?></td>
                                       </tr>
                                       <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" name="product_checkbox_submited" id="product_checkbox_submited">Save</button>
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
                    var entity_id = $('[name="pi_entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('sales/performa_invoice_register/get_second_page_performa_invoice_details_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="performa_number"]').val(data[i].performa_number);
                                $('[name="sales_order_number"]').val(data[i].sales_order_no);

                                $('[name="original_customer"]').val(data[i].customer_name);
                                $('[name="ship_to_customer"]').val(data[i].ship_to_name);
                                $('[name="bill_to_customer"]').val(data[i].bill_to_name);

                                /*$('[name="employee_id"]').val(data[i].order_engg_name).trigger('change');
                                $('[name="order_descrption"]').val(data[i].po_description);
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
                                $('[name="salutation"]').val(data[i].salutation);*/

                                /*$('[name="sales_order_type"]').val(data[i].sales_order_type).trigger('change');*/
                            });
                        }
                    });
                }
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

        <!-- <script type="text/javascript">
            $(document).on('click', '#add_new_accessories', function () 
            {

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
        </script> -->

        <script>
            $(document).on('click', '#product_checkbox_submited', function () 
            {
                var po_entity_id = document.getElementById('po_entity_id').value;
                var order_descrption = document.getElementById('order_descrption').value;
                var employee_id = document.getElementById('employee_id').value;
                var order_terms_condition = document.getElementById('terms_conditions').value;
                var dispatch_address = document.getElementById('dispatch_address').value; 
                var delivery_instruction = document.getElementById('delivery_instruction').value;
                var payment_term = document.getElementById('payment_term').value;
                var special_instruction = document.getElementById('special_instruction').value;
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

                var product_checkbox = [];
                $.each($("input[name='product_checkbox']:checked"), function(){            
                    product_checkbox.push($(this).val());
                });

                $.ajax({
                    url:"<?php echo site_url('sales/purchase_order_register/update_order_product');?>",
                    type: 'POST',
                    data: {'po_entity_id': po_entity_id, 'product_checkbox': product_checkbox,'order_descrption': order_descrption, 'employee_id': employee_id, 'order_terms_condition': order_terms_condition, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'payment_term': payment_term, 'special_instruction': special_instruction, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty, 'special_customer': special_customer},
                        success: function(data){
                            location.reload();
                        },
                        error: function(){
                           alert("Fail")
                        }
                });
            });
        </script>

        <script type="text/javascript">
            $(document).on('click', '#update_new_product', function () {

                var po_entity_id = $("#po_entity_id").val();

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
                /*var sales_order_type = document.getElementById('sales_order_type').value;*/

                var pop_up_hsn_code = $("#pop_up_hsn_code").val();
                var category_id = $("#category_id").val();
                var product_id = $("#product_id").val();
                var product_name = $("#product_name").val();
                var product_long_desc = $("#product_long_desc").val();
                var product_sourcing_type = $("#product_sourcing_type").val();
                var product_warranty = $("#product_warranty").val();
                var product_unit = $("#product_unit").val();
                var product_price = $("#pop_up_product_price").val();

                if(po_entity_id != "" && pop_up_hsn_code != "" && category_id != "" && product_id !="" && product_name != "" && product_long_desc !="" && product_warranty != "" && product_unit != "" && product_price !="")
                {   
                    $.ajax({
                            url : "<?php echo site_url('sales/purchase_order_register/create_new_product_in_purchase_order');?>",
                            type : "POST",
                            data: {'po_entity_id': po_entity_id,'order_descrption': order_descrption, 'employee_id': employee_id, 'terms_conditions': terms_conditions, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'special_customer': special_customer, 'payment_term': payment_term, 'special_instruction': special_instruction, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'mode_of_transport': mode_of_transport, 'guarantee_warrenty': guarantee_warrenty,'pop_up_hsn_code': pop_up_hsn_code, 'category_id': category_id, 'product_id': product_id, 'product_name': product_name, 'product_long_desc': product_long_desc, 'product_sourcing_type': product_sourcing_type, 'product_warranty': product_warranty, 'product_unit': product_unit, 'product_price': product_price},
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
                    url : "<?php echo site_url('sales/performa_invoice_register/update_product_description');?>",
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

            /*function change_DeliveryPeriod(item)
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
            }*/

            function change_Price(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var price = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_product_price');?>",
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
                    url : "<?php echo site_url('sales/performa_invoice_register/update_product_qty');?>",
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
                    url : "<?php echo site_url('sales/performa_invoice_register/update_product_discount_percentage');?>",
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

            /*function delete_order_product(d){
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
            }*/
        </script>


    </body>
</html>
