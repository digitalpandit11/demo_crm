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
        <title>Create Customer Master</title>
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
        <link rel="icon" href="<?php echo base_url().'assets/company_logo/QFS_Logo.png'?>" type="image/ico" />
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
                                    <h1 class="card-title">Create Customer</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_erp_product_vw_customer_master'?>">Customer Master</a></li>
                                            <li class="breadcrumb-item">Enter Customer Details</li>
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
                                            <h3 class="card-title">Customer Master Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="customer_master" action="<?php echo site_url('master/customer_master/save_address');?>" method="post">
                                                
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Customer Name <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <input type="text" name="customer_name" id="customer_name" class="form-control" size="50" placeholder="Enter Customer Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Customer Type <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="customer_type" name="customer_type" required>
                                                                <option value="">No Selected</option>
                                                                <option value="1">Dealer</option>
                                                                <option value="2">End User</option>
                                                                <option value="3">OEM</option>
                                                                <option value="4">Trader</option>
                                                                <option value="5">System Integrator</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Address <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address" required></textarea>
                                                        </div>
                                                    </div>
                                                  </div>
                                                  
                                                  <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>State Name <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="state_id" name="state_id" required>
                                                                <option value="">Select State</option>
                                                                <?php foreach($state_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->State_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div> 

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>City Name <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="city_id" name="city_id" required>
                                                            <option value="">Select City</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>State Code <span style="color: #FF0000;">* Mandatory</span> </label>
                                                            <input type="text" name="state_code" id="state_code" class="form-control" size="50" placeholder="State Code" readonly>
                                                        </div>
                                                    </div> 

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Lead Source *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="lead_source" name="lead_source" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($source_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->source_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
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

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> GST Number </label>
                                                            <input type="text" name="customer_gst_number" id="customer_gst_number" class="form-control" size="50" placeholder="Enter GST Number">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Note for Customer <span style="color: #FF0000;"></span> </label>
                                                            <textarea class="form-control" id="customer_note" name="customer_note" rows="3" placeholder="Enter Note" ></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Pan Number </label>
                                                            <input type="text" name="customer_pan_number" id="customer_pan_number" class="form-control" size="50" placeholder="Enter Pan Number">
                                                        </div>
                                                    </div> -->
                                                </div>

                                                

                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped" id="dynamic_field">
                                                            <tr>  
                                                                <td>
                                                                    <label><span>Designation </span></label>
                                                                    <input type="text" name="designation[]" class="form-control" placeholder="Enter Designation">

                                                                    <label><span>Department </span></label>
                                                                    <input type="text" name="department[]" class="form-control" placeholder="Enter Department">

                                                                    <label><span style="color: #FF0000;">Contact Person * </span></label>
                                                                    <input type="text" name="contact_person[]" class="form-control" placeholder="Enter Contact Person" required>

                                                                    <label><span style="color: #FF0000;">Email Id * </span></label>
                                                                    <input type="email" name="email_id[]" placeholder="Enter Email Id" class="form-control" required>

                                                                    <label><span style="color: #FF0000;">Contact Number * </span></label>
                                                                    <input type="text" name="contact_number[]" class="form-control" placeholder="Enter Contact Number" required>

                                                                    <label> Alternate Contact Number </label>
                                                                    <input type="text" name="alternate_contact_number[]" class="form-control" placeholder="Enter Alternate Contact Number">

                                                                    <label> Note for Person </label>
                                                                    <input type="text" name="contact_note[]" class="form-control" placeholder="Enter Whats Up Number">
                                                                </td>  
                                                
                                                                <td>
                                                                    <center>
                                                                        <button style="margin-top: 180px; margin-left: 20px;" type="button" name="add" id="add" class="btn btn-success">Add More Contact Details</button>
                                                                    </center>
                                                                </td>  
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <center>
                                                        <button type="submit" name="submit" id="submit" value="Submit" class="btn btn-success toastrDefaultSuccess">
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
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
        <!-- Page script -->
        <script type="text/javascript">

            $('#customer_name').change(function(){ 
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
                            $("#customer_name").val('');
                        }
                    });
                return false;
            });

            $(document).on('click', '#add_address', function () {

                var customer_name = $("#customer_name").val();
                var customer_type = $("#customer_type").val();
                // var address_type = $("#address_type").val();
                var address = $("#address").val();
                var state_id = $("#state_id").val();
                var city_id = $("#city_id").val();
                var customer_pin_code = $("#customer_pin_code").val();
                var state_code = $("#state_code").val();
                var customer_gst_number = $("#customer_gst_number").val();
                var customer_note = $("#customer_note").val();
                // var customer_pan_number = $("#customer_pan_number").val();
                var designation = $("#designation").val();
                var department = $("#department").val();
                var contact_person = $("#contact_person").val();
                var contact_person_email_id = $("#contact_person_email_id").val();
                var first_contact_no = $("#first_contact_no").val();
                var second_contact_no = $("#second_contact_no").val();
                // var whatsup_no = $("#whatsup_no").val();
                var contact_note = $("#contact_note").val();
                
                if(address != "" && state_id != "" && city_id != "" && contact_person != "" && contact_person_email_id != "" && first_contact_no != "" && customer_name != "" && customer_type != "")
                {
                    $.ajax({
                            url : "<?php echo site_url('master/customer_master/save_address');?>",
                            type : "POST",
                            data: {
                                    'customer_type': customer_type,
                                    'customer_name': customer_name ,
                                    'address': address ,
                                    'state_id': state_id ,
                                    'city_id': city_id ,
                                    'customer_pin_code': customer_pin_code ,
                                    'state_code': state_code ,
                                    'customer_gst_number': customer_gst_number ,
                                    'customer_note': customer_note ,
                                    'designation': designation ,
                                    'department': department ,
                                    'contact_person': contact_person ,
                                    'contact_person_email_id': contact_person_email_id ,
                                    'first_contact_no': first_contact_no ,
                                    'second_contact_no': second_contact_no ,
                                    'contact_note': contact_note
                                  },
                            success : function(data) {
                                data = data.trim();
                                window.location.href = "edit_customer_master/" + data;
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
            $(function()
            {
                var i=1;  
                $("#add").on('click', function(event){
                    i++;  
                    $('#dynamic_field').append(
                      '<tr id="row'+i+'" class="dynamic-added">'+
                      '<td><label><span style="color: #FF0000;">Designation * </span></label><input type="text"       name="designation[]" class="form-control" placeholder="Enter Designation">'+
                      '<label><span style="color: #FF0000;">Department * </span></label>'+
                      '<input type="text" name="department[]" class="form-control" placeholder="Enter Department">'+
                      '<label><span style="color: #FF0000;">Contact Person * </span></label>'+
                      '<input type="text" name="contact_person[]" class="form-control" placeholder="Enter Contact Person" required>'+
                      '<label><span style="color: #FF0000;">Email Id * </span></label>'+
                      '<input type="email" name="email_id[]" placeholder="Enter Email Id" class="form-control" required>'+
                      '<label><span style="color: #FF0000;">Contact Number * </span></label>'+
                      '<input type="text" name="contact_number[]" class="form-control" placeholder="Enter Contact Number" required>'+
                      '<label> Alternate Contact Number </label>'+
                      '<input type="text" name="alternate_contact_number[]" class="form-control" placeholder="Enter Alternate Contact Number">'+
                      '<label> Note for Person </label>'+
                      '<input type="text" name="contact_note[]" class="form-control" placeholder="Enter Whats Up Number"></td>'+
                      '<td><button type="button" style="margin-top: 180px; margin-left: 20px;" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'+
                      '</tr>');  
                });

                $(document).on('click', '.btn_remove', function(){  
                    var button_id = $(this).attr("id");   
                    $('#row'+button_id+'').remove();  
                });
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
