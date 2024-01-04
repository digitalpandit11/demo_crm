<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- <?php
if(!$_SESSION['user_name'])
{
   header("location:dashboard");
}
?> -->
<!DOCTYPE html>
<html>
    <head>
        
        <!-- <style>    
            th { white-space: nowrap; }
        </style> -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Inventory Detail Report From <?php echo date("d-m-Y", strtotime($timesheet_from_date));?> To <?php echo date("d-m-Y", strtotime($timesheet_to_date));?></title>
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
                                <h1 class="card-title">Inventory Detail Report</h1>
                                <div class="col-sm-6">
                                    <br><br>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_invoice_register_report'?>">Inventory Detail Report</a>
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
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="card">
                                                <div class="card card-success">
                                                    <div class="card-header" >
                                                        <center>
                                                            <h1>Inventory Detail Report From <?php echo date("d-m-Y", strtotime($timesheet_from_date));?> To <?php echo date("d-m-Y", strtotime($timesheet_to_date));?></h1>
                                                        </center>         
                                                    </div> 
                                                </div>  
                                            </div>
                                        </div>
                                    </section>
                                    <div class="card-body">
                                        <div  class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>Sr. No.</th>
                                                        <th>Product ID</th>
                                                        <th>Product Name</th>
                                                        <th>Product Main Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Opening Stock Qty</th>
                                                        <th>Opening Basic Amount</th>
                                                        <th>GRN Qty</th>
                                                        <th>GRN Basic Amount</th>
                                                        <th>Del/Invoice Qty</th>
                                                        <th>Del/Invoice Basic Amount</th>
                                                        <th>Closing Qty</th>
                                                        <th>Closing Basic Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $no = 0;
                                                        $final_amount = 0;
                                                        foreach ($inventory_detail_report_date_wise as $row):

                                                            $entity_id = $row->entity_id;


                                                            $this->db->select('inventory_register_date_sheet.*');
                                                            $this->db->from('inventory_register_date_sheet');
                                                            
                                                            $where = '(inventory_register_date_sheet.entity_id = "'.$entity_id.'" AND inventory_register_date_sheet.user_id = "'.$user_id.'" And inventory_register_date_sheet.date >= "'.$timesheet_from_date.'" And inventory_register_date_sheet.date <= "'.$timesheet_to_date.'")';
                                                            $this->db->where($where);
                                                            $this->db->order_by('inventory_register_date_sheet.entity_id', 'ASC');
                                                            $this->db->limit(1);
                                                            $query = $this->db->get();
                                                            $opening_stock_result = $query->row_array();
                                                            $opening_stock = $opening_stock_result['opening_stock'];
                                                            // print_r($opening_stock);
                                                            // die();


                                                           
                                                          $no++;

                                                        

                                                        
                                                        
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $no;?></td>
                                                        <td>   
                                                            <?php echo $row->product_id;?>
                                                        </td>
                                                        
                                                        <td>  
                                                            <?php echo $row->product_name;?>
                                                        </td>
                                                        
                                                        <td><?php echo $row->category_name;?></td>
                                                        <td>
                                                            <?php echo $row->subcategory_name;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->opening_stock;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->price;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->price;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->price;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->price;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->price;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->price;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->price;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->price;?>
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                   <?php endforeach;?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="card">
                                                <div class="card card-success">
                                                    <div class="card-header" >
                                                        <center>
                                                            <h1>Enquiry Tracking Report From <?php echo date("d-m-Y", strtotime($timesheet_from_date));?> To <?php echo date("d-m-Y", strtotime($timesheet_to_date));?></h1>
                                                        </center>         
                                                    </div> 
                                                </div>  
                                            </div>
                                        </div>
                                    </section>
                                    <div class="card-body">
                                        <div  class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>Sr. No.</th>
                                                        <th>Enq. No.</th>
                                                        <th>Enq. Date</th>
                                                        <th>Customer Name</th>
                                                        <th>Enq Decsription</th>
                                                        <th>Enq Tracking No.</th>
                                                        <th>Enq Tracking Date</th>
                                                        <th>Enq Tracking Description</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $no = 0;
                                                        $final_amount = 0;
                                                        foreach ($enquiry_detail_tracking_report_date_wise as $row):
                                                          
                                                          $no++;
                                                        
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $no;?></td>
                                                        <td>   
                                                            <?php echo $row->enquiry_no;?>
                                                        </td>
                                                        <td> 
                                                            <?php echo date("d-m-Y", strtotime($row->enquiry_date));?>
                                                        </td>
                                                        <td>  
                                                            <?php echo $row->customer_name;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->enquiry_short_desc;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->tracking_number;?>
                                                        </td>
                                                        <td>
                                                            <?php echo date("d-m-Y", strtotime($row->tracking_date));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->tracking_record;?>
                                                        </td>
                                                    </tr>
                                                   <?php endforeach;?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->


                

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
        </script>
        <!-- Page script -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example1').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                } )
            } );
        </script> 

        <script>
            $(document).ready(function() {
                $('#example2').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                } )
            } );
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
