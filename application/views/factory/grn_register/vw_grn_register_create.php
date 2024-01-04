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
        <title>Create GRN</title>
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
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php 
                $this->load->view('header_sidebar');

                date_default_timezone_set("Asia/Calcutta");
                $current_day = date('Y-m-d');
            ?> 
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Create GRN</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_goods_receipt_note_data'?>">GRN</a></li>
                                            <li class="breadcrumb-item">Enter GRN Details</li>
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
                                            <h3 class="card-title">GRN Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="grn_form" enctype="multipart/form-data" action="<?php echo site_url('factory/grn_register/save_grn');?>" method="post">
                                                
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Vender Name *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="vender_id" name="vender_id" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($vender_details as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->vendor_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> GRN Date *</label>
                                                            <input type="date" class="form-control" id="grn_date" name="grn_date" value="<?php echo $current_day;?>" required> 
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Invoice Number </label>
                                                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="Enter Invoice Number"> 
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
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Document Date </label>
                                                            <input type="date" class="form-control" id="document_date" name="document_date"> 
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Document Description </label>
                                                            <textarea class="form-control" id="document_description" name="document_description" rows="3" placeholder="Enter Document Description"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Invoice Amount *</label>
                                                            <input type="text" class="form-control" id="invoice_amount" name="invoice_amount" placeholder="Enter Invoice Amount" required> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">   
                                                            <label for="attachment">Attachment</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="attachment[]" multiple id="attachment">
                                                                    <label class="custom-file-label" for="attachment">Choose Attachment</label>
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

                                                        <button type="button" class="btn btn-primary toastrDefaultSuccess" data-toggle="modal" data-target="#modal-lg-challan">
                                                            Save And Create Challan
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
                        <form role="form" name="pop_up_vender_master_form" id="pop_up_vender_master_form" method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Vender Name *</label>
                                        <input type="text" name="vender_name" id="vender_name" class="form-control" size="50" placeholder="Enter Vender Name" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
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
                                        <label style="color: #FF0000;">City Name * </label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="city_id" name="city_id" required>
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div> 

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">State Code * </label>
                                        <input type="text" name="state_code" id="state_code" class="form-control" size="50" placeholder="State Code" required readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Pin Code </label>
                                        <input type="number" name="pin_code" id="pin_code" class="form-control" size="50" placeholder="Enter Pin Code">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> GST Number </label>
                                        <input type="text" name="gst_number" id="gst_number" class="form-control" size="50" placeholder="Enter GST Number">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Phone Number </label>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control" size="50" placeholder="Enter Phone Number">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Contact Person </label>
                                        <input type="text" name="contact_person" id="contact_person" class="form-control" size="50" placeholder="Enter Contact Person" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Email Id </label>
                                        <input type="email" name="email_id" id="email_id" class="form-control" size="50" placeholder="Enter Email Id" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label style="color: #FF0000;"> Contact Number </label>
                                        <input type="number" name="contact_number" id="contact_number" class="form-control" size="50" placeholder="Enter Contact Number" required>
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


        <div class="modal fade" id="modal-lg-challan">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enter Challan Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="pop_up_challan_form" id="pop_up_challan_form" method="post">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label style="color: #FF0000;">Customer Name *</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="customer_id" name="customer_id" required>
                                            <option value="">Select Customer</option>
                                            <?php foreach($customer_list as $row):?>
                                            <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div> 
                            </div> 
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="create_challan" id="create_challan" class="btn btn-primary">Save</button>
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
        <!-- Page script -->
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> -->
        <script type="text/javascript">
            $(document).ready(function () {
                bsCustomFileInput.init();
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
         
            $(document).on('click', '#add_new_vendor', function () {

                var vender_name = $("#vender_name").val();
                var address = $("#address").val();
                var state_id = $("#state_id").val();
                var city_id = $("#city_id").val();
                var state_code = $("#state_code").val();
                var pin_code = $("#pin_code").val();
                var gst_number = $("#gst_number").val();
                var phone_number = $("#phone_number").val();
                var contact_person = $("#contact_person").val();
                var email_id = $("#email_id").val();
                var contact_number = $("#contact_number").val();
                
                if(vender_name != "" && address != "" && state_id != "" && city_id != "" && state_code != "" && contact_person != "" && email_id != "" && contact_number != "")
                {
                    $.ajax({
                        url : "<?php echo site_url('factory/grn_register/add_vender');?>",
                        type : "POST",
                        data: {'vender_name': vender_name , 'address': address , 'state_id': state_id , 'city_id': city_id , 'state_code': state_code , 'pin_code': pin_code , 'gst_number': gst_number , 'phone_number': phone_number , 'contact_person': contact_person , 'email_id': email_id , 'contact_number': contact_number},
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

            $(document).on('click', '#create_challan', function () {

                var vender_id = $("#vender_id").val();
                var grn_date = $("#grn_date").val();
                var invoice_number = $("#invoice_number").val();
                var document_date = $("#document_date").val();
                var document_description = $("#document_description").val();
                var invoice_amount = $("#invoice_amount").val();
                var customer_id = $("#customer_id").val();
                
                if(vender_id != "" && grn_date != "" && invoice_amount != "" && customer_id != "")
                {
                    $.ajax({
                        url : "<?php echo site_url('factory/grn_register/save_and_create_challan');?>",
                        type : "POST",
                        data: {'vender_id': vender_id , 'grn_date': grn_date , 'invoice_number': invoice_number , 'document_date': document_date , 'document_description': document_description , 'invoice_amount': invoice_amount , 'customer_id': customer_id},
                        success : function(data) {
                            data = data.trim();
                            window.location.href = "edit_challan/" + data;
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
