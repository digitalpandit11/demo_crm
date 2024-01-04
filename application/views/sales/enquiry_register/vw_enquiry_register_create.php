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
        <title>Create Lead</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <link rel="icon" href="<?php echo base_url().'assets/company_logo/logo.png'?>" type="image/ico" />
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php 
                $this->load->view('header_sidebar');
            ?> 
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Create Lead</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_enquiry_data'?>">Lead Register</a></li>
                                            <li class="breadcrumb-item">Enter Lead Details</li>
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
                                            <h3 class="card-title">Lead Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="enquiry_form" enctype="multipart/form-data" action="<?php echo site_url('sales/enquiry_register/save_enquiry');?>" method="post">
                                                
                                                <input type="hidden" id="customer_id_for_enquiry" name="customer_id_for_enquiry" value="<?php echo $customer_id?>" required>

                                                <div class="row">
                                                    <!-- <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> Enquiry Number </label>
                                                            <input type="text" name="enquiry_number" id="enquiry_number" class="form-control" value="<?php echo $enquiry_number?>" size="50" placeholder="Enter Enquiry Number" readonly>
                                                        </div>
                                                    </div> -->

                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Customer Name *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="customer_name" name="customer_name" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($customer_contact_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->contact_person.' - '.$row->email_id.' - '.$row->first_contact_no;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="customer_id" name="customer_id" required>

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

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Customer Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Contact Person </label>
                                                                            <input type="text" name="enquiry_contact_person" id="enquiry_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="enquiry_email_id" id="enquiry_email_id" class="form-control" size="50" placeholder="Customer Email Id" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer Contact Number </label>
                                                                            <input type="text" name="enquiry_contact_number" id="enquiry_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer State </label>
                                                                            <input type="text" name="enquiry_customer_state" id="enquiry_customer_state" class="form-control" size="50" placeholder="Customer State" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer City </label>
                                                                            <input type="text" name="enquiry_customer_city" id="enquiry_customer_city" class="form-control" size="50" placeholder="Customer City" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> State Code </label>
                                                                            <input type="text" name="enquiry_state_code" id="enquiry_state_code" class="form-control" size="50" placeholder="State Code" readonly>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Lead Description *</label>
                                                            <textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enter Lead Description" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Select Sales Engineer *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="employee_id" name="employee_id" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($employee_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->Emp_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Lead Type *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_type" name="enquiry_type" required>
                                                                <!-- <option value="">Select</option> -->
                                                                <!-- <option value="1">Pull Cord (MH)</option>
                                                                <option value="2">Porximity (PS)</option>
                                                                <option value="3">Vibrator Control (VC)</option>
                                                                <option value="4">Treading (TD)</option>    --> 
                                                                <option value="5">Other (OT)</option>
                                                                <!-- <option value="6">CUH & TD-MH</option>
                                                                <option value="7">TD-PS</option>
                                                                <option value="8">TD-VC</option> -->
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Lead Source *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_source" name="enquiry_source" required>
                                                                <!-- <option value="">Select</option>
                                                                <option value="1">Indiamart</option>
                                                                <option value="2">TradeIndia</option>
                                                                <option value="3">ExporterIndia</option>
                                                                <option value="4">Campaign</option>
                                                                <option value="5">Cold call</option>
                                                                <option value="6">Conference</option>
                                                                <option value="7">Direct call</option>
                                                                <option value="8">Existing Customer</option>
                                                                <option value="9">Email</option>
                                                                <option value="10">Expo</option>
                                                                <option value="11">Gem portal</option>
                                                                <option value="12">Other</option>
                                                                <option value="13">Principles</option>
                                                                <option value="14">Public relations</option>
                                                                <option value="15">Self generated</option>
                                                                <option value="16">Website</option>
                                                                <option value="17">Word of mouth</option>
                                                                <option value="18">Old database</option>
                                                                <option value="19">MID</option>
                                                                <option value="20">GID</option> -->
                                                                <option value="">No Selected</option>
                                                                <?php foreach($source_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->source_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Lead Urgency *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_urgency" name="enquiry_urgency" required>
                                                                <option value="">Select</option>
                                                                <option value="1">Cold Call </option>
                                                                <option value="2">Live Enquiry / Budgatory</option>
                                                                <option value="3">Hot Lead</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">   
                                                            <label for="employee_attachment">Attachment</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="employee_attachment[]" multiple id="employee_attachment">
                                                                    <label class="custom-file-label" for="employee_attachment">Choose Attachment</label>
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

                            <div class="row">
                                <!-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">Address Type *</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="address_type" name="address_type" required>
                                            <option value="3">Both(Bill To & Ship To)</option>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Address *</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">State Name *</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="state_id" name="state_id" required>
                                            <option value="">Select State</option>
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
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">State Code *</label>
                                        <input type="text" name="state_code" id="state_code" class="form-control" size="50" placeholder="State Code" required readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Pin Code <span style="color: #FF0000;"></span> </label>
                                        <input type="number" name="customer_pin_code" id="customer_pin_code" class="form-control" size="50" placeholder="Enter Customer Pin Code">
                                    </div>
                                </div>

                                <!-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label> State Code <span style="color: #FF0000;">* Mandatory</span> </label>
                                        <input type="number" name="customer_state_code" id="customer_state_code" class="form-control" size="50" placeholder="Enter Customer State Code" required>
                                    </div>
                                </div> -->

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
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Designation *</label>
                                        <input type="text" name="contact_person_designation" id="contact_person_designation" class="form-control" size="50" placeholder="Enter Contact Person Designation" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Contact Person *</label>
                                        <input type="text" name="contact_person" id="contact_person" class="form-control" size="50" placeholder="Enter Contact Person" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
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

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Alternate Contact Number </label>
                                        <input type="number" name="second_contact_no" id="second_contact_no" class="form-control" size="50" placeholder="Enter Alternate Contact Number">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> What's up Number </label>
                                        <input type="number" name="whatsup_no" id="whatsup_no" class="form-control" size="50" placeholder="Enter What's up Number">
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
        <script type="text/javascript">
            $(document).ready(function () {
                bsCustomFileInput.init();
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
                //call function get data edit
                get_customer_details();

                //load data for edit
                function get_customer_details(){
                    var id = $('[name="customer_id_for_enquiry"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('sales/enquiry_register/get_all_customer_data');?>",
                        method : "POST",
                        data :{id :id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="customer_name"]').val(data[i].Contact_id).trigger('change');
                            });
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
                            $('[name="customer_id"]').val(data[i].Customer_id);
                            $('[name="enquiry_contact_person"]').val(data[i].contact_person);
                            $('[name="enquiry_email_id"]').val(data[i].email_id);
                            $('[name="enquiry_contact_number"]').val(data[i].first_contact_no);
                            $('[name="enquiry_customer_state"]').val(data[i].state_name);
                            $('[name="enquiry_customer_city"]').val(data[i].city_name);
                            $('[name="enquiry_state_code"]').val(data[i].state_code);
                        })
                    }
                });
                return false;
            });

            $(document).on('click', '#add_address', function () {

                var address = $("#address").val();
                var state_id = $("#state_id").val();
                var city_id = $("#city_id").val();
                var customer_pin_code = $("#customer_pin_code").val();
                var state_code = $("#state_code").val();
                var customer_gst_number = $("#customer_gst_number").val();
                var customer_pan_number = $("#customer_pan_number").val();
                var designation = $("#contact_person_designation").val();
                var contact_person = $("#contact_person").val();
                var contact_person_email_id = $("#contact_person_email_id").val();
                var first_contact_no = $("#first_contact_no").val();
                var second_contact_no = $("#second_contact_no").val();
                var whatsup_no = $("#whatsup_no").val();
                var customer_name = $("#pop_up_customer_name").val();
                var customer_type = $("#customer_type").val();
                
                if(designation != "" && address != "" && state_id != "" && city_id != "" && state_code != "" && contact_person != "" && contact_person_email_id != "" && first_contact_no != "" && customer_name != "" && customer_type != "")
                {
                    $.ajax({
                            url : "<?php echo site_url('master/customer_master/save_customer_data');?>",
                            type : "POST",
                            data: {'designation': designation , 'address': address , 'state_id': state_id , 'city_id': city_id , 'customer_pin_code': customer_pin_code , 'state_code': state_code , 'customer_gst_number': customer_gst_number , 'customer_pan_number': customer_pan_number , 'contact_person': contact_person , 'contact_person_email_id': contact_person_email_id , 'first_contact_no': first_contact_no , 'second_contact_no': second_contact_no , 'whatsup_no': whatsup_no , 'customer_name': customer_name , 'customer_type': customer_type},
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
                        /*success: function(data){ 
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                 html += '<option value='+data[i].entity_id+'>'+data[i].city_name+'</option>';
                            }
                                $('#city_id').html(html);
                        }*/
                        success: function(response){

                            // Remove options 
                            $('#city_id').find('option').not(':first').remove();

                            // Add options
                            $.each(response,function(index,data){
                                $('#city_id').append('<option value="'+data['entity_id']+'">'+data['city_name']+'</option>');
                            });
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
                            $('[name="state_code"]').val(data[i].state_code);
                        })
                    }
                });
                return false;
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
         
                $('#pop_up_customer_name').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/check_customer_name');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success : function(data) {
                            //
                        //location.reload();
                        },
                        error : function(data) {
                            alert("Customer Already Exist");
                            //location.reload();
                            $("#pop_up_customer_name").val('');
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
    </body>
</html>