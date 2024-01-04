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
        <title>Update Order</title>
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
                                    <h1 class="card-title">Update Order</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_work_order_data'?>"> Order</a></li>
                                            <li class="breadcrumb-item">Update Order Details Of Id :- <?php  echo $entity_id; ?> </li>
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
                                            <h3 class="card-title">Order Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="work_order_form" enctype="multipart/form-data" action="<?php echo site_url('factory/work_order_register/save_work_order');?>" method="post">
                                                
                                                <input type="hidden" id="order_entity_id" name="order_entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Order Type </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="order_type" name="order_type" disabled>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Work Order</option>
                                                                <option value="2">Tred Order</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Special Customer</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="special_customer" name="special_customer" disabled>
                                                                <option value="">Not Selected</option>
                                                                <option value="1">S-Sayali</option>
                                                                <option value="2">M-Maitri</option>
                                                                <option value="3">E-ESPL</option>
                                                                <option value="4">K-Kanha</option>
                                                                <option value="5">A-ACG</option>
                                                                <option value="6">X-Other</option>
                                                            </select>
                                                        </div>
                                                    </div> 

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Work Order Number </label>
                                                            <input type="text" name="order_number" id="order_number" class="form-control"  size="50" placeholder="Enter Order Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Work Order Date </label>
                                                            <input type="date" name="order_date" id="order_date" class="form-control"  size="50">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Issued By</label>
                                                            <input type="text" name="issued_by" id="issued_by" class="form-control" placeholder="Enter Issued By">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Issued To</label>
                                                            <input type="text" name="issued_to" id="issued_to" class="form-control" placeholder="Enter Issued To">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Standard Note</label>
                                                            <input type="text" name="standard_note" id="standard_note" class="form-control" placeholder="Enter Standard Note" value="F-MKTG-01-REV2">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Urgency</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="urgency" name="urgency">
                                                                <option value="">Not Selected</option>
                                                                <option value="1">Urgent</option>
                                                                <option value="2">Normal</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Sales Order Number </label>
                                                            <input type="text" name="sales_order_number" id="sales_order_number" class="form-control"  size="50" placeholder="Enter Sales Order Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Customer PO No </label>
                                                            <input type="text" name="po_no" id="po_no" class="form-control"  size="50" placeholder="Enter po_no" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> PO Date </label>
                                                            <input type="date" name="po_date" id="po_date" class="form-control"  size="50" placeholder="Enter po_date" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Customer Name </label>
                                                            <input type="text" name="customer_name" id="customer_name" class="form-control"  size="50" placeholder="Enter po_no" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Order Description *</label>
                                                            <textarea class="form-control" id="order_descrption" name="order_descrption" rows="3" placeholder="Enter Order Description" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Expected Order Delivery Data </label>
                                                            <input type="date" name="exp_delivery_date" id="exp_delivery_date" class="form-control"  size="50" onchange="change_exp_delivery_date(this);">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Workorder Type *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="workorder_type" name="workorder_type" required>
                                                                <option value="">Select</option>
                                                                <option value="1">Pull Cord (MH)</option>
                                                                <option value="2">Porximity (PS)</option>
                                                                <option value="3">Vibrator Control (VC)</option>
                                                                <option value="4">Treading (TD)</option>    
                                                                <option value="5">Other (OT)</option>
                                                            </select>
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
                                                                <!-- <div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
                                                                    <a data-toggle="modal" data-target="#modal-product" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
                                                                        Select Product
                                                                    </a>
                                                                </div> -->

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
                                                                                <th>Product Description</th>
                                                                                <th>Product id</th>
                                                                                <th>Order Qty</th>
                                                                                <th>Ready Qty</th>
                                                                                <th>Dispatch Qty</th>
                                                                                <th>Sales Comment</th>
                                                                                <th>Factory Comment</th>
                                                                                <th>Expected Delivery Date</th>
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
                                                                                  $product_id = $row->product_id;
                                                                            ?>
                                                                            <tr>
                                                                                <td style="display: none;" class="order_relation_entity_id" id="order_relation_entity_id"><?php echo $order_reational_entity_id;?></td>
                                                                                <td><?php echo $no;?></td>
                                                                                <td><?php echo $product_name;?></td>
                                                                                <td>
                                                                                    <textarea class="form-control" id="product_custom_description" name="product_custom_description" style="width: 300px;" rows="3" placeholder="Product Description" onchange="change_product_custom_description(this);"><?php echo $row->product_custom_description;?></textarea>   
                                                                                </td>
                                                                                <td><?php echo $product_id;?></td>
                                                                                <td><?php echo $row->work_order_qty;?></td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->ready_qty;?>" id="product_ready_qty" name="product_ready_qty" placeholder="Enter Qty" style="width: 100px;" onchange="change_ProductRedQty(this);">   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" value="<?php echo $row->dispatch_qty;?>" id="product_dis_qty" name="product_dis_qty" placeholder="Enter Qty" style="width: 100px;" onchange="change_ProductDisQty(this);">   
                                                                                </td>
                                                                                <td>
                                                                                    <textarea class="form-control" id="sales_comment" name="sales_comment" style="width: 300px;" rows="3" placeholder="Enter Sales Comment" onchange="change_SalesComment(this);"><?php echo $row->sales_comment;?></textarea>   
                                                                                </td>
                                                                                <td>
                                                                                    <textarea class="form-control" id="factory_comment" name="factory_comment" style="width: 300px;" rows="3" placeholder="Enter Factory Comment" onchange="change_FactoryComment(this);"><?php echo $row->factory_comment;?></textarea>   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="date" class="form-control" value="<?php echo $row->expected_delivery_date;?>" id="exp_date" name="exp_date" style="width: 150px;" onchange="change_ExpDate(this);">   
                                                                                </td>
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
                                                        <!-- <button type="button" class="btn btn-success toastrDefaultSuccess" data-toggle="modal" data-target="#modal-sm">
                                                            Save & Close
                                                        </button> -->
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
        <div class="modal fade" id="modal-sm">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Close Order</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do You Want To Close Order ? </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" name="confirm_order" id="confirm_order" class="btn btn-primary">Yes</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

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
                                        <label>HSN Code <span style="color: #FF0000;">* Mandatory</span></label>
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
                                        <label>Category <span style="color: #FF0000;">* Mandatory </span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="category_id" name="category_id">
                                            <option value="">No Selected</option>
                                            <?php foreach($product_category as $row):?>
                                            <option value="<?php echo $row->entity_id;?>"><?php echo $row->category_name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label> Sub Category <span style="color: #FF0000;">* </span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="sub_category_id" name="sub_category_id">
                                            <option value="">No Selected</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label> Product Id</label>
                                        <input type="text" name="product_id" id="product_id" class="form-control" placeholder="Enter Product Id" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label> Product Name<span style="color: #FF0000;">* Mandatory Field</span></label>
                                        <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter Product Name">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Product Type</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="product_type" name="product_type">
                                            <!-- <option value="">No Selected</option> -->
                                            <option value="1">FG</option>
                                            <option value="2">RM</option>
                                            <option value="3">BOTH</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
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
        <!-- Page script -->
        <!-- DataTables -->
        <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
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
                        url : "<?php echo site_url('factory/work_order_register/get_first_category_order_details_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="order_type"]').val(data[i].work_order_type).trigger('change');
                                $('[name="special_customer"]').val(data[i].special_customer).trigger('change');
                                $('[name="issued_by"]').val(data[i].issued_by);
                                $('[name="issued_to"]').val(data[i].issued_to);
                                // $('[name="standard_note"]').val(data[i].standard_note);
                                $('[name="urgency"]').val(data[i].urgency).trigger('change');
                                $('[name="order_number"]').val(data[i].work_order_no);
                                $('[name="order_date"]').val(data[i].work_order_date);
                                $('[name="order_descrption"]').val(data[i].sales_order_description);
                                $('[name="exp_delivery_date"]').val(data[i].expected_delivery_date);
                                $('[name="sales_order_number"]').val(data[i].sales_order_no);
                                $('[name="po_no"]').val(data[i].po_no);
                                $('[name="po_date"]').val(data[i].po_date);
                                $('[name="customer_name"]').val(data[i].customer_name);
                                
                                $('[name="workorder_type"]').val(data[i].workorder_type).trigger('change');
                            });
                        }
                    });
                }
            });
        </script>

        <script type="text/javascript">

            function change_product_custom_description(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var product_custom_description = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('factory/work_order_register/update_product_custom_description');?>",
                    method : "POST",
                    data : {'product_custom_description': product_custom_description,
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
                    url : "<?php echo site_url('factory/work_order_register/update_product_qty');?>",
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

            function change_ProductRedQty(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var product_ready_qty = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('factory/work_order_register/update_product_ready_qty');?>",
                    method : "POST",
                    data : {'product_ready_qty': product_ready_qty,
                            'order_relation_entity_id': order_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    },
                    error: function(){
                        alert("Enter Proper Qty...");
                        location.reload();
                    }
                });
                return false;
            }

            function change_ProductDisQty(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var product_dis_qty = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('factory/work_order_register/update_product_dispatch_qty');?>",
                    method : "POST",
                    data : {'product_dis_qty': product_dis_qty,
                            'order_relation_entity_id': order_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    },
                    error: function(){
                        alert("Enter Proper Qty...");
                        location.reload();
                    }
                });
                return false;
            }

            function change_SalesComment(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var sales_comment = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('factory/work_order_register/update_product_sales_comment');?>",
                    method : "POST",
                    data : {'sales_comment': sales_comment,
                            'order_relation_entity_id': order_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_FactoryComment(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var factory_comment = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('factory/work_order_register/update_product_factory_comment');?>",
                    method : "POST",
                    data : {'factory_comment': factory_comment,
                            'order_relation_entity_id': order_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_ExpDate(item)
            {
               var order_relation_entity_id = $(item).closest('tr').find('.order_relation_entity_id ').text();
               var exp_date = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('factory/work_order_register/update_product_expected_dev_date');?>",
                    method : "POST",
                    data : {'exp_date': exp_date,
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
                    url : "<?php echo site_url('factory/work_order_register/delete_order_product');?>",
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
           $(function()
           {
                $("#product_checkbox_submited").on('click', function(event){
                    var entity_id = document.getElementById('order_entity_id').value;
                    var exp_delivery_date = document.getElementById('exp_delivery_date').value;
                    var order_date = document.getElementById('order_date').value;
                    var order_descrption = document.getElementById('order_descrption').value;

                    var po_no = document.getElementById('po_no').value;
                    var po_date = document.getElementById('po_date').value;

                    var product_checkbox = [];
                    $.each($("input[name='product_checkbox']:checked"), function(){            
                        product_checkbox.push($(this).val());
                    });

                    if(product_checkbox !="" && entity_id !="")
                    {
                        $.ajax({
                            url:"<?php echo site_url('factory/work_order_register/update_work_order_product');?>",
                            type: 'POST',
                            data: {'entity_id': entity_id, 'exp_delivery_date': exp_delivery_date,'order_date': order_date, 'order_descrption': order_descrption, 'product_checkbox': product_checkbox, 'po_no': po_no, 'po_date': po_date},
                                success : function(data) {
                                    data = data.trim();
                                    location.reload();
                                },
                                error: function(){
                                   alert("Fail")
                                }
                        });
                    }else{
                        alert("Enter All Details");
                    }
                });
            });

           $(document).on('click', '#confirm_order', function () {

                var entity_id = document.getElementById('order_entity_id').value;
                var exp_delivery_date = document.getElementById('exp_delivery_date').value;
                var order_date = document.getElementById('order_date').value;
                var order_descrption = document.getElementById('order_descrption').value;
                
                if(entity_id != "")
                {    
                    $.ajax({
                        url : "<?php echo site_url('factory/work_order_register/confirm_order');?>",
                        type : "POST",
                        data: {'entity_id': entity_id, 'exp_delivery_date': exp_delivery_date,'order_date': order_date, 'order_descrption': order_descrption},
                        success : function(data) {
                            //location.reload();
                            window.location.href = "<?php echo site_url('vw_work_order_data');?>";
                        },
                        error : function(data) {
                            alert("Failed !!!");
                        }
                    });
                }else{
                    alert("Enter Required Details");
                }
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
                
                $('#product_details_table').DataTable()({
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
            function change_exp_delivery_date(item)
            {
               var order_entity_id = document.getElementById('order_entity_id').value;
               //alert(order_entity_id);
               var exp_delivery_date = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('factory/work_order_register/update_exp_delivery_date');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'exp_delivery_date': exp_delivery_date},
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
