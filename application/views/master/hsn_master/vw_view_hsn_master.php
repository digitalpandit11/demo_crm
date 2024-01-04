<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>View HSN Master </title>
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
    <?php
    $this->load->view('header_sidebar');
    ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->  
    <div class="content-wrapper">
        <!-- Content Wrapper. Contains page content -->
         <section class="content-header">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header" >
                        <h1 class="card-title">HSN Master</h1>
                        <div class="col-sm-12">
                            <br><br>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_hsn_data'?>">HSN Master</a>
                                </li>
                                <li class="breadcrumb-item">View HSN Master</li>
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
                                <h3 class="card-title">View HSL Master Form</h3>
                            </div>
                            <div class="card-body" style="border-radius: 1.25rem;">
                             
                              <?php
                              
                              $entity_id = $sata['entity_id'];
                              $hsn_code = $sata['hsn_code'];  
                              $total_gst_percentage = $sata['total_gst_percentage'];  
                              $cgst = $sata['cgst'];  
                              $sgst = $sata['sgst'];  
                              $igst = $sata['igst'];  
                                                          
                                  ?>
                                <form role="form" name="client_info" action="<?php echo site_url('master/hsn_master/update_hsn_master');?>" method="post">
                                    <div class="row" >

                                        <div class="col-sm-6" style="display: none;"> 
                                          <!-- text input -->
                                          <div class="form-group">
                                            <label>First Name</label>
                                             <input type="text" class="form-control" name="entity_id" id="entity_id" value="<?php echo $entity_id;?>" placeholder="First Name" disabled required="required">
                                          </div>
                                        </div>                                        
                                    </div>

                                    <div class="row">

                                      
                                      <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                          <label>HSN Code</label>
                                          <input type="text" class="form-control" name="hsn_code" id="hsn_code" placeholder="HSN Code" disabled value="<?php echo $hsn_code;?>" required="required">
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                         <div class="form-group">
                                          <label>Total Gst Percentage:</label>
                                          <input type="text" class="form-control" name="total_gst_percentage" id="total_gst_percentage" placeholder="Total Gst Percentage" disabled value="<?php echo $total_gst_percentage;?>" required="required">
                                        </div>

                                    </div>
                                      
                                    </div>

                                <div class="row">

                                    <div class="col-sm-4">    
                                         <div class="form-group">
                                          <label>CGST:</label>
                                          <input type="text" class="form-control" name="cgst" id="cgst" value="<?php echo $cgst;?>"  placeholder="Cgst" disabled required="required">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                          <div class="form-group">
                                          <label>SGST:</label>
                                          <input type="text" class="form-control" name="sgst" id="sgst" value="<?php echo $sgst;?>" placeholder="SGST" disabled required="required">
                                        </div>
                                    </div>

                              

                                    <div class="col-sm-4">
                                          <div class="form-group">
                                          <label>IGST </label>
                                          <input type="text" class="form-control" name="igst" id="igst" value="<?php echo $igst;?>" placeholder="Igst" disabled required="required">
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

<?php
$this->load->view('footer');
?>

<!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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

</body>
</html>
