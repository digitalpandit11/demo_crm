<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit City Master</title>
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
                        <h1 class="card-title">City Master</h1>
                        <div class="col-sm-6">
                            <br><br>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_city_data'?>">City Master</a>
                                </li>
                                <li class="breadcrumb-item">Edit City Master Details</li>
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
                                <h3 class="card-title">Edit City Master Info Form</h3>
                            </div>
                            <div class="card-body" style="border-radius: 1.25rem;">
                             
                              <?php
                              $entity_id = $sata['entity_id'];
                              $city_name = $sata['city_name']; 
                              $state_id = $sata['state_id'];
                              
                              ?>
                                <form state="form" name="client_info" action="<?php echo site_url('master/city_master/update_city_master');?>" method="post">
                                    <div class="row" >

                                        <div class="col-sm-6" style="display: none;"> 
                                          <!-- text input -->
                                          <div class="form-group">
                                            <label>First Name</label>
                                             <input type="text" class="form-control" name="entity_id" id="entity_id" value="<?php echo $entity_id;?>" placeholder="First Name" required="required">
                                          </div>
                                        </div>
                                    </div>
                                     <div class="row" >  

                                        <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>State Name</label>
                                            <select class="form-control" style="width: 100%;" id="state_id" name="state_id" required>
                                              <option value="">No Selected</option>
                                              <?php foreach($state as $row):?>
                                              <option value="<?php echo $row->entity_id;?>"><?php echo $row->state_name;?></option>
                                              <?php endforeach;?>
                                            </select>
                                          </div>
                                        </div>
                                

                                 

                                      <div class="col-sm-6">
                                        <div class="form-group">
                                          <label>City Name</label>
                                          <input type="text" class="form-control" name="city_name" id="city_name" placeholder="City Name" value="<?php echo $city_name;?>" required="required">
                                        </div>
                                        
                                      </div>
                                      <input type="hidden" class="form-control" name="hidden_state_id" id="hidden_state_id" value="<?php echo $state_id;?>" placeholder="Photo" required="required">
                                      
                                    </div>

                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success toastrDefaultSuccess">
                                            Update
                                        </button>
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


    <script type="text/javascript">
  $(document).ready(function(){
    get_role_edit();

    function get_role_edit(){
        var hidden_state_id = $('[name="hidden_state_id"]').val();
        $.ajax({
            url : "<?php echo site_url('master/city_master/get_state_id_edit');?>",
            method : "POST",
            data :{hidden_state_id :hidden_state_id},
            async : true,
            dataType : 'json',
            success : function(data){
                $.each(data, function(i, item){
                    console.log(data);
                    $val =
                   
                    $('[name="state_id"]').val(data[i].entity_id).trigger('change');
                   
                });
            }
        });
    }

  });

</script>

</body>
</html>