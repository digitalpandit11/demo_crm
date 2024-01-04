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
        <title>Create Quotation</title>
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

                date_default_timezone_set("Asia/Calcutta");
                $offer_date = date('Y-m-d');

                $salutation = "Dear Sir/Madam, We are pleased to confirm price schedule for your requirement as follows";
                $price_basis = "Ex-Works";
                $transport_insurance = "In Buyers Scope";
                $tax = "GST 18% Extra As per applicable rate";
                $delivery_schedule = "Within 2 weeks";
                $mode_of_payment = "By Cheque/NEFT";
                $mode_of_transport = "Freight-To Your Account";
                $guarantee_warrenty = "12 months from date of dispatch";
                $packing_forwarding = "3%";
                $payment_term = "100% Advanced against PI";
                $your_reference = "Your mail enquiry";
                $delivery_period = "4 To 5 Weeks from date of PO";
                $validity = "As Mentioned Above";
            ?> 
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Create Quotation Without Lead</h1>
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
                                            <form role="form" name="offer_form" enctype="multipart/form-data" action="<?php echo site_url('sales/offer_register/save_offer');?>" method="post">
                                                
                                                <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $entity_id;?>" required>

                                                <div class="row">
                                                    <div class="col-sm-6">
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

                                                    <div class="col-sm-6">
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
                                                            <textarea class="form-control" id="salutation" name="salutation" rows="3" placeholder="Enter Salutation" required><?php echo $salutation;?></textarea>
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
                                                            <input type="date" name="offer_date" id="offer_date" class="form-control" value="<?php echo $offer_date;?>" size="50" required>
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
                                                            <textarea class="form-control" id="transport_insurance" name="transport_insurance" rows="3" placeholder="Enter Transportation & Insurance"><?php echo $transport_insurance;?></textarea>
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
                                                            <textarea class="form-control" id="tax" name="tax" rows="3" placeholder="Enter Tax"><?php echo $tax; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Delivery Schedule *</label>
                                                            <textarea class="form-control" id="delivery_schedule" name="delivery_schedule" rows="3" placeholder="Enter Delivery Schedule"><?php echo $delivery_schedule; ?></textarea>
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
                                                            <textarea class="form-control" id="mode_of_payment" name="mode_of_payment" rows="3" placeholder="Enter Mode Of Payment"><?php echo $mode_of_payment; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Validity *</label>
                                                            <textarea class="form-control" id="validity" name="validity" rows="3" placeholder="Enter Validity"><?php echo $validity; ?></textarea>
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
                                                            <textarea class="form-control" id="packing_forwarding" name="packing_forwarding" rows="3" placeholder="Enter Packing & Forwarding Charges"><?php echo $packing_forwarding; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Guarantee/Waranty *</label>
                                                            <textarea class="form-control" id="guarantee_warrenty" name="guarantee_warrenty" rows="3" placeholder="Enter Guarantee/Waranty"><?php echo $guarantee_warrenty; ?></textarea>
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

                                                            <textarea class="form-control" id="payment_term" name="payment_term" rows="3" placeholder="Enter Payment Term" ><?php echo $payment_term; ?></textarea>
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
                                                            <textarea class="form-control" id="your_reference" name="your_reference" rows="3" placeholder="Enter Your Reference"><?php echo $your_reference; ?></textarea>
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
                                                                                <th>Delivery Period</th>
                                                                                <th>Warranty</th>
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
                                                                   </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                        <button type="button" class="btn btn-primary" id="product_checkbox_submited_new">Save</button>
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
                    var entity_id = $('[name="customer_id"]').val();  
                    $.ajax({
                        url : "<?php echo site_url('sales/offer_register/get_all_customer_data');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            console.log(data);
                                $('[name="customer_name"]').val(data.entity_id).trigger('change');
                        }
                    });
                }
            });

            $('#customer_name').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/offer_register/get_contact_person');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(response){

                        // Remove options 
                        $('#contact_id').find('option').not(':first').remove();

                        // Add options
                        $.each(response,function(index,data){
                            $('#contact_id').append('<option value="'+data['entity_id']+'">'+data['contact_person']+'</option>');
                        });
                    }
                });
                return false;
            });

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
                $("#product_checkbox_submited_new").on('click', function(event)
                {
                    $("#product_checkbox_submited_new").attr("disabled", true);
                    
                    var customer_name = document.getElementById('customer_name').value;
                    var contact_id = document.getElementById('contact_id').value;

                    var enquiry_descrption = document.getElementById('enquiry_descrption').value;
                    var employee_id = document.getElementById('employee_id').value;
                    var offer_type = document.getElementById('offer_type').value;
                    var offer_date = document.getElementById('offer_date').value;
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

                    var product_checkbox = table.$('input[type="checkbox"]').serializeArray();

                    if(customer_name != "" && contact_id != "" && product_checkbox != "")
                    {
                        $.ajax({
                            url:"<?php echo site_url('sales/offer_register/save_offer_without_lead');?>",
                            type: 'POST',
                            data: {'product_checkbox': product_checkbox,'enquiry_descrption': enquiry_descrption, 'employee_id': employee_id, 'offer_type': offer_type, 'offer_date': offer_date, 'dispatch_address': dispatch_address, 'delivery_instruction': delivery_instruction, 'packing_forwarding': packing_forwarding, 'payment_term': payment_term, 'special_instruction': special_instruction, 'price_condition': price_condition, 'salutation': salutation, 'price_basis': price_basis, 'transport_insurance': transport_insurance, 'tax': tax, 'delivery_schedule': delivery_schedule, 'mode_of_payment': mode_of_payment, 'your_reference': your_reference, 'customer_name': customer_name, 'contact_id': contact_id, 'validity': validity, 'guarantee_warrenty': guarantee_warrenty},
                            success: function(data){
                                window.location.href='<?php echo base_url();?>edit_offer_without_lead/'+data;
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
        </script>
    </body>
</html>