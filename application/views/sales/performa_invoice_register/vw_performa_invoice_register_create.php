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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_performa_invoice_data'?>">Performa Invoice</a></li>
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
                                            <form role="form" name="performa_detail_form" enctype="multipart/form-data" action="<?php echo site_url('sales/performa_invoice_register/save_performa_invoice');?>" method="post">
                                                
                                                <input type="hidden" id="order_entity_id" name="order_entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Performa Invoice Number </label>
                                                            <input type="text" name="performa_number" id="performa_number" class="form-control"  size="50" placeholder="Enter Performa Invoice Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Sales Order Number </label>
                                                            <input type="text" name="sales_order_number" id="sales_order_number" class="form-control"  size="50" placeholder="Enter Sales Order Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Original Customer Name </label>
                                                            <input type="text" name="customer_name" id="customer_name" class="form-control"  size="50" placeholder="Enter Customer Name" readonly>
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
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Company </label>
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="ship_to_party_id" name="ship_to_party_id" onchange="ship_to_company_change(this);">
                                                                                <option value="">Not Selected</option>
                                                                                <?php foreach($customer_list as $row):?>
                                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- <input type="" id="ship_to_party_id" name="ship_to_party_id"> -->

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Address</label>
                                                                            <!-- <textarea class="form-control" id="ship_to_address" name="ship_to_address" rows="3" placeholder="Enter Ship To Address" onchange="ship_to_addressss(this);"></textarea> -->
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="ship_to_address_id" name="ship_to_address_id" onchange="ship_to_addressss(this);" required>
                                                                                <option></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- <input type="" id="ship_to_address_id" name="ship_to_address_id"> -->

                                                                <!-- <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Ship To Company </label>
                                                                            <input type="text" name="ship_to_company" id="ship_to_company" class="form-control" size="50" placeholder="Enter Ship To Company" onchange="ship_to_company_change(this);">
                                                                        </div>
                                                                    </div>
                                                                </div> -->

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <!-- <input type="text" name="customer_ship_to_contact_person" id="customer_ship_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" onchange="ship_to_contact_personsss(this);"> -->
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="ship_to_contact_id" name="ship_to_contact_id" onchange="ship_to_contact_person(this);" required>
                                                                                <option></option>
                                                                            </select>
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
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Company </label>
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bill_to_party_id" name="bill_to_party_id" onchange="bill_to_company_change(this);">
                                                                                <option value="">Not Selected</option>
                                                                                <?php foreach($customer_list as $row):?>
                                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Company </label>
                                                                            <input type="text" name="bill_to_company" id="bill_to_company" class="form-control" size="50" placeholder="Enter Bill To Company" onchange="bill_to_company_change(this);">
                                                                        </div>
                                                                    </div> -->
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label> Bill To Address</label>
                                                                            <!-- <textarea class="form-control" id="bill_to_address" name="bill_to_address" rows="3" placeholder="Enter Bill To Address" onchange="bill_to_addressss(this);"></textarea> -->
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bill_to_address_id" name="bill_to_address_id" onchange="bill_to_addressss(this);" required>
                                                                                <option></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Contact Person </label>
                                                                            <!-- <input type="text" name="bill_to_contact_person" id="bill_to_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" onchange="bill_to_contact_personsss(this);"> -->
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bill_to_contact_id" name="bill_to_contact_id" onchange="bill_to_contact_personsss(this);" required>
                                                                                <option></option>
                                                                            </select>
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
                        url : "<?php echo site_url('sales/performa_invoice_register/get_performa_details_by_id');?>",
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
                                $('[name="customer_name"]').val(data[i].customer_name);
                                $('[name="customer_id"]').val(data[i].customer_id);

                                $('[name="ship_to_party_id"]').val(data[i].ship_to_id).trigger('change');
                                $('[name="ship_to_address_id"]').val(data[i].ship_to_address_id).trigger('change');
                                $('[name="ship_to_contact_id"]').val(data[i].ship_to_contact_person_id).trigger('change');
                                $('[name="ship_to_gst_no"]').val(data[i].ship_to_gst_no);
                                $('[name="ship_to_email_id"]').val(data[i].ship_to_contact_person_mail_id);
                                $('[name="ship_to_contact_number"]').val(data[i].ship_to_contact_person_number);

                                $('[name="bill_to_party_id"]').val(data[i].bill_to_id).trigger('change');
                                $('[name="bill_to_address_id"]').val(data[i].bill_to_address_id).trigger('change');
                                $('[name="bill_to_contact_id"]').val(data[i].bill_to_contact_person_id).trigger('change');
                                $('[name="bill_to_gst_no"]').val(data[i].bill_to_gst_no);
                                $('[name="bill_to_email_id"]').val(data[i].bill_to_contact_person_mail_id);
                                $('[name="bill_to_contact_number"]').val(data[i].bill_to_contact_person_number);
                            });
                        }
                    });
                }
            });
        </script>


        <script type="text/javascript">
            $(document).ready(function(){
         
                /*$('#ship_to_party_id').change(function(){ 
                    var id=$(this).val();
                    $.ajax({
                        url : "<?php echo site_url('sales/performa_invoice_register/get_ship_to_address');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){ 
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                 html += '<option value='+data[i].Cust_ship_id+'>'+data[i].Cust_ship_address+'</option>';
                            }
                                $('#ship_to_address_id').html(html);
                        }
                    });
                    return false;
                }); */

                $('#ship_to_party_id').change(function(){ 
                    var id=$(this).val();
                    var ship_to_address_id = "<?php echo $ship_to_address_id;?>";
                    //alert(model_id);
                    $.ajax({
                        url : "<?php echo site_url('sales/performa_invoice_register/get_ship_to_address');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){

                            $('select[name="ship_to_address_id"]').empty();

                            $.each(data, function(key, value) {
                                if(ship_to_address_id==value.Cust_ship_id){
                                    $('select[name="ship_to_address_id"]').append('<option value="'+ value.Cust_ship_id +'" selected>'+ value.Cust_ship_address +'</option>').trigger('change');
                                }else{
                                    $('select[name="ship_to_address_id"]').append('<option value=""></option>');
                                    $('select[name="ship_to_address_id"]').append('<option value="'+ value.Cust_ship_id +'">'+ value.Cust_ship_address +'</option>');
                                }
                            });

                        }
                    });
                    return false;
                });


            });
        </script>

        <script type="text/javascript">
            /*$('#state_id').change(function(){ 
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
            }); */
            $('#ship_to_address_id').change(function(){ 
                var id1="<?php echo $ship_to_address_id;?>";

                if(id1 != "")
                {
                    id = id1;
                }else{
                    var id=$(this).val();
                }
                var ship_to_contact_person_id = "<?php echo $ship_to_contact_person_id;?>";
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/get_ship_to_contact');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){

                        $('select[name="ship_to_contact_id"]').empty();

                        $.each(data, function(key, value) {
                            if(ship_to_contact_person_id==value.entity_id){

                                $('select[name="ship_to_contact_id"]').append('<option value="'+ value.entity_id +'" selected>'+ value.contact_person +'</option>').trigger('change');
                            }else{
                                $('select[name="ship_to_contact_id"]').append('<option value=""></option>');
                                $('select[name="ship_to_contact_id"]').append('<option value="'+ value.entity_id +'">'+ value.contact_person +'</option>');
                            }
                        });

                    }
                });
                return false;
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function(){

                $('#bill_to_party_id').change(function(){ 
                    var id=$(this).val();
                    var bill_to_address_id = "<?php echo $bill_to_address_id;?>";
                    //alert(model_id);
                    $.ajax({
                        url : "<?php echo site_url('sales/performa_invoice_register/get_bill_to_address');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){

                            $('select[name="bill_to_address_id"]').empty();

                            $.each(data, function(key, value) {
                                if(bill_to_address_id==value.Cust_bill_id){
                                    $('select[name="bill_to_address_id"]').append('<option value="'+ value.Cust_bill_id +'" selected>'+ value.Cust_bill_address +'</option>').trigger('change');
                                }else{
                                    $('select[name="bill_to_address_id"]').append('<option value=""></option>');
                                    $('select[name="bill_to_address_id"]').append('<option value="'+ value.Cust_bill_id +'">'+ value.Cust_bill_address +'</option>');
                                }
                            });

                        }
                    });
                    return false;
                });
            });
        </script>

        <script type="text/javascript">
            $('#bill_to_address_id').change(function(){ 
                var id1="<?php echo $bill_to_address_id;?>";
                if(id1 != "")
                {
                    id = id1;
                }else{
                    var id=$(this).val();
                }

                // var id=$(this).val();
                var bill_to_contact_person_id = "<?php echo $bill_to_contact_person_id;?>";
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/get_bill_to_contact');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){

                        $('select[name="bill_to_contact_id"]').empty();

                        $.each(data, function(key, value) {
                            if(bill_to_contact_person_id==value.entity_id){
                                $('select[name="bill_to_contact_id"]').append('<option value="'+ value.entity_id +'" selected>'+ value.contact_person +'</option>').trigger('change');
                            }else{
                                $('select[name="bill_to_contact_id"]').append('<option value=""></option>');
                                $('select[name="bill_to_contact_id"]').append('<option value="'+ value.entity_id +'">'+ value.contact_person +'</option>');
                            }
                        });

                    }
                });
                return false;
            });
        </script>

        <script type="text/javascript">
            function ship_to_company_change(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_company_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_ship_to_company_name_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_company_id': ship_to_company_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function ship_to_addressss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_address_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_ship_to_address_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_address_id': ship_to_address_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function ship_to_contact_person(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_contact_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_ship_to_contact_person_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_contact_id': ship_to_contact_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function ship_to_email_idss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_email_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_ship_to_email_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_email_id': ship_to_email_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        /*location.reload();*/
                    }
                });
                return false;
            }

            function ship_to_contact_numberss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_contact_number = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_ship_to_contact_number_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_contact_number': ship_to_contact_number},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        /*location.reload();*/
                    }
                });
                return false;
            }

            function ship_to_gst_noss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var ship_to_gst_number = item.value;
                // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_ship_to_gst_number_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'ship_to_gst_number': ship_to_gst_number},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        /*location.reload();*/
                    }
                });
                return false;
            }
        </script>

        <script type="text/javascript">
            function bill_to_company_change(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_company_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_bill_to_company_name_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_company_id': bill_to_company_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function bill_to_addressss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_address_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_bill_to_address_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_address_id': bill_to_address_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function bill_to_contact_personsss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_contact_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_bill_to_contact_person_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_contact_id': bill_to_contact_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function bill_to_email_idss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_email_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_bill_to_email_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_email_id': bill_to_email_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        /*location.reload();*/
                    }
                });
                return false;
            }

            function bill_to_contact_numberss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_contact_number = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_bill_to_contact_number_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_contact_number': bill_to_contact_number},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        /*location.reload();*/
                    }
                });
                return false;
            }

            function bill_to_gst_noss(item)
            {
                var order_entity_id = $('[name="order_entity_id"]').val();
                var bill_to_gst_number = item.value;
                // alert(ship_to_email_id);
               
                $.ajax({
                    url : "<?php echo site_url('sales/performa_invoice_register/update_bill_to_gst_number_edit_page');?>",
                    method : "POST",
                    data : {'order_entity_id': order_entity_id,
                            'bill_to_gst_number': bill_to_gst_number},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        /*location.reload();*/
                    }
                });
                return false;
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
    </body>
</html>
