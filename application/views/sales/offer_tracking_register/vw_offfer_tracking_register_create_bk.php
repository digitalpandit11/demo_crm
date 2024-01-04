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
        <title>Create Offer Tracking Record</title>
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
            <?php $this->load->view('header_sidebar');?> 
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Create Offer Tracking</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_tracking_entry'?>">Offer Tracking Register</a></li>
                                            <li class="breadcrumb-item">Offer Tracking Details</li>
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
                                            <h3 class="card-title">Offer Tracking Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="enquiry_tracking_form" enctype="multipart/form-data" action="<?php echo site_url('sales/enquiry_tracking_register/save_enquiry_tracking');?>" method="post">

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Offer Tracking Number </label>
                                                            <input type="text" name="offer_tracking_number" id="offer_tracking_number" class="form-control" value="<?php echo $offer_tracking_number?>" size="50" placeholder="Enter Offer Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Customer Name <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <select class="form-control select2bs4"  style="width: 100%;" id="customer_id" name="customer_id">
                                                                <option value="">No Selected</option>
                                                                <?php foreach($customer_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Enquiry Number <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_id" name="enquiry_id" required>
                                                                <option value="">No Selected</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Offer Number <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="offer_id" name="offer_id" required>
                                                                <option value="">No Selected</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Offer Tracking Date </label>
                                                            <input type="date" name="enquiry_tracking_date" id="enquiry_tracking_date" required class="form-control" size="50">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Enquiry Description  </label>
                                                            <textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enquiry Description" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Offer Description  </label>
                                                            <textarea class="form-control" id="offer_description" name="offer_description" rows="3" placeholder="Enquiry Description" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Offer Tracking Description <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                                            <textarea class="form-control" id="enquiry_tracking_descrption" name="enquiry_tracking_descrption" rows="3" placeholder="Enter Enquiry Tracking Description" required></textarea>
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
        <!-- Page script -->
        <script type="text/javascript">
            $(document).ready(function () {
                bsCustomFileInput.init();
            });
        </script>
        <script type="text/javascript">
            //load data for edit
            /*$('#enquiry_id').change(function(){
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/enquiry_tracking_register/get_all_customer_data');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val = 
                            $('[name="customer_id"]').val(data[i].Cust_id);
                            $('[name="customer_name"]').val(data[i].customer_name);
                        })
                    }
                });
                return false;
            });*/

            $('#customer_id').change(function(){ 
                var id=$(this).val();
                $.ajax({
                        url : "<?php echo site_url('sales/offer_tracking_register/get_all_enquiry');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){
                             
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option value='+data[i].entity_id+'>'+data[i].enquiry_no+'</option>';
                            }
                            $('#enquiry_id').html(html);
                        }
                        
                        /*success: function(response){
                            $.each(response,function(index,data){
                               $('#pop_up_vehicle_model').append('<option value="'+data['entity_id']+'">'+data['vehicle_model_name']+'</option>');
                            });
                        }*/
                    });
                return false;
            });

            $('#enquiry_id').change(function(){
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/offer_tracking_register/get_all_enquiry_data');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val = 
                            $('[name="enquiry_descrption"]').val(data[i].enquiry_short_desc);
                        })
                    }
                });
                return false;
            });


            $('#enquiry_id').change(function(){ 
                var id=$(this).val();
                $.ajax({
                        url : "<?php echo site_url('sales/offer_tracking_register/get_all_offer');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){
                             
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option value='+data[i].entity_id+'>'+data[i].offer_no+'</option>';
                            }
                            $('#offer_id').html(html);
                        }
                        
                        /*success: function(response){
                            $.each(response,function(index,data){
                               $('#pop_up_vehicle_model').append('<option value="'+data['entity_id']+'">'+data['vehicle_model_name']+'</option>');
                            });
                        }*/
                    });
                return false;
            });


            $('#offer_id').change(function(){
                var id=$(this).val();
                //alert(id);
                $.ajax({
                    url : "<?php echo site_url('sales/offer_tracking_register/get_all_offer_data');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val = 
                            $('[name="offer_description"]').val(data[i].offer_description);
                        })
                    }
                });
                return false;
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
