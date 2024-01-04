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
        <title>All Campaign Register</title>
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
                                    <h1 class="card-title">TelePhone Call Master</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_telephone'?>"> TelePhone Call Master</a>
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
                                    <!-- general form elements disabled -->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">TelePhone Call Master</h3>
                                            <?php $product_attachment = "csv_example.csv";?>
                                            <button style="width: 200px;  margin: auto;" type="button" class="btn btn-block btn-danger float-right"><a target="_blank" href="<?php echo base_url();?>assets/<?php echo $product_attachment;?>">
                                                    Download Example Sheet</a>
                                            </button>
                                        </div>
                                        <div>
                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="<?php echo base_url().'vw_telephone_contact_create'?>" class="btn btn-block btn-primary">
                                                Create  Register
                                                </a>
                                            </div>
                                            
                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#importModal">Import Contacts</button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div  class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Client Name</th>
                                                            <th>Email id</th>
                                                            <th>Mobile Number</th>
                                                            <th>Company Name</th> 
                                                            <th>State</th>
                                                            <th>City</th>
                                                            <th>Pin Code</th>
                                                            <th>Website</th>
                                                            <th>Source</th>
                                                            <th>Category</th>
                                                            <th>Designation</th>
                                                            <th>Address</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $no = 0;
                                                            foreach ($telephone_list as $row):
                                                                $no++;
                                                                $entity_id = $row->entity_id;
                                                                $Enquiry_status = $row->status;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $no;?></td>
                                                            <td><b><?php echo $row->client_name;?></b></td>
                                                            <td><?php echo $row->email;?></td>
                                                            <td><?php echo $row->mobile;?></td>
                                                            <td><?php echo $row->company_name;?></td>
                                                            <td><?php echo $row->state;?></td>
                                                            <td><?php echo $row->city;?></td>
                                                            <td><?php echo $row->pincode;?></td>
                                                            <td><?php echo $row->website;?></td>
                                                            <td><?php echo $row->source;?></td>
                                                            <td><?php echo $row->category;?></td>
                                                            <td><?php echo $row->designation;?></td>
                                                            <td><?php echo $row->address;?></td>
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
                </div>

            <?php $this->load->view('footer');?>
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <div class="modal fade" id="importModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Upload Csv file</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="client_info" action="<?php echo site_url('master/telephone_master/uploadData');?>" method="post" enctype="multipart/form-data">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="file" name="file" id="file" class="filestyle" data-icon="false">
                                </div>
                            </div> 

                            <div class="col-lg-12">
                                <input type='submit' value='Upload' name='upload'>
                            </div> 
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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