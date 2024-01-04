<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
   header("location:dashboard");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Enquiry Tracking Report Prompt </title>
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
            <!-- Navbar -->
            <?php $this->load->view('header_sidebar');?>
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->  
            <div class="content-wrapper">
                <!-- Content Wrapper. Contains page content -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header" >
                                <h1 class="card-title">Enquiry Tracking Report</h1>
                                <div class="col-sm-6">
                                    <br><br>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_tracking_report'?>">Enquiry Tracking Report</a>
                                        </li>
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
                                        <h3 class="card-title">Enquiry Tracking Details</h3>
                                    </div>
                                    <div class="card-body" style="border-radius: 1.25rem;">
                                        <form role="form" name="enquiry_tracking_prompt" action="<?php echo site_url('sales/enquiry_tracking_register/check_enquiry_tracking');?>" method="post">

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label> Customer Name *</label>
                                                        <select class="form-control select2bs4"  style="width: 100%;" id="customer_id" name="customer_id">
                                                            <option value="">No Selected</option>
                                                            <?php foreach($customer_list as $row):?>
                                                            <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Select Enquiry Number</label>
                                                        <select class="form-control select2bs4" style="width: 100%;" id="enquiry_id" name="enquiry_id" required>
                                                            <option value="">No Selected</option>
                                                            <?php foreach($list_of_enquiry as $row):?>
                                                            <option value="<?php echo $row->entity_id;?>"><?php echo $row->enquiry_no;?></option>
                                                            <?php endforeach;?>
                                                         </select> 
                                                    </div>
                                                </div> -->

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label> Enquiry Number *</label>
                                                        <select class="form-control select2bs4" style="width: 100%;" id="enquiry_id" name="enquiry_id" required>
                                                            <option value="1" >No Selected</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" style="display: none;">
                                                        <div class="form-group">
                                                            <label> Enquiry Status </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_status" name="enquiry_status"  disabled>
                                                                <option value="0">Please Select</option>
                                                                <option value="1">Pending</option>
                                                                <option value="2">Offer Created</option>
                                                                <option value="3">Order Created</option>
                                                                <option value="4">Enquiry Loss</option>
                                                                <option value="5">Offer Loss</option>
                                                                <option value="6">Order Canceled</option>
                                                            </select>
                                                            <!-- <input type="text" name="enquiry_status" id="enquiry_status" class="form-control" value="" size="50" placeholder="Enquiry Status" readonly> -->
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
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
        <!-- Page script -->
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
            $('#customer_id').change(function(){ 
                var id=$(this).val();
                $.ajax({
                        url : "<?php echo site_url('sales/enquiry_tracking_register/get_all_enquiry');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){
                             
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option></option><option value='+data[i].entity_id+'>'+data[i].enquiry_no+'</option>';
                            }
                            $('#enquiry_id').html(html);
                        }
                        
                        // success: function(response){
                        //     $.each(response,function(index,data){
                        //        $('#enquiry_id').append('<option value="'+data['entity_id']+'">'+data['enquiry_no']+'</option>');
                        //     });
                        // }
                    });
                return false;
            });
        </script>

        <script>
            $('#enquiry_id').change(function(){ 
                var id=$(this).val();
                $.ajax({
                        url : "<?php echo site_url('sales/enquiry_tracking_register/get_all_enquiry_status_data');?>",
                        method : "POST",
                        data : {id: id},
                        async : true,
                        dataType : 'json',
                        success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val =
                            $('[name="enquiry_status"]').val(data[i].enquiry_status).trigger('change');
                            
                        })
                    }
                        
                        // success: function(response){
                        //     $.each(response,function(index,data){
                        //        $('#enquiry_id').append('<option value="'+data['entity_id']+'">'+data['enquiry_no']+'</option>');
                        //     });
                        // }
                    });
                return false;
            });
        </script>    
    </body>
</html>
